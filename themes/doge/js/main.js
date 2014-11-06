$(document).ready(function(){
	$('.slide_home').bxSlider({
		minSlides: 1,
		maxSlides: 1,
		pager: false,
		auto:false,
		speed: 1000,
		pager: false,
		preloadImages: 'all',
		easing: 'ease-in-out'
	});
});

$(window).load(function(){
	titleHome();	
});

function titleHome(){
	if($('#home h2').length){
		var maxHeight = 0;
		$('#home h2').each(function(){
			var thisHeight = $(this).height();
			if( thisHeight > maxHeight){
				maxHeight = thisHeight;
			}
		});
		$('#home h2').height(maxHeight);
	}
}