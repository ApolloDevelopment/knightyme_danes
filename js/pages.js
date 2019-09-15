$(document).ready(() => {
  $('.card-div-top').on('mouseenter', function(){
    $(this).children().fadeToggle('fast');
  }).on('mouseleave', function(){
    $(this).children().fadeToggle('fast');
  });
});


// Open/Show Slides
function slide_show(img) {
  var slideshow = document.getElementById("slideShow");
  slideshow.style.display = "block";
  slideshow.innerHTML += ` <div class="slideshow-img" style="background-image:url('`+img+`');"></div> `;
}
// Close Slides
function close_slides() {
  var slideshow = document.getElementById("slideShow");
  slideshow.style.display = "none";
  slideshow.innerHTML = `
    <div class="closeSlides" id="close_slides" onclick="close_slides()">&times;</div>
  `;
}
