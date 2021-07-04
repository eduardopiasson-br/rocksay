// Função para a galeria
(function() {
  var $gallery = new SimpleLightbox('.gallery a', {});
})();

// Slider feedback
new Glide('.glide', {
  type: 'carousel',
  startAt: 0,
  perView: 3,
  autoplay: 5000,
  breakpoints: {
      1024: {
        perView: 2
      },
      600: {
        perView: 1
      }
    }
}).mount();