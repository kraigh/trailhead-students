(function ($) {$(document).ready(function() {

  $(document).on('click', '.focus', function(){
    var id = $(this).attr('data-target-id');
    // Let's unbind the scroll function now, to account for nav clicks while a panel is in focus.
    $(window).unbind();
    // Initialize scrolled variable.
    var scrolled = 0;
    // Start scrollin'
    $.smoothScroll({
      scrollElement: null,
      scrollTarget: '#'+id,
      offset: -70,
      afterScroll: function() {
        $(window).bind("scroll", function() {
          scrolled++;
          if (scrolled > 10) {
            closeBg(id);
            $(window).unbind();
            scrolled = 0;
          }
        });
      }
    });
    // Set all panel divs to default style, in case one is currently in focus
    $('div.panel').css({
      'z-index': '0',
      'position': 'static',
      '-webkit-box-shadow': 'none',
      '-moz-box-shadow': 'none',
      'box-shadow': 'none'
    });
    // Bring the desired panel div into focus
    $('div.panel#' + id).css({
      'z-index': '999',
      'position': 'relative',
      '-webkit-box-shadow': '0px 0px 30px rgba(0, 0, 0, 0.32)',
      '-moz-box-shadow': '0px 0px 30px rgba(0, 0, 0, 0.32)',
      'box-shadow': '0px 0px 30px rgba(0, 0, 0, 0.32)'
    });
    // RELEASE THE UNDERLAY
    if (!$('#modal-underlay').length) {
      $('body').append('<div id="modal-underlay" onclick="closeBg(\''+id+'\');"></div>');
      $('#modal-underlay').height( $('html').outerHeight() ).fadeTo(100, 0.5);
    };

  });

});})(jQuery);

function closeBg(id) {
  $ = jQuery;
  // Kill the underlay
  $('#modal-underlay').fadeOut(100, function() {
    $('#modal-underlay').remove();
  });
  // Reset our target panel
  $('div.panel#' + id).css({
    'z-index': '0',
    'position': 'static',
    '-webkit-box-shadow': 'none',
    '-moz-box-shadow': 'none',
    'box-shadow': 'none'
  });
}
