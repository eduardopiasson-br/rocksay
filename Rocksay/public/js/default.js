const scrollToTopButton = document.getElementById('js-top');

const scrollFunc = () => {
  let y = window.scrollY;
  
  if (y > 0) {
    scrollToTopButton.className = "top-link show";
  } else {
    scrollToTopButton.className = "top-link hide";
  }
};

window.addEventListener("scroll", scrollFunc);

const scrollToTop = () => {
  const c = document.documentElement.scrollTop || document.body.scrollTop;
  
  if (c > 0) {
    window.requestAnimationFrame(scrollToTop);
    window.scrollTo(0, c - c / 2);
  }
};

scrollToTopButton.onclick = function(e) {
  e.preventDefault();
  scrollToTop();
}

// start menu toggle scrypt
$('.show-menu-options').each(function(){
  if(!$(this).hasClass('.menu-ul')){
    $(this).hide()
  }
})

$('.menu').on('click', function(){
  
  $('.show-menu-options').each(function(){
    if(!$(this).hasClass('.menu-ul')){
      $(this).toggle("linear")
    }
  })
})
// end menu toggle scrypt