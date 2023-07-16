// правое серое меню
const burgerMenu = document.querySelector('.burger');
const rightMenu = document.querySelector('.right-menu');
const rightMenuCloseBtn = document.querySelector('.right-menu__close-btn');

const menuCloser = (e) => {
  if (!e.target.classList.contains('right-menu__item') && !e.target.classList.contains('right-menu__link')) {
    rightMenu.classList.add('hidden');
    document.removeEventListener('click', menuCloser);
  }
}

burgerMenu.addEventListener('click', (e) => {
  e.stopPropagation();
  rightMenu.classList.remove('hidden');
  document.addEventListener('click', menuCloser);
})

rightMenuCloseBtn.addEventListener('click', () => {
  rightMenu.classList.add('hidden')
})
