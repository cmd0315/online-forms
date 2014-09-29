jQuery(document).ready(function($){
	$(".flash-msg").fadeIn('slow').delay(5000).fadeOut('slow');
	

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

	$('#remove-btn').on('click', function() {
		$('.btn-delete').css('display', 'inline-block');
		$(this).css('display', 'none');
		$('#cancel-btn').css('display', 'inline-block');
    });

    $('#cancel-btn').on('click', function() {
		$('.btn-delete').css('display', 'none');
		$('#remove-btn').css('display', 'inline-block');
		$(this).css('display', 'none');
    });

	 $('.btn-delete').on('click', function(){
	 	var value = $(this).val();
	 	var employee_name = $(this).attr('id');
	 	$("#modal-form").attr("action", value);
	 	$("#employee-full-name").html(employee_name);
	 	$('#myModal').modal('show');
	 });
});