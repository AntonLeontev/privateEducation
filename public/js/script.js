const mainModal = document.querySelector('.auth-modal--main');
const lkBtn = document.querySelector('.user_link');
const page = document.querySelector('.page');

let ps;



const scrollInit = () => {
  if (document.querySelector('.content-block')) {  // чтобы не вылетал в ошибку, если нет блока
    ps = new PerfectScrollbar('.content-block', {
      wheelSpeed: 2,
      wheelPropagation: true,
      minScrollbarLength: 100,
    });
  }
  // if (!mainModal.classList.contains('hidden')) {
  //   ps.destroy();  // это для страничек статичных с окнами
  //   ps = null;
  // }
}
scrollInit();

// открытие/закрытие модалок

lkBtn.addEventListener('click', (e) => {
  e.preventDefault();
  //
  // if (document.querySelector('.content-block')) { // т.е. для всех страниц, кроме index.html
  //   ps.destroy();
  //   ps = null;
  // }

  const escHandler = (e) => {
    if (e.keyCode === 27) mainModal.classList.add('hidden');
    page.removeEventListener('keydown', escHandler);
    if (!ps) scrollInit();
  }

  mainModal.classList.remove('hidden');

  const closeBtnForMain = mainModal.querySelector('.modal-close-btn');
  closeBtnForMain.addEventListener('click', () => {
    mainModal.classList.add('hidden');
    if (!ps) scrollInit();
  })
  page.addEventListener('keydown', escHandler);
})

// открытие Восстановление пароля по ссылке Забыли пароль
const passForgotten = document.querySelector('.modal-password-forgotten');
const restoreModal = document.querySelector('.auth-modal--restore');
const closeBtnForRestore = restoreModal.querySelector('.modal-close-btn');








passForgotten.addEventListener('click', (e)=>{
  e.preventDefault();

  const escHandler = (e) => {
    if (e.keyCode === 27) restoreModal.classList.add('hidden');
    page.removeEventListener('keydown', escHandler);
    if (!ps) scrollInit();
  }

  mainModal.classList.add('hidden');
  restoreModal.classList.remove('hidden');

  closeBtnForRestore.addEventListener('click', () => {
    restoreModal.classList.add('hidden');
    if (!ps) scrollInit();
  })
  page.addEventListener('keydown', escHandler);

  if (document.querySelector('.content-block') && ps) { // т.е. для всех страниц, кроме index.html
    ps.destroy();
    ps = null;
  }


})

// открытие Регистрации по кнопке Регистрация

const regBtn = [...document.querySelectorAll('.modal-auth-btn--reg')];
const loginButton = [...document.querySelectorAll('.modal-auth-btn--user')];
const regModal = document.querySelector('.auth-modal--reg');
const closeBtnForReg = regModal.querySelector('.modal-close-btn');
const continueRegBtn = regModal.querySelector('.auth-modal__reg-btn');



regBtn.forEach((button, i)=>{
  button.addEventListener('click', () => {
    const escHandler = (e) => {
      if (e.keyCode === 27) regModal.classList.add('hidden');
      page.removeEventListener('keydown', escHandler);
      if (!ps) scrollInit();
    }

    mainModal.classList.add('hidden');
    regModal.classList.remove('hidden');

    closeBtnForReg.addEventListener('click', () => {
      regModal.classList.add('hidden');
      if (!ps) scrollInit();
    })
    page.addEventListener('keydown', escHandler);

    if (document.querySelector('.content-block') && ps) { // т.е. для всех страниц, кроме index.html
      ps.destroy();
      ps = null;
    }

    // кнопка Продолжить:

    continueRegBtn.addEventListener('click', (e) => {
      e.preventDefault();
      const continueModal = document.querySelector('.auth-modal--continue');
      const closeBtnForContinue = continueModal.querySelector('.modal-close-btn');

      const escHandler = (e) => {
        if (e.keyCode === 27) continueModal.classList.add('hidden');
        page.removeEventListener('keydown', escHandler);
        if (!ps) scrollInit();
      }
      regModal.classList.add('hidden');
      continueModal.classList.remove('hidden');


      closeBtnForContinue.addEventListener('click', () => {
        continueModal.classList.add('hidden');
        if (!ps) scrollInit();
      })
      page.addEventListener('keydown', escHandler);

      if (document.querySelector('.content-block') && ps) { // т.е. для всех страниц, кроме index.html
        ps.destroy();
        ps = null;
      }

    })
  })
})


loginButton.forEach((e, i)=>{
  e.addEventListener('click', ()=> {
    mainModal.classList.remove('hidden');
    regModal.classList.add('hidden');
  })
})

// Появление надписи "неправильный пароль или имейл" по кнопке Вход



const loginBtn = document.querySelector('.auth-modal__login-btn');
const loginErrorMessage = document.querySelector('.login-error-message');


// const loginBtnFragment = document.querySelector('.auth-modal__login-btn-fragment');
// const loginErrorMessage = document.querySelector('.login-error-message');
//
//

if (loginBtn) {
  loginBtn.addEventListener('click', (e) => {
    e.preventDefault();
    loginErrorMessage.classList.toggle('show');
  })
}

//
// if (loginBtnFragment) {
//   loginBtnFragment.addEventListener('click', (e) => {
//     e.preventDefault();
//     loginErrorMessage.classList.toggle('show');
//   })
// }
//

// скрипт убирает звезду, когда в инпуте появляется текст (и возвращает обратно, когда текст убирается)
const inputWithStarsAll = document.querySelectorAll('.feedback-input--with-star');
inputWithStarsAll.forEach((input) => {
  const starInputLabel = input.closest('.form-placeholder-wrapper').querySelector('.star-input-label');
  input.addEventListener('input', (e) => {
    if (e.target.value !== '') starInputLabel.classList.add('hidden');
    if (e.target.value === '') starInputLabel.classList.remove('hidden');
  })
})


const restoreButton = [...document.querySelectorAll('.js-restore-button')];
const resoreSuccessModal = document.querySelector('.js-restore-success-modal');
restoreButton.forEach((element, index) => {
  element.addEventListener('click', function (event) {
    restoreModal.classList.add('hidden');
    resoreSuccessModal.classList.remove('hidden');
    event.preventDefault();
  })
})


const closeModalBtn = [...document.querySelectorAll('.modal-close-btn')]
closeModalBtn.forEach((el) => {
  el.addEventListener('click', () => {
    let m = el.closest('.auth-modal');
    m.classList.add('hidden');
  })
});


// let fragmentCart = [...document.querySelectorAll('.js-fragment-cart')],
//     fragmentCartModal = document.querySelector('.js-modal-lk-nr-1');
// fragmentCart.forEach((element) => {
//   element.addEventListener('click', function () {
//     fragmentCartModal.classList.remove('hidden');
//   })
// })


