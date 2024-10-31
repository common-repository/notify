jQuery(function() {
     jQuery( "#slider-range" ).slider({
     	 animate: true,
         range: true,
         min: 0,
         max: 16,
         values: [ notify_fadein, notify_fadeout ],
	         slide: function( event, ui ) {
	      		jQuery('.ui-slider-handle').first().find('span').html('' + ui.values[ 0 ] + ' sec');
	        		jQuery('.ui-slider-handle').next().find('span').html('' + ui.values[ 1 ] + ' sec');
	      
	   			jQuery('#notify_fadein').val('' + ui.values[ 0 ] + '');
	   	  		jQuery('#notify_fadeout').val('' + ui.values[ 1 ] + '');
	   	  		
	   	  		jQuery('.notify_fadein').html('' + ui.values[ 0 ] + '');
	   	  		jQuery('.notify_fadeout').html('' + ui.values[ 1 ] + '');
	   	  	}
     	});
     
				jQuery('.ui-slider-handle').first().append('<span></span>');
				jQuery('.ui-slider-handle').next().append('<span></span>');
				
 		
});
 

jQuery(document).ready(function () {

	setTimeout(function () {
		
		jQuery(".settings-error").fadeOut();   		
		
	}, 750);
	
	
	jQuery('#turnon').click(function() {
		jQuery(this).toggleClass("turnedon");
		var turned = jQuery(this).hasClass("turnedon");
		if(turned == 1){
			jQuery('#notify_turnon').val("1");
	}else{
			jQuery('#notify_turnon').val("0");
	}
	});


			jQuery('.ui-slider-handle').first().find('span').html(jQuery( "#slider-range" ).slider( "values", 0 )+' sec');
			jQuery('.ui-slider-handle').next().find('span').html(jQuery( "#slider-range" ).slider( "values", 1 )+' sec');
			
			jQuery('.ui-slider-handle').next().addClass('secondhandler');
			
			jQuery('#notify_fadein').val(jQuery( "#slider-range" ).slider( "values", 0 )+'');
			jQuery('#notify_fadeout').val(jQuery( "#slider-range" ).slider( "values", 1 )+'');


	setTimeout(function () {
		
			jQuery(".arrow").fadeIn();
		setTimeout(function () {	
			jQuery("#cube").fadeIn('slow');
		}, 800);     	
			
		setTimeout(function () {	
			jQuery("#cube").removeClass('show-back');
			jQuery("#cube").addClass('show-front');
		}, 1000);     		
		
}, notify_fadein*1100);
	setTimeout(function () {
		jQuery("#cube").removeClass('show-front');
		jQuery("#cube").addClass('show-back');	
		jQuery("#cube").fadeOut();	
		jQuery(".arrow").fadeOut();
}, notify_fadeout*1000);

	


// * DONATE DIALOG * //
	
	jQuery.noConflict();
	
	// Position modal box in the center of the page
	jQuery.fn.center = function () {
		this.css("position","absolute");
		this.css("top", ( jQuery(window).height() - this.height() ) / 2+jQuery(window).scrollTop() + "px");
		this.css("left", ( jQuery(window).width() - this.width() ) / 2+jQuery(window).scrollLeft() + "px");
		return this;
	  }
	
	jQuery(".modal-profile").center();
	
	// Set height of light out div	
	jQuery('.modal-lightsout').css("height", jQuery(document).height());	

	// Fade in modal box once link is clicked
	jQuery('a[rel="modal-profile"]').click(function() {
		jQuery('.modal-profile').fadeIn("slow");
		jQuery('.modal-lightsout').fadeTo("slow", .5);
	});
	
	// closes modal box once close link is clicked, or if the lights out divis clicked
	jQuery('a.modal-close-profile, .modal-lightsout').click(function() {
		jQuery('.modal-profile').fadeOut("slow");
		jQuery('.modal-lightsout').fadeOut("slow");
	});



   jQuery(".donate-table td").click(function() {
   	//jQuery("#amount_cont").hide();
      	jQuery(".donate-table td").removeClass("current-donate");
   	jQuery(this).addClass("current-donate");
   	jQuery("#amount").val(jQuery(".current-donate span.price strong").html());
   	jQuery('#amount_cont *').css("color", "#bcdeec");
   	 });
  
   jQuery(".customprice").click(function() {
   	jQuery(".donate-table td").removeClass("current-donate");
      	jQuery("#amount").val('').select();
      	jQuery("#amount_cont").fadeIn();
      	jQuery('#amount_cont *').css("color", "#fff");	
   	 });
     
});     
 
 
 