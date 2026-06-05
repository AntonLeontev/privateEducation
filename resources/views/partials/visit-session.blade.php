<script>
(function () {
    var VISIT_KEY = 'visit_session_id';
    var OPEN_TABS_KEY = 'visit_open_tabs';
    var TAB_ID_KEY = 'visit_tab_id';
    var RELOAD_KEY = 'visit_session_reload_id';
    var HEARTBEAT_KEY = 'visit_tabs_heartbeat';
    var PAGE_HIDE_KEY = 'visit_page_hide_at';
    var syncUrl = @json(route('visit-session.sync'));
    var debugVisit = @json((bool) config('app.debug'));
    var maxSyncAttempts = 25;
    var syncRetryDelayMs = 150;
    var pageHideGraceMs = 2000;
    var heartbeatIntervalMs = 3000;
    var heartbeatMaxAgeMs = 8000;
    var heartbeatTimer = null;

    function getCookie(name) {
        var match = document.cookie.match(new RegExp('(?:^|; )' + name.replace(/[.$?*|{}()[\]\\/+^]/g, '\\$&') + '=([^;]*)'));
        return match ? decodeURIComponent(match[1]) : null;
    }

    function setCookie(name, value) {
        var secure = location.protocol === 'https:' ? '; Secure' : '';
        document.cookie = name + '=' + encodeURIComponent(value) + '; path=/; SameSite=Lax' + secure;
    }

    function clearCookie(name) {
        var secure = location.protocol === 'https:' ? '; Secure' : '';
        document.cookie = name + '=; Max-Age=0; path=/; SameSite=Lax' + secure;
    }

    function uuid() {
        if (window.crypto && crypto.randomUUID) {
            return crypto.randomUUID();
        }
        return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function (c) {
            var r = Math.random() * 16 | 0;
            var v = c === 'x' ? r : (r & 0x3 | 0x8);
            return v.toString(16);
        });
    }

    function isValidVisitId(id) {
        return typeof id === 'string'
            && /^[0-9a-f]{8}-[0-9a-f]{4}-[1-5][0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/i.test(id);
    }

    function getOpenTabs() {
        try {
            var raw = localStorage.getItem(OPEN_TABS_KEY);
            var list = raw ? JSON.parse(raw) : [];
            return Array.isArray(list) ? list : [];
        } catch (e) {
            return [];
        }
    }

    function setOpenTabs(list) {
        localStorage.setItem(OPEN_TABS_KEY, JSON.stringify(list));
    }

    function touchHeartbeat() {
        localStorage.setItem(HEARTBEAT_KEY, String(Date.now()));
    }

    function isHeartbeatFresh() {
        var ts = parseInt(localStorage.getItem(HEARTBEAT_KEY) || '0', 10);
        return !isNaN(ts) && (Date.now() - ts) < heartbeatMaxAgeMs;
    }

    function getReloadVisitId() {
        var id = sessionStorage.getItem(RELOAD_KEY);
        return isValidVisitId(id) ? id : null;
    }

    function setReloadVisitId(visitId) {
        sessionStorage.setItem(RELOAD_KEY, visitId);
    }

    function clearReloadVisitId() {
        sessionStorage.removeItem(RELOAD_KEY);
    }

    function clearPageHideMarker() {
        localStorage.removeItem(PAGE_HIDE_KEY);
    }

    function getTabId() {
        var tabId = sessionStorage.getItem(TAB_ID_KEY);
        if (!tabId) {
            tabId = uuid();
            sessionStorage.setItem(TAB_ID_KEY, tabId);
        }
        return tabId;
    }

    function registerTab(tabId) {
        clearPageHideMarker();
        var tabs = getOpenTabs();
        if (tabs.indexOf(tabId) === -1) {
            tabs.push(tabId);
            setOpenTabs(tabs);
        }
        touchHeartbeat();
    }

    function unregisterTab(tabId) {
        var tabs = getOpenTabs().filter(function (id) {
            return id !== tabId;
        });
        setOpenTabs(tabs);
        return tabs;
    }

    function clearVisitCookieAndStorage() {
        localStorage.removeItem(VISIT_KEY);
        clearCookie(VISIT_KEY);
    }

    function clearVisitSession() {
        clearVisitCookieAndStorage();
        localStorage.removeItem(OPEN_TABS_KEY);
        localStorage.removeItem(HEARTBEAT_KEY);
        clearPageHideMarker();
        clearReloadVisitId();
    }

    function isRecentPageHide() {
        var hideTs = parseInt(localStorage.getItem(PAGE_HIDE_KEY) || '0', 10);
        return !isNaN(hideTs) && (Date.now() - hideTs) < pageHideGraceMs;
    }

    function handlePendingPageHide() {
        var hideTs = parseInt(localStorage.getItem(PAGE_HIDE_KEY) || '0', 10);
        if (!hideTs) {
            return;
        }

        var elapsed = Date.now() - hideTs;

        if (elapsed < pageHideGraceMs) {
            if (debugVisit) {
                console.log('Visit session: recent pagehide, treating as reload');
            }
            return;
        }

        clearPageHideMarker();

        if (getOpenTabs().length === 0 && !isHeartbeatFresh()) {
            clearVisitSession();
            if (debugVisit) {
                console.log('Visit session cleanup', { type: 'delayed' });
            }
        }
    }

    function resolveVisitId() {
        var reloadId = getReloadVisitId();
        if (reloadId) {
            return { id: reloadId, created: false, reason: 'reload' };
        }

        var cookieId = getCookie(VISIT_KEY);
        var sessionActive = isHeartbeatFresh() || isRecentPageHide();

        if (cookieId && isValidVisitId(cookieId) && sessionActive) {
            return { id: cookieId, created: false, reason: 'cookie' };
        }

        if (cookieId || getOpenTabs().length > 0) {
            clearVisitCookieAndStorage();
            localStorage.removeItem(OPEN_TABS_KEY);
            localStorage.removeItem(HEARTBEAT_KEY);
        } else {
            localStorage.removeItem(VISIT_KEY);
        }

        return {
            id: uuid(),
            created: true,
            reason: sessionActive ? 'no_cookie' : 'cold_start',
        };
    }

    function persistVisitId(visitId) {
        setCookie(VISIT_KEY, visitId);
        setReloadVisitId(visitId);
        touchHeartbeat();
    }

    function startHeartbeat() {
        if (heartbeatTimer !== null) {
            return;
        }
        touchHeartbeat();
        heartbeatTimer = setInterval(touchHeartbeat, heartbeatIntervalMs);
    }

    function initVisitSession() {
        var resolved = resolveVisitId();

        persistVisitId(resolved.id);
        clearPageHideMarker();
        runVisitSync(0);

        if (debugVisit && resolved.created) {
            console.log('Visit session started', {
                visitId: resolved.id,
                reason: resolved.reason,
            });
        }
    }

    function runVisitSync(attempt) {
        if (!getCookie(VISIT_KEY)) {
            if (attempt < maxSyncAttempts) {
                setTimeout(function () { runVisitSync(attempt + 1); }, syncRetryDelayMs);
            } else if (debugVisit) {
                console.warn('Visit sync: visit_session_id cookie not ready');
            }
            return;
        }

        var query = window.location.search || '';
        fetch(syncUrl + query, { credentials: 'same-origin' })
            .then(function (response) {
                return response.json().then(function (data) {
                    return { ok: response.ok, status: response.status, data: data };
                });
            })
            .then(function (result) {
                var shouldRetry = !result.ok && attempt < maxSyncAttempts && (
                    result.status === 400
                    || result.status === 404
                    || result.status >= 500
                );

                if (!result.ok && result.status === 400 && result.data && result.data.invalid) {
                    clearVisitSession();
                    initVisitSession();
                    return;
                }

                if (shouldRetry) {
                    setTimeout(function () { runVisitSync(attempt + 1); }, syncRetryDelayMs);
                    return;
                }

                if (debugVisit) {
                    if (result.ok) {
                        console.log('Visit sync', result.data);
                    } else {
                        console.warn('Visit sync failed', result.status, result.data);
                    }
                }
            })
            .catch(function (error) {
                if (attempt < maxSyncAttempts) {
                    setTimeout(function () { runVisitSync(attempt + 1); }, syncRetryDelayMs);
                    return;
                }
                if (debugVisit) {
                    console.warn('Visit sync error', error);
                }
            });
    }

    handlePendingPageHide();

    var tabId = getTabId();
    initVisitSession();
    registerTab(tabId);
    startHeartbeat();

    window.addEventListener('pageshow', function (event) {
        registerTab(tabId);
        if (event.persisted) {
            initVisitSession();
        }
    });

    window.addEventListener('pagehide', function (event) {
        var remainingTabs = unregisterTab(tabId);

        if (event.persisted) {
            return;
        }

        if (remainingTabs.length === 0) {
            localStorage.setItem(PAGE_HIDE_KEY, String(Date.now()));
            clearVisitCookieAndStorage();
            localStorage.removeItem(OPEN_TABS_KEY);
            localStorage.removeItem(HEARTBEAT_KEY);
            if (debugVisit) {
                console.log('Visit session cleanup', { type: 'pagehide' });
            }
        }
    });
})();
</script>
