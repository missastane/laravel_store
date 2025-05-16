const fadeout = ()=>{
   const loaderWrapper = document.querySelector('.loader-wrap');
   loaderWrapper.classList.add('fade-loader');
}
window.addEventListener('load', fadeout);