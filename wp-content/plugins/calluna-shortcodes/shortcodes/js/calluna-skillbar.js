jQuery(function($){
	$(document).ready(function(){
		$('.calluna-skillbar').each(function(){
			$(this).find('.calluna-skillbar-bar').animate({ width: $(this).attr('data-percent') }, 800 );
		});
	});
});