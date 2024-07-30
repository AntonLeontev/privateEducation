// для работы со страницей account
// =====================================================================================
const continueRegistrationWindow = document.getElementById('account-password-info-msg');

const passwordRecallWindow = document.getElementById('account-password-recall');
const passwordRecallForm = document.getElementById('password-reacll-form');
const passwordRecallInput = document.getElementById('password-reacall-input')

const newPasswordMsgWindow = document.getElementById('account-password-new-info-msg')
const newPasswordMsgButton = document.getElementById('password-new-info-msg-btn')

const registrationWindow = document.getElementById('account-registration')
const registrationButton = document.getElementById('autorization-mode-btn-registration')
const registrationForm = document.getElementById('registration-form')
const registrationEmailInput = document.getElementById('registration-email-input')

const autorizationWindow = document.getElementById('account-autorization')
const autorizationEmailInput = document.getElementById('autorization-email-input')
const autorizationPasswordInput = document.getElementById('autorization-password-input')
const autorizationErrorMsg = document.getElementById('autorization-error-msg')
const autorizationButton = document.getElementById('registration-mode-btn-aurorization')
const autorizationForm = document.getElementById('autorization-form')
const autorizationPasswordRecallButton = document.getElementById('autorization-password-recall-btn')

const accountMainWrapper = document.getElementById('account-main-wrapper')

const purchasesWrapper = document.querySelector('.purchases__wrapper')
const tabsButtons = document.querySelectorAll('.tabs__button');
const exitButton = document.getElementById('account-exit-btn')

const dialog = document.getElementById("dialog1");
const lkButton = document.querySelector('.account-link')

// Проходимся по всем кнопкам
tabsButtons.forEach(btn => {
    // вешаем на каждую кнопку обработчик события клик
    btn.addEventListener('click', () => {
        // Получаем предыдущую активную кнопку
        const prevActiveItem = document.querySelector('.tabs__item._active');
        // Получаем предыдущую активную вкладку
        const prevActiveButton = document.querySelector('.tabs__button._active');

        // Проверяем есть или нет предыдущая активная кнопка
        if (prevActiveButton) {
            //Удаляем класс _active у предыдущей кнопки если она есть
            prevActiveButton.classList.remove('_active');
        }

        // Проверяем есть или нет предыдущая активная вкладка
        if (prevActiveItem) {
            // Удаляем класс _active у предыдущей вкладки если она есть
            prevActiveItem.classList.remove('_active');
        }
        // получаем id новой активной вкладки, который мы перем из атрибута data-tab у кнопки
        const nextActiveItemId = `#${btn.getAttribute('data-tab')}`;
        // получаем новую активную вкладку по id
        const nextActiveItem = document.querySelector(nextActiveItemId);

        // добавляем класс _active кнопке на которую нажали
        btn.classList.add('_active');
        // добавляем класс _active новой выбранной вкладке
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

        purchasesWrapper.append(purchasesItemCreate(item.id, item.imgPath, item.name, item.date))
    }
}

purchasesRender(purchasesList);



function getAuthFromLocalStorage() { // ф-я получения данных с локалсториджа
    let auth
    let data = localStorage.getItem('isAuth') // достаем данные из локалсторидж по ключу объекты
    if (data !== '' && data !== null) { // если пришли данные не пустые, тогда записываем их в наш общий массив, иначе будет ошибка
        auth = data;
    }
    return auth
}

window.addEventListener('DOMContentLoaded', function () {
    if (getAuthFromLocalStorage() === 'true') {
        dialog.style.display = "none";
        accountMainWrapper.style.display = "flex"
        autorizationErrorMsg.style.display = "none"
    } else {
        dialog.style.visibility = 'visible';
        autorizationWindow.style.display = "flex"
        registrationWindow.style.display = "none";
        continueRegistrationWindow.style.display = "none"
        passwordRecallWindow.style.display = "none"
        autorizationErrorMsg.style.display = "none"
        newPasswordMsgWindow.style.display = "none"

    }
})

exitButton.addEventListener('click', function () {
    dialog.style.display = "flex";
    dialog.style.visibility = 'visible';
    accountMainWrapper.style.display = "none"
    registrationWindow.style.display = "none"
    localStorage.setItem('isAuth', false)

})

lkButton.addEventListener("click", () => {
    if (getAuthFromLocalStorage() === true) {
        dialog.style.display = "none";
        accountMainWrapper.style.display = "flex"
        autorizationErrorMsg.style.display = "none"
        registrationWindow.style.display = "none";
        continueRegistrationWindow.style.display = "none";
        passwordRecallWindow.style.display = "none";
        autorizationErrorMsg.style.display = "none";
        newPasswordMsgWindow.style.display = "none";
    } else {
        dialog.style.visibility = 'visible';
        autorizationWindow.style.display = "flex";
        registrationWindow.style.display = "none";
        continueRegistrationWindow.style.display = "none";
        passwordRecallWindow.style.display = "none";
        autorizationErrorMsg.style.display = "none";
        newPasswordMsgWindow.style.display = "none";

    }
});

autorizationForm.addEventListener('submit', function (e) {
    e.preventDefault();

    if (autorizationEmailInput.value === 'admin@admin.com' && autorizationPasswordInput.value === 'admin') {
        dialog.style.display = "none";
        accountMainWrapper.style.display = "flex"
        autorizationErrorMsg.style.display = "none"

        autorizationForm.reset()

        localStorage.setItem('isAuth', true)

    } else {
        autorizationErrorMsg.style.display = "flex"
    }

})

autorizationButton.addEventListener('click', function () {
    autorizationWindow.style.display = "flex"
    registrationWindow.style.display = "none"
})

autorizationPasswordRecallButton.addEventListener('click', function () {
    autorizationWindow.style.display = "none"
    passwordRecallWindow.style.display = "flex"
})

passwordRecallForm.addEventListener('submit', function (e) {
    e.preventDefault(e);
    if (passwordRecallInput.value) {
        newPasswordMsgWindow.style.display = "flex"
        passwordRecallWindow.style.display = "none"
    }
})

newPasswordMsgButton.addEventListener('click', function () {
    newPasswordMsgWindow.style.display = "none";
    autorizationWindow.style.display = "flex";
    autorizationErrorMsg.style.display = "none"
    passwordRecallForm.reset()
})

registrationButton.addEventListener('click', function () {
    autorizationWindow.style.display = "none"
    registrationWindow.style.display = "flex"
})

registrationForm.addEventListener('submit', function (e) {
    e.preventDefault(e);
    if (registrationEmailInput.value) {
        registrationWindow.style.display = "none"
        continueRegistrationWindow.style.display = "flex"
    }
})

// дебаггинг смены экранной ориентации на FF в мобиле

// console.log(document.querySelectorAll('input'))

let allInputs = document.querySelectorAll('input')
allInputs.forEach((e) => {
    e.addEventListener('focus', function () {
        if (window.matchMedia("(orientation: portrait)").matches) {
            Screen.lockOrientation('portrait-primary')
        }
    })
})

// window.addEventListener('orientationchange', function () {
//     if (window.matchMedia("(orientation: portrait)").matches) {
//         Screen.lockOrientation('portrait-primary')
//     }
// });

// // First we get the viewport height and we multiple it by 1% to get a value for a vh unit
// let vh = window.innerHeight * 0.01;
// // Then we set the value in the --vh custom property to the root of the document
// document.documentElement.style.setProperty('--vh', `${vh}px`);