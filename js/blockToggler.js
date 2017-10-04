 /*
  * Block toggler
  * v.1.0
  *
  * Guillaume Schaeffer - www.guillaume-schaeffer.fr
  *
  * Builds a link that toggles the display of a block.
  */



$.fn.blockToggler = function(options) {
    var defaults = {
        openText: "show all",
        closeText: "hide all",
    };

    var options = $.extend(defaults, options);

    return this.each(function() {
    	obj = $(this);

		// insert link
	    obj.after('<a href="#" class="suite-action toggler">' + options.openText + '</a>');

		// Random ID
		idRand = Math.floor(Math.random()*100000);

	    // mask the object
	    obj.css('display','none');
	    obj.attr('id', idRand);

	    var moreLink = $('.toggler');
	    var objBlock = obj;

		moreLink.click(function() {
		    if (moreLink.text() == options.openText) {
		        moreLink.text(options.closeText);	
		        objBlock.show('slow');
		    } 
		    else {
		        moreLink.text(options.openText);	
		        //objBlock.hide('slow');
   
		    }


		    return false;
		});

    });




 	

};