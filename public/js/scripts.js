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
});