$(function(){$('.hamburger').click(function(){$(this).toggleClass('active');if($(this).hasClass('active')){$('.first-navi').addClass('active')}else{$('.first-navi').removeClass('active')}});$('.first-navi a[href]').on('click',function(event){$('.hamburger.active').trigger('click')})});