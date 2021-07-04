// Slider feedback
new Glide('.glide', {
    type: 'carousel',
    startAt: 0,
    perView: 0,
    // autoplay: 5000,
    breakpoints: {
        1024: {
          perView: 2
        },
        600: {
          perView: 1
        }
      }
  }).mount();
