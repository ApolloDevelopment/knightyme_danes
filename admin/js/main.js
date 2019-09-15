$(document).ready(() => {

  console.info("admin/js/main.js loaded");
  var active = false;
  $('.more').on('click', function() {
    display = $(this).siblings('.more-options').css('display');
    active = (display == "none") ? true : false;
    if(!active) {
      $(this).siblings('.more-options').toggle();
      active = true;
    } else if(active) {
      $('.more-options').hide();
      $(this).siblings('.more-options').show();
    }
  });

})