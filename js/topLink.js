 /*
  * Top Link
  * v.1.0
  *
  * Guillaume Schaeffer - www.guillaume-schaeffer.fr
  *
  */

$.fn.topLink = function(settings) {
	settings = jQuery.extend({
		min: 100,
		fadeSpeed: 50,
		ieOffset: 20
	}, settings);

	return this.each(function() {
		//listen for scroll
		var el = $(this);
		el.css('display','none');
		$(window).scroll(function() {
			if(!jQuery.support.hrefNormalized) {
				el.css({
					'position': 'absolute',
					'top': $(window).scrollTop() + $(window).height() - settings.ieOffset
				});
			}
			if($(window).scrollTop() >= settings.min)
			{
				el.fadeIn(settings.fadeSpeed);
			}
			else
			{
				el.fadeOut(settings.fadeSpeed);
			}
		});
	});
};