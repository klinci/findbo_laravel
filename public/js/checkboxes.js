$(document).ready(function () {
    $("#iCheckbox").on("click", function () {
        check = $("#myCheckbox").prop("checked");

        if (check) {
            if ($('.iCheck i').hasClass('fa-square-o')) {
                $('.iCheck i').removeClass('fa-square-o').addClass('fa-check-square-o');
               
            }
        } else {
            if ($('.iCheck i').hasClass('fa-check-square-o')) {
                $('.iCheck i').removeClass('fa-check-square-o').addClass('fa-square-o');
              
            }
        }

    });
    
});
  

// JavaScript Document