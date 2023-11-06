
function showSlides() {  var i;
    var slides = document.getElementsByClassName("mySlides");
    var dots = document.getElementsByClassName("dot");
    for (i = 0; i < slides.length; i++) {
      slides[i].style.display = "none";
    }
    slideIndex++;
    if (slideIndex > slides.length) {slideIndex = 1}
    for (i = 0; i < dots.length; i++) {
      dots[i].className = dots[i].className.replace(" active", "");
    }
    slides[slideIndex-1].style.display = "block";
    dots[slideIndex-1].className += " active";
    setTimeout(showSlides, 2000); // Change image every 2 seconds
}

function showSlides_main() {  var i;
  var slides = document.getElementsByClassName("mySlides_main");
  var dots = document.getElementsByClassName("dot_main");
  for (i = 0; i < slides.length; i++) {
    slides[i].style.display = "none";
  }
  slideIndex_main++;
  if (slideIndex_main > slides.length) {slideIndex_main = 1}
  for (i = 0; i < dots.length; i++) {
    dots[i].className = dots[i].className.replace(" active", "");
  }
  slides[slideIndex_main-1].style.display = "block";
  dots[slideIndex_main-1].className += " active";
  setTimeout(showSlides_main, 2000); // Change image every 2 seconds
}