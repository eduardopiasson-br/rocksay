// Slider index
new Glide('.glide', {
    type: 'carousel',
    startAt: 0,
    perView: 4,
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

// Menu toggle
function myFunction() {
  var x = document.getElementById("myLinks");
  if (x.style.display === "block") {
    x.style.display = "none";
  } else {
    x.style.display = "block";
  }
}
