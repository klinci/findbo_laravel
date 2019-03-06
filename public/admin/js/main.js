$(document).ready(function (e) {
	
		  $('[data-toggle="popover"]').popover()
	
            var arr = $('.submenu img').map(function () {
                var path = this.src;
                var id = this.id;
                $.get(this.src)
                   .fail(function () {
                       if (path.indexOf('hover') > -1) {
                           $("#" + id).attr('src', '@Url.Content("images/no-image-hover.png")');
                       }
                       else {
                           $("#" + id).attr('src', '@Url.Content("images//no-image.png")');
                       }
                   })
            });

            //$('.submenu a').tooltip();
            $("#menu").navgoco({
                caret: '<span class="caret"></span>',
                accordion: true,
                openClass: 'active',
                /*save: false,
                cookie: {
                name: 'navgoco',
                expires: false,
                path: '/'
                },*/
                slide: {
                    duration: 400,
                    easing: 'swing'
                }
            });
	
	/*for Left scroll*/
    (function($){
			$(window).load(function(){
				
				$("#sidemenu").mCustomScrollbar({
					autoHideScrollbar:true,
                    theme:"minimal-dark",
					theme:"minimal"
                    
				});
				
			});
		})(jQuery);

        });


function formatAMPM() {
	var date = new Date();
	var hours = date.getHours();
	var minutes = date.getMinutes();
	var ampm = hours >= 12 ? 'PM' : 'AM';
	hours = hours % 12;
	hours = hours ? hours : 12; // the hour '0' should be '12'
	hours = hours < 10 ? '0'+hours : hours;
	minutes = minutes < 10 ? '0'+minutes : minutes;
	var strTime = hours + ':' + minutes + ' ' + ampm;
	return strTime;
}