let params = new URLSearchParams(document.location.search.substring(1));
let category = params.get("categoria") ? params.get("categoria") : 'todos';

$('.div-products a').each(function(){
  if(!$(this).hasClass(category)){
    $(this).hide('slow')
  }else{
    $(this).show('slow')
  }
})

// faq de pagamento
var acc = document.getElementsByClassName("accordion");
var i;

for (i = 0; i < acc.length; i++) {
  acc[i].addEventListener("click", function() {
    this.classList.toggle("active");
    var panel = this.nextElementSibling;
    if (panel.style.display === "block") {
      panel.style.display = "none";
    } else {
      panel.style.display = "block";
    }
  });
}

// Botão de categorias
$('.redirects-button').on('click', function(){
  var categoria = $(this).attr('data-categoria')
  
  $('.div-products a').each(function(){
    if(!$(this).hasClass(categoria)){
      $(this).hide('slow')
    }else{
      $(this).show('slow')
    }
  })
})
