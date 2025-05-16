const fadeout = ()=>{
   const loaderWrapper = document.querySelector('.loader-wrap');
   const myHeader = document.querySelector('.my-header');
   loaderWrapper.classList.add('fade-loader');
   myHeader.style.position = 'fixed';
}
window.addEventListener('load', fadeout);