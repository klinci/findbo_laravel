$(document).ready(function(){
	$.validator.addMethod("noSpecialChars", function(value, element) {
	     return this.optional(element) || /^[a-z0-9]+$/i.test(value);
	}, "Username must contain only letters and numbers.");
	
    $.validator.addMethod('mypassword', function(value, element) {
        return this.optional(element) || (value.match("^(?=.*\\d)(?=.*[a-zA-Z]).{8,12}$"));
    },
    'Password must contain at least one numeric and one alphabetic character.');
    
    jQuery.validator.addMethod("specialChar", function(value, element) {
        return this.optional(element) || /([0-9a-zA-Z\s])$/.test(value);
     }, "Please Fill Correct Value in Field.");
    
    $.validator.addMethod("numbersAllow", function(value, element) {
	     return this.optional(element) || /^[0-9]+$/i.test(value);
	}, "Only numbers allow.");
    
    $.validator.addMethod('minStrict', function (value, el, param) {
        return value >= param;
    });
    
    $.validator.addMethod('maxStrict', function (value, el, param) {
        return value <= param;
    });
    
    $.validator.addMethod("greaterThan", function(value, element, param) {
    	var $min = $(param);
    	if (this.settings.onfocusout) {
    		$min.off(".validate-greaterThan").on("blur.validate-greaterThan", function() {
				$(element).valid();
			});
    	}
    	return parseInt(value) > parseInt($min.val());
    }, "Max must be greater than min");
});

function IsNumeric(e) {
	var specialKeys = new Array();
	specialKeys.push(8); //Backspace
    var keyCode = e.which ? e.which : e.keyCode
    var ret = ((keyCode >= 48 && keyCode <= 57) || specialKeys.indexOf(keyCode) != -1);
    //document.getElementById("error").style.display = ret ? "none" : "inline";
    return ret;
}


function allowNegativeNumber(e) 
{
	var specialKeys = new Array();
	specialKeys.push(8); //Backspace
	specialKeys.push(45); //minus sign
	specialKeys.push(9); //horizontal tab
    var keyCode = e.which ? e.which : e.keyCode
    var ret = ((keyCode >= 48 && keyCode <= 57) || specialKeys.indexOf(keyCode) != -1);
    //document.getElementById("error").style.display = ret ? "none" : "inline";
    return ret;
}

/*function checkPosNegNumber(text, jobid, wno)
{
	alert("ttt");
	var pattern = /^-?[0-9]+(.[0-9]{1,2})?$/;
	if(text.match(pattern)==null)
	{
		alert("test");
		$("#err"+jobid+wno).show();
		$("#btnLookAhead").attr('disabled', 'disabled');
	}
	else
	{
		alert("test1");
		$("#err"+jobid+wno).hide();
		$("#btnLookAhead").removeAttr('disabled');
	}
}*/