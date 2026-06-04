<script>
(function () {
    var VISIT_KEY = 'visit_session_id';
    var OPEN_TABS_KEY = 'visit_open_tabs';
    var TAB_ID_KEY = 'visit_tab_id';
    var syncUrl = @json(route('visit-session.sync'));
    var debugVisit = @json((bool) config('app.debug'));
    var maxSyncAttempts = 25;
    var syncRetryDelayMs = 150;
    var tabCloseCleanupDelayMs = 1500;
    var cleanupTimer = null;

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

    function getTabId() {
        var tabId = sessionStorage.getItem(TAB_ID_KEY);
        if (!tabId) {
            tabId = uuid();
            sessionStorage.setItem(TAB_ID_KEY, tabId);
        }
        return tabId;
    }

    function registerTab(tabId) {
        cancelVisitCleanup();
        var tabs = getOpenTabs();
        if (tabs.indexOf(tabId) === -1) {
            tabs.push(tabId);
            setOpenTabs(tabs);
        }
    }

    function unregisterTab(tabId) {
        var tabs = getOpenTabs().filter(function (id) {
            return id !== tabId;
        });
        setOpenTabs(tabs);
        return tabs;
    }

    function getStoredVisitId() {
        return getCookie(VISIT_KEY) || localStorage.getItem(VISIT_KEY);
    }

    function persistVisitId(visitId) {
        localStorage.setItem(VISIT_KEY, visitId);
        setCookie(VISIT_KEY, visitId);
    }

    function clearVisitSession() {
        localStorage.removeItem(VISIT_KEY);
        clearCookie(VISIT_KEY);
    }

    function cancelVisitCleanup() {
        if (cleanupTimer !== null) {
            clearTimeout(cleanupTimer);
            cleanupTimer = null;
        }
    }

    function scheduleVisitCleanupIfNoTabs() {
        cancelVisitCleanup();
        cleanupTimer = setTimeout(function () {
            cleanupTimer = null;
            if (getOpenTabs().length === 0) {
                clearVisitSession();
                if (debugVisit) {
                    console.log('Visit session ended (all tabs closed)');
                }
            }
        }, tabCloseCleanupDelayMs);
    }

    function initVisitSession() {
        var visitId = getStoredVisitId();
        var created = false;

        if (!visitId) {
            visitId = uuid();
            created = true;
        }

        persistVisitId(visitId);
        runVisitSync(0);

        if (debugVisit && created) {
            console.log('Visit session started', { visitId: visitId });
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

    var tabId = getTabId();
    registerTab(tabId);
    initVisitSession();

    window.addEventListener('pageshow', function (event) {
        registerTab(tabId);
        if (event.persisted) {
            initVisitSession();
        }
    });

    window.addEventListener('pagehide', function (event) {
        if (event.persisted) {
            return;
        }

        var remainingTabs = unregisterTab(tabId);
        if (remainingTabs.length === 0) {
            scheduleVisitCleanupIfNoTabs();
        }
    });
})();
</script>
