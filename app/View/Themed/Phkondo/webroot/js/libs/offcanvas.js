$(document).ready(function () {
  $('[data-toggle="offcanvas"]').click(function () {
    $('.row-offcanvas').toggleClass('active')
  });
  
  if (!$('#sidebar').length) {
        $('[data-toggle="offcanvas"]').hide();

    }
  
});