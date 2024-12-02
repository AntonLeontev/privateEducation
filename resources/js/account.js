// для работы со страницей account
// =====================================================================================
const continueRegistrationWindow = document.getElementById('account-password-info-msg');

const passwordRecallWindow = document.getElementById('account-password-recall');
const passwordRecallForms = document.querySelectorAll('#password-reacll-form');
//const loginButton = document.getElementById('login-btn')

const newPasswordMsgWindow = document.getElementById('account-password-new-info-msg')
const newPasswordMsgButtons = document.querySelectorAll('#password-new-info-msg-btn')

const registrationWindow = document.getElementById('account-registration')
const registrationButtons = document.querySelectorAll('#autorization-mode-btn-registration')
const registrationForms = document.querySelectorAll('#registration-form')
const registrationEmailInput = document.getElementById('registration-email-input')
const step = document.getElementById('login-step')

const autorizationWindow = document.getElementById('account-autorization')
const autorizationEmailInput = document.getElementById('autorization-email-input')
const autorizationPasswordInput = document.getElementById('autorization-password-input')
const autorizationErrorMsgs = document.querySelectorAll('#autorization-error-msg')
const autorizationButtons = document.querySelectorAll('#registration-mode-btn-aurorization')
const autorizationForms = document.querySelectorAll('#autorization-form')
const autorizationPasswordRecallButtons = document.querySelectorAll('#autorization-password-recall-btn')

const accountMainWrapper = document.getElementById('account-main-wrapper')

const purchasesWrapper = document.querySelector('.purchases__wrapper')
const tabsButtons = document.querySelectorAll('.tabs__button');
const exitButton = document.getElementById('account-exit-btn')

const dialog = document.getElementById("dialog-login");
const lkButton = document.querySelector('.account-link')

let dialogClose = null;

if(dialog) {
    dialogClose = dialog.querySelector('.dialog__close');

}


if(dialogClose) {
    dialogClose.addEventListener("click", () => {
        dialog.classList.add('popup-dialog-hidden');
    });
    
}



// if (loginButton) {

//     loginButton.addEventListener('click', function () {
//         if(getAuthFromLocalStorage() === 'true') {
//             document.location.href = 'account.html'
//         } else {
//             dialog.classList.remove('popup-dialog-hidden');
//         }
    
//     });
// }


tabsButtons.forEach(btn => {
    btn.addEventListener('click', () => {
        const prevActiveItem = document.querySelector('.tabs__item._active');
        const prevActiveButton = document.querySelector('.tabs__button._active');

        if (prevActiveButton) {
            prevActiveButton.classList.remove('_active');
        }

        if (prevActiveItem) {
            prevActiveItem.classList.remove('_active');
        }
        const nextActiveItemId = `#${btn.getAttribute('data-tab')}`;
        const nextActiveItem = document.querySelector(nextActiveItemId);

        btn.classList.add('_active');
        nextActiveItem.classList.add('_active');
    });
})

