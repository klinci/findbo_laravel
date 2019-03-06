$(document).ready(function(){
	
	// http://stackoverflow.com/questions/4128657/jquery-validation-changing-rules-dynamically
	
	$( "#frmLogin" ).validate({
		rules: {
			"txtEmail": {
				required: true,
				noSpecialChars: true,
				maxlength: 20
			},
			"txtPassword": {
				required: true,
				minlength: 8,
				maxlength: 12,
				mypassword: true
			}
		},
		messages: {
			"txtEmail" : {
				required: "Please enter username.",
				maxlength: "Username should be less than and equal to 20 characters."
			},
			"txtPassword": {
				required: "Please enter password.",
				minlength: "Password should be greater than and equal to 8 characters.",
				maxlength: "Password should be less than and equal to 12 characters."
			}
		}	
	});
});