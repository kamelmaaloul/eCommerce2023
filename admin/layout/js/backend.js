$(function(){
    'use strict';
    // Triggle selectBoxIt
    $("select").selectBoxIt({
      autoWidth: false
  
  });

    $('[placeholder]').focus(function(){
        $(this).attr('data-text',$(this).attr('placeholder'));
        $(this).attr('placeholder', '');
    }).blur(function(){
        $(this).attr('placeholder', $(this).attr('data-text'));
  
    });

    
});

$('.cat h3').click(function() {
  $(this).next('.full-view').fadeToggle(500);
});

$('.option span').click(function() {
  $(this).addClass('active').siblings('span').removeClass('active');
  if($(this).data('view')==='full'){
    $('.cat .full-view').fadeIn(200);
  }else {
    $('.cat .full-view').fadeOut(200);

  }
});


$(".toggle-password").click(function() {

    $(this).toggleClass("fa-eye fa-eye-slash");
    var input = $($(this).attr("toggle"));
    if (input.attr("type") == "password") {
      input.attr("type", "text");
    } else {
      input.attr("type", "password");
    }
  });

  $('.confirm').click(function(){
    return confirm('Are You Sure to Delete ?');
  });


  