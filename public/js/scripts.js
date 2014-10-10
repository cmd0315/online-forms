jQuery(document).ready(function($){
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
	* Scroll to list of forms
	*
	*/
	$('#view-forms').on('click', function(e) {
		e.preventDefault(); 
		$('html, body').animate({
		    scrollTop: $("#form-list").offset().top
		}, 2000);
	});
});