@extends('layouts.app.app')

@section('title', 'Вход в админ панель')

@section('css')
    <link rel="stylesheet" href="/css/account.css" />
@endsection

@section('content')
    <script>
		document.addEventListener('alpine:init', () => {
			Alpine.data('authModal', () => ({
				section: 'login', 
				
				login() {
					this.$refs.loginError.style.display = 'none'
					let data = new FormData(this.$event.target)

					axios
						.post(route('admin.login.store'), data)
						.then(response => {
							this.$refs.email.value = data.get('email')
							this.section = '2factor'
							this.$refs.code.innerText = response.data.code
						})
						.catch(error => {
							this.$refs.loginError.innerText = 'Не удалось войти в аккаунт, введенные логин или пароль неверны'
							this.$refs.loginError.style.display = 'block'
						})
				},
				checkCode() {
					let data = new FormData(this.$event.target)

					axios
						.post(route('admin.two-factor.check'), data)
						.then(response => {
							location.href = response.data.redirect;
						})
						.catch(error => {
							this.$refs.codeError.innerText = error.response.data.message
						})
				},
			}))
		})
	</script>

	<main>
        <div class="main">
            <div class="container">
                {{-- @include('partials.app.header')

                @include('partials.app.sidebar') --}}

                <div id="dialog1" class="" style="visibility: visible" x-data="authModal">
                    <div class="dialog__top" style="align-items: center">
                        <h4>Вход в административную панель</h4>
                        <a class="dialog__close" href="{{ route('home') }}" style="margin-top: 0">

                        </a>
                    </div>
                    <div class="dialog__center" x-show="section === 'login'">
                        <!-- для авторизации -->
                        <div id="account-autorization" class="dialog__autorization autorization" x-show="section === 'login'">
                            <h3 class="autorization__title">
                                {{ __('login.auth') }}
                            </h3>
                            <form id="autorization-form" class="autorization__form" @submit.prevent="login">
                                <span class="autorization__label">
                                    {{ __('login.email') }}:
                                </span>
                                <input id="autorization-email-input" type="text" class="autorization__input"
                                    placeholder="* * * * * * * * * * * * * * * * *" name="email">
                                <div class="autorization__wrapper">
                                    <span class="autorization__label">
                                        {{ __('login.password') }}:
                                    </span>

                                </div>
                                <input id="autorization-password-input" type="password" class="autorization__input"
                                    placeholder="* * * * * * * * * * * * * * * * *" name="password">
                                <span id="autorization-error-msg" class="autorization__error-msg" x-ref="loginError">
									{{ __('login.error_message') }}
								</span>
                                <button type="submit" id="autorization-submit-btn" class="autorization__submit-btn">
                                    {{ __('login.login_btn') }}
                                </button>
                            </form>
                        </div>
                    </div>
                    <div class="dialog__center">
                        <!-- для кода из почты -->
                        <div id="account-autorization" class="dialog__autorization autorization" x-show="section === '2factor'">
                            <h3 class="autorization__title">
                                Введите код из почты
                            </h3>
                            <form id="autorization-form" class="autorization__form" @submit.prevent="checkCode">
								<input type="hidden" name="email" x-ref="email">
                                <span class="autorization__label">
                                    Код для входа:
                                </span>
                                <input id="autorization-email-input" type="text" class="autorization__input"
                                    name="code">
								<div class="login-error-message" x-ref="codeError"></div>
                                <button type="submit" id="autorization-submit-btn" class="autorization__submit-btn">
                                    {{ __('login.login_btn') }}
                                </button>
								<div x-ref="code" style="margin-top: 25px"></div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    {{-- <script src="/js/app.bundle.js"></script> --}}
	<script>
		const isDesktop = () => {
    let _window;

    const navigatorAgent =
        navigator.userAgent ||
        navigator.vendor ||
        ((_window = window) === null || _window === void 0
            ? void 0
            : _window.opera);
    return !(
        /(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series([46])0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino|android|ipad|playbook|silk/i.test(
            navigatorAgent
        ) ||
        /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br([ev])w|bumb|bw-([nu])|c55\/|capi|ccwa|cdm-|cell|chtm|cldc|cmd-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc-s|devi|dica|dmob|do([cp])o|ds(12|-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly([-_])|g1 u|g560|gene|gf-5|g-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd-([mpt])|hei-|hi(pt|ta)|hp( i|ip)|hs-c|ht(c([- _agpst])|tp)|hu(aw|tc)|i-(20|go|ma)|i230|iac([ \-/])|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja([tv])a|jbro|jemu|jigs|kddi|keji|kgt([ /])|klon|kpt |kwc-|kyo([ck])|le(no|xi)|lg( g|\/([klu])|50|54|-[a-w])|libw|lynx|m1-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t([- ov])|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30([02])|n50([025])|n7(0([01])|10)|ne(([cm])-|on|tf|wf|wg|wt)|nok([6i])|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan([adt])|pdxg|pg(13|-([1-8]|c))|phil|pire|pl(ay|uc)|pn-2|po(ck|rt|se)|prox|psio|pt-g|qa-a|qc(07|12|21|32|60|-[2-7]|i-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h-|oo|p-)|sdk\/|se(c([-01])|47|mc|nd|ri)|sgh-|shar|sie([-m])|sk-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h-|v-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl-|tdg-|tel([im])|tim-|t-mo|to(pl|sh)|ts(70|m-|m3|m5)|tx-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c([- ])|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas-|your|zeto|zte-/i.test(
            navigatorAgent.substr(0, 4)
        )
    );
};


		let cont = document.querySelector(".container");
window.addEventListener("resize", () => {
    if (isDesktop()) {
        scale();
    }
});

function scale(event) {
    try {
        if (event) {
            event.stopPropagation();
            event.preventDefault();
        }
        let width = document.body.clientWidth;
        let height = document.body.clientHeight;
        let coeff;

        if (
            width > 1024 ||
            (width > 700 &&
                isTablet() &&
                window.matchMedia("(orientation: portrait)").matches)
        ) {
            if (width / height > 16 / 9) {
                coeff = height / 1080;
            } else {
                coeff = width / 1920;
            }
            cont.style.transform = `scale(${coeff})`;
        }
    } catch (e) {
        alert(e);
    }
}

scale();
	</script>

@endsection
