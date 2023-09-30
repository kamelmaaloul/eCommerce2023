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

$('.login-page h1 span').click(function(){
  $(this).addClass('selected').siblings().removeClass('selected');
  $('.login-page form').hide();
  $('.' + $(this).data('class')).fadeIn(100);

});

$('.option span').click(function() {
  $(this).addClass('active').siblings('span').removeClass('active');
  if($(this).data('view')==='full'){
    $('.cat .full-view').fadeIn(200);
  }else {
    $('.cat .full-view').fadeOut(200);

  }
});


  $('.confirm').click(function(){
    return confirm('Are You Sure to Delete ?');
  });

$('.live-name').keyup(function(){
  $('.live-preview .caption h3').text($(this).val());
});
  

$('.live').keyup(function(){
  $($(this).data('class')).text($(this).val());
});
