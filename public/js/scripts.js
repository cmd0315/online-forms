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
	$('.cancel-btn').hide(); // default for cancel buttons
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
});