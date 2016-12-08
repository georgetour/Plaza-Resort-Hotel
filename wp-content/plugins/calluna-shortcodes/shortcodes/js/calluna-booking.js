jQuery(document).ready(function() {
	jQuery('.ui-datepicker-div').css('zIndex', 999999);
	jQuery('.guests').css('zIndex', 999999);
	/* Set calendar numerics */
	function setCalendar(selectedDate, selector){
		var dateInfo = selectedDate.split("-");
		jQuery(selector+' .day').text(dateInfo[2]);
		jQuery(selector+' .month').text(dateInfo[1]);
	}

	/* End of Set calendar numerics */

	/* Gaste select */
	jQuery('#gaste').hover(function(){
		jQuery('.guests').fadeIn('fast');
	}, function() {
		jQuery('.guests').fadeOut('fast');
	});

	jQuery('#gasteSelect li').click(function(){
		var gasteValue = jQuery(this).text();
		jQuery("#gasteCount").text(gasteValue);
		//var str1 = '_0_0';
		//var formattedGuestsValue = gasteValue.concat(str1);
		jQuery('input[id*="hfAdults"]').val(gasteValue);

		jQuery('.guests').fadeOut('fast');
		jQuery('#gasteSelect li').removeClass('active');
		jQuery(this).addClass('active');
	});
	/* Gaste select end */

	/* Von datepicker */
	jQuery('#vondatepicker').datepicker({
		altField: '#from',
		//altFormat: "yymmdd_0000",
		minDate: 0,
		onSelect: function(selectedDate) {

			var maxDate = new Date(Date.parse(jQuery(this).datepicker( "getDate" )));
			maxDate.setDate(maxDate.getDate() + 1);
			jQuery('#bisdatepicker').datepicker( "option", "minDate", maxDate );

			jQuery("#bisdatepicker").hide();
			jQuery('#vondatepicker').hide();

			var fromDateConvert = new Date( jQuery(this).datepicker('getDate').getTime() );
			var fromDate = jQuery.datepicker.formatDate( 'yy-MM-dd', new Date(fromDateConvert) );
			setCalendar(fromDate, "#von");

			var toDateConvert = new Date(jQuery('#bisdatepicker').datepicker('getDate').getTime());
			var bisDate = jQuery.datepicker.formatDate( 'yy-MM-dd', new Date(toDateConvert) );
			setCalendar(bisDate, "#bis");
		}
	});
	jQuery('#vondatepicker').addClass('abs');
	jQuery('#vondatepicker').hide();
	jQuery('#von').hover(function(){
		jQuery('#vondatepicker').show();
	}, function() {
		jQuery('#vondatepicker').hide();
	});
	/* Von datepicker end */

	/* Bis datepicker */
	jQuery('#bisdatepicker').datepicker({
		defaultDate: "+1d",
		altField: '#to',
		//altFormat: 'yymmdd_0000',
		onSelect: function( selectedDate ) {

			jQuery( "#vondatepicker" ).datepicker( "option", "maxDate", selectedDate );

			jQuery( "#vondatepicker" ).hide();
			jQuery('#bisdatepicker').hide();

			var toDateConvert = new Date(jQuery('#bisdatepicker').datepicker('getDate').getTime());
			var bisDate = jQuery.datepicker.formatDate( 'yy-MM-dd', new Date(toDateConvert) );
			setCalendar(bisDate, "#bis");
		}
	});
	jQuery('#bisdatepicker').addClass('abs');
	jQuery('#bisdatepicker').hide();
	jQuery('#bis').hover(function(){
		jQuery('#bisdatepicker').fadeIn('fast');
	}, function() {
		jQuery('#bisdatepicker').fadeOut('fast');
	});
	/* Bis datepicker end */

	/* Set today in calendar */
	var fromDateConvert = new Date( jQuery('#vondatepicker').datepicker('getDate').getTime() );
	var fromDate = jQuery.datepicker.formatDate( 'yy-MM-dd', new Date(fromDateConvert) );
	setCalendar(fromDate, "#von");

	var toDateConvert = new Date(jQuery('#bisdatepicker').datepicker('getDate').getTime());
	var bisDate = jQuery.datepicker.formatDate( 'yy-MM-dd', new Date(toDateConvert) );
	setCalendar(bisDate, "#bis");
	/* end of Set today in calendar */

});