let purchasesList = [
    {
        id: '#75641',
        imgPath: 'img/audio.png',
        name: 'Фрагмент &#8470;&nbsp;3',
        date: '10.03.2021'
    },
    {
        id: '#75639',
        imgPath: 'img/audio.png',
        name: 'Фрагмент &#8470;&nbsp;1',
        date: '02.03.2021'
    },
    {
        id: '#75640',
        imgPath: 'img/video.png',
        name: 'Фрагмент &#8470;&nbsp;13',
        date: '02.03.2021'
    },
    {
        id: '#75638',
        imgPath: 'img/audio.png',
        name: 'Фрагмент &#8470;&nbsp;2',
        date: '02.03.2021'
    },
    {
        id: '#75637',
        imgPath: 'img/audio.png',
        name: 'Фрагмент &#8470;&nbsp;4',
        date: '02.03.2021'
    },
    {
        id: '#75637',
        imgPath: 'img/audio.png',
        name: 'Фрагмент &#8470;&nbsp;4',
        date: '02.03.2021'
    },
    {
        id: '#75637',
        imgPath: 'img/audio.png',
        name: 'Фрагмент &#8470;&nbsp;4',
        date: '02.03.2021'
    }
    ,
    {
        id: '#75637',
        imgPath: 'img/audio.png',
        name: 'Фрагмент &#8470;&nbsp;4',
        date: '02.03.2021'
    }
    ,
    {
        id: '#75637',
        imgPath: 'img/audio.png',
        name: 'Фрагмент &#8470;&nbsp;4',
        date: '02.03.2021'
    }
    ,
    {
        id: '#75637',
        imgPath: 'img/audio.png',
        name: 'Фрагмент &#8470;&nbsp;4',
        date: '02.03.2021'
    }
    ,
    {
        id: '#75637',
        imgPath: 'img/audio.png',
        name: 'Фрагмент &#8470;&nbsp;4',
        date: '02.03.2021'
    },
    {
        id: '#75637',
        imgPath: 'img/audio.png',
        name: 'Фрагмент &#8470;&nbsp;4',
        date: '02.03.2021'
    },

]

function purchasesItemCreate(id, imgPath, name, date) {
    let purchasesItem = document.createElement('div');
    purchasesItem.classList.add('purchase-item');
    purchasesItem.innerHTML = `
        <span class="purchase-item__number">
                  ${id}
                </span>
                <div class="purchase-item__box">
                <img src="${imgPath}" alt="icon" class="purchase-item__img">
                <span class="purchase-item__name">
                  ${name}
                </span>
                </div>
                <button class="purchase-item__btn-action">
                  Воспроизвести
                </button>
                <span class="purchase-item__date">
                  ${date}
                </span>
              </div>
        `
    return purchasesItem
}

function purchasesRender(array) {
    for (const item of array) {

        if(purchasesWrapper) {
            purchasesWrapper.append(purchasesItemCreate(item.id, item.imgPath, item.name, item.date))
        }

    }
}

purchasesRender(purchasesList);



function getAuthFromLocalStorage() { 
    let auth
    let data = localStorage.getItem('isAuth') 
    if (data !== '' && data !== null) { 
        auth = data;
    }
    return auth
}

window.addEventListener('DOMContentLoaded', function () {
    if(this.document.location.pathname === '/account.html') {
        if (getAuthFromLocalStorage() === 'true') {
            accountMainWrapper.style.display = "flex"
        } else {
            document.getElementById('dialog-login').style.display = "flex"
            //document.location.href = 'index.html'
        }
    }
})

if(exitButton) {
    exitButton.addEventListener('click', function () {
        dialog.style.display = "flex";
        dialog.style.visibility = 'visible';
        accountMainWrapper.style.display = "none"
        registrationWindow.style.display = "none"
        localStorage.setItem('isAuth', false)
    
    })
}

autorizationErrorMsgs.forEach((msg) => {
    msg.style.display = "flex";
});


if(lkButton) {
    lkButton.addEventListener("click", () => {
        if (getAuthFromLocalStorage() === true) {
            dialog.style.display = "none";
            accountMainWrapper.style.display = "flex"
           
            registrationWindow.style.display = "none";
            continueRegistrationWindow.style.display = "none";
            passwordRecallWindow.style.display = "none";
            newPasswordMsgWindow.style.display = "none";
        } else {
            dialog.style.visibility = 'visible';
            autorizationWindow.style.display = "flex";
            registrationWindow.style.display = "none";
            continueRegistrationWindow.style.display = "none";
            passwordRecallWindow.style.display = "none";
           
            newPasswordMsgWindow.style.display = "none";
    
        }
    });
    
}

autorizationForms.forEach((form) => {
    form.addEventListener('submit', function (e) {
        parent = form.closest('.dialog-login')
        e.preventDefault();
        let emailInput = parent.querySelector('#autorization-email-input');
        let passwordInput = parent.querySelector('#autorization-password-input');
        if (emailInput.value === 'admin@admin.com' && passwordInput.value === 'admin' && parent.id != 'dialog6') {
            localStorage.setItem('isAuth', true)
            document.location.href = 'account.html'
        } else {
            form.reset()
            autorizationErrorMsgs.forEach((msg) => {
                msg.style.display = "flex";
            });
        }
    })
});

// autorizationForm.addEventListener('submit', function (e) {
//     e.preventDefault();
//     if (autorizationEmailInput.value === 'admin@admin.com' && autorizationPasswordInput.value === 'admin') {
//         localStorage.setItem('isAuth', true)
//         document.location.href = 'account.html'
//     } else {
//         autorizationForm.reset()
//         autorizationErrorMsg.style.display = "flex"
//     }
// })




autorizationButtons.forEach((btn) => {
    let parent = btn.closest('.dialog-login')

    btn.addEventListener('click', function () {
        let authorizationWindow = parent.querySelector('#account-autorization');
        let registerWindow = parent.querySelector('#account-registration');
        authorizationWindow.style.display = "flex"
        registerWindow.style.display = "none"
        step.classList.remove('popup-dialog-hidden')
    })
});


registrationButtons.forEach((btn) => {
    let parent = btn.closest('.dialog-login')


    btn.addEventListener('click', function () {
        let authorizationWindow = parent.querySelector('#account-autorization');
        let registerWindow = parent.querySelector('#account-registration');
        authorizationWindow.style.display = "none"
        registerWindow.style.display = "flex"
        step.classList.remove('popup-dialog-hidden')

    })
});

autorizationPasswordRecallButtons.forEach((btn) => {
    let parent = btn.closest('.dialog-login')

    
    btn.addEventListener('click', function () {
        let authorizationWindow = parent.querySelector('#account-autorization');
        let passwordRecallWindow = parent.querySelector('#account-password-recall');
        authorizationWindow.style.display = "none"
        passwordRecallWindow.style.display = "flex"
        step.classList.remove('popup-dialog-hidden')
    })
});

passwordRecallForms.forEach((form) => {
    let parent = form.closest('.dialog-login')
    form.addEventListener('submit', function (e) {
        e.preventDefault(e);
        let passwordRecallInput = parent.querySelector('#password-reacall-input')
        if (passwordRecallInput.value) {
            let passwordRecallWindow = parent.querySelector('#account-password-recall');
            let newPasswordMsgWindow = parent.querySelector('#account-password-new-info-msg');
            newPasswordMsgWindow.style.display = "flex"
            passwordRecallWindow.style.display = "none"
            step.classList.add('popup-dialog-hidden')
        }
    })
});


newPasswordMsgButtons.forEach((btn) => {
    let parent = btn.closest('.dialog-login')
    btn.addEventListener('click', function () {
        let newPasswordMsgWindow = parent.querySelector('#account-password-new-info-msg');
        let autorizationWindow = parent.querySelector('#account-autorization');
        step.classList.remove('popup-dialog-hidden')
        newPasswordMsgWindow.style.display = "none";
        autorizationWindow.style.display = "flex";
        let err = parent.querySelector('#autorization-error-msg')
        err.style.display = "none"
        let passwordRecallForm = parent.querySelector('#password-reacll-form')
        passwordRecallForm.reset()
    })
});

registrationForms.forEach((form) => {
    form.addEventListener('submit', function (e) {
        e.preventDefault(e);
        let parent = form.closest('.dialog-login')
        let registrationEmailInput = parent.querySelector('#registration-email-input')
        if (registrationEmailInput.value) {
            let registrationWindow = parent.querySelector('#account-registration');
            let continueRegistrationWindow = parent.querySelector('#account-password-info-msg');
            registrationWindow.style.display = "none"
            continueRegistrationWindow.style.display = "flex"
            step.classList.add('popup-dialog-hidden')
        }
    })
});


console.log(screen.width, screen.height, window.innerWidth, window.innerHeight)