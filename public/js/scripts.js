jQuery(document).ready(function($){
	/*
	* Multi-select
	*/
	$('.multiple-select').multiselect();

	/*
	* display floating flash message
	*
	*/
	$(".flash-msg").fadeIn('slow').delay(5000).fadeOut('slow');
	
	/**
	* input in sync department id based on department name
	*
	*/
	 $('#department_name').on('keydown', function(event){
		var key = String.fromCharCode(event.which);
		if (!event.shiftKey) {
			key = key.toLowerCase();
		}
		var departmentID = $(this).val() + key;
		departmentID = 'D-' + departmentID.toUpperCase();
		departmentID = departmentID.substring(0,6);
		$('#department_id').val(departmentID);
		$('#department_id').attr('readonly', false);
    });

	/**
	* For removing table items
	*
	**/
	$('#cancel-btn1').hide(); // default for cancel button in the button group
	$('#remove-btn').on('click', function() {
		$('.btn-delete').show();
		$('.cancel-btn').show();
		$(this).hide();
    });

    $('.cancel-btn').on('click', function() {
		$('.btn-delete').hide();
		$('#cancel-btn1').hide();
		$('#remove-btn').show();
    });

	 $('.btn-delete').on('click', function(){
	 	var value = $(this).val();
	 	var employee_name = $(this).attr('id');
	 	$("#modal-form").attr("action", value);
	 	$("#subject-name").html(employee_name);
	 	$('#myModal').modal('show');
	 });

	/**
	* Require CE number if client is BCD or newbusiness
	*
	**/
	$('#charge_to').on('change', function() {
		var clientID = $(this).val();
		if(clientID !== 'BCD') {
			$('#check_num').attr('required', true);
		}
		else {
			$('#check_num').attr('required', false);
		}
	});


	/**
	* Open or close reasons for request rejection
	*
	*/
	$('#radio-reject').on('click', function(e) {
		$('#reject-reasons').show();

		/**
		* Disable submit if form is rejected but no reject reasons were selected
		*/
		var rejectCheckboxes = $("input[type='checkbox']"),
	    submitButt = $("button[type='submit']");
		submitButt.attr("disabled", !rejectCheckboxes.is(":checked"));

		rejectCheckboxes.click(function() {
		    submitButt.attr("disabled", !rejectCheckboxes.is(":checked"));
		});
	})

	if($('#radio-reject').is(':checked')) {
		$('#reject-reasons').show();
	}

	$('#radio-approve').on('click', function(e) {
		$('#reject-reasons').hide();
	})

	$('.export').click(function() {
	   var exportLink = this.id;

	   $.ajax(
		{
		  type: 'GET',
		  url: exportLink, data: {}, 
		  beforeSend: function(XMLHttpRequest)
		  {
	   		$('.progress-div').show();

		  },

		  success: function(data){
		    // successful completion handler
		    $('.progress-div').hide();
		    window.location = exportLink;
		  }
		});
	});


	/**
	* Scroll to list of forms
	*
	*/
	$('#view-forms').on('click', function(e) {
		e.preventDefault(); 
		$('html, body').animate({
		    scrollTop: $("#form-list").offset().top
		}, 2000);
	});

	queryString = window.location.search;
	if(queryString.length) {
		$('html, body').animate({
	        scrollTop: $('#form-list').offset().top
	    }, 'slow');
	}

});