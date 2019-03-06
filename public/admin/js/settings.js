$(document).ready(function(){
	$( "#frmSettings" ).validate({
		rules: {
			"txtSmtpServer": {
				required: true
			},
			"txtEmail": {
				required: true,
				email: true
			},
			"txtPassword": {
				required: true
			},
			"txtPort": {
				required: true
			},
			"txtFromName": {
				required: true
			},
			"txtFromEmail": {
				required: true,
				email: true
			}
		},
		messages: {
			"txtSmtpServer": {
				required: "Please enter smtp server."
			},
			"txtEmail": {
				required: "Please enter email.",
				email: "Please enter valid email."
			},
			"txtPassword": {
				required: "Please enter password."
			},
			"txtPort": {
				required: "Please enter port number."
			},
			"txtFromName": {
				required: "Please enter from name."
			},
			"txtFromEmail": {
				required: "Please enter from email.",
				email: "Please enter valid email."
			}
		}	
	});
});