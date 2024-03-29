// Função para a galeria
(function() {
  var $gallery = new SimpleLightbox('.gallery a', {});
})();

// Slider more products
new Glide('.glide-post', {
  type: 'carousel',
  startAt: 0,
  perView: 3,
  // autoplay: 5000,
  breakpoints: {
      1024: {
        perView: 3
      },
      800: {
        perView: 2
      },
      500: {
        perView: 1
      }
    }
}).mount();
