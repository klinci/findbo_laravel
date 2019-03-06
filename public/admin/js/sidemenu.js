/* Javascript */
var menucollapsewidth = 70;
var menuwidth = 230;
var slideBtn = $('a.btn-slide');
var winW = $(window).width();
var checkval = 1;
var state ='open';

$(document).ready(function () {
    //setMenu("close");
	setMenu("Initial");
	
       $('a.btn-slide').click(function (e) {
        e.preventDefault();
        
        //alert("state : "+state+"===checkval=="+checkval);
        
        if (state == '' && checkval == 0) {
            state = 'close';
            checkval = 1;
            OpenState();
        }

        else if (state == '') {
            checkval = 1;
            CloseState();
            state = 'open';
        }

        else if (state == 'open') {
        	//alert("open state");
            OpenState();
            checkval = 2;
            state = 'setmenu';
            //state = 'Initial';
        }
        else if (state == 'close') {
            checkval = 2;
            CloseState();
            state = 'setmenu';
        }
        else if (state == 'setmenu') {
            setMenu("Initial");
            state = 'open';
        }

        $(".btn-slide").blur();
    });

    /*$('.nav-new li a').bind('click', function (e) {
        //e.preventDefault();
        if (state == 'open') {
            OpenState();
            state = 'close';
        }
        else if (state == '' && checkval == 0) {
            OpenState();
            state = 'close';
        }
        else if (state == 'setmenu') {
            OpenState();
            state = 'close';
        }

    });*/

});

function setMenu(val) {
	
    var isOpen = $("#menu li.active").length == 0 ? 0 : 1;
    if (val == "Initial")
    {
		//alert("val : "+val);
        var windowWidth = $(window).width();
       
       
        if (windowWidth < 1300) {
            $("#FollowReminder").addClass("fxdHeaderDataReplacefull");
        }
        else {
            $("#FollowReminder").addClass("fxdHeaderDataReplacefull");
            }
        $(this).removeClass('open');
        $(this).removeClass('close');
        
    
        $('.nav-new li a').css('display', 'none');
        //$('#contentwrap').css('background', 'none');
        $('a.btn-slide').addClass('initial').css('left', winW <= 979 ? menucollapsewidth - 50 : '8px');
        $('#content').css('margin-left', '0');
		$('#content').removeClass('open');
        $('#sidemenu').css({ 'max-width': '0', 'min-width': '0' });
    }
    else if (val == "open")
    {
	   console.log('setmenu - open');
       
	    $('a.btn-slide').removeClass('open').css('left', winW <= 979 ? menuwidth - 20 : menuwidth);
	    $('#content').css('margin-left', menuwidth);
		$('#content').addClass('open');
	    $('#sidemenu').css({ 'max-width': menuwidth, 'min-width': menuwidth });
	    $('.nav-new a .caret').show();
    }

    if (val == "close") {
        if (isOpen == 0) {
		  
           
            $('a.btn-slide').addClass('open').css('left', winW <= 979 ? menucollapsewidth - 20 : menucollapsewidth);
            //$('#content').css('margin-left', menucollapsewidth);
            $('#content').css('margin-left', winW < 768 ? 0 : menucollapsewidth);
            //$('#sidemenu').css({ 'max-width': menucollapsewidth, 'min-width': menucollapsewidth });
            $('#sidemenu').css({ 'max-width': (winW < 768 ? 0 : menucollapsewidth), 'min-width': (winW < 768 ? 0 : menucollapsewidth) });
            $('.nav-new a .caret').hide();
        }
        else {
            setMenu("open");
        }

    }
}



function OpenState(option) {
	
    $('a.btn-slide').animate({ 'left': winW <= 979 ? menuwidth - 20 : menuwidth }, 500, function () {
        $(this).removeClass('open');
    });
    $('#content').animate({ 'margin-left': menuwidth }, 500);
	$('#content').addClass('open');
    $('#sidemenu').animate({
        'max-width': menuwidth,
        'min-width': menuwidth
    }, 500);
    
    $('.nav-new li a').show();

    $('.nav-new a .caret').show();
  
}
function CloseState() {
	
    if (state == 'close' || state == '') {
        $('.nav-new li a').css('display', '');
        //$('#contentwrap').css('background', '');
        $('a.btn-slide').animate({ 'left': winW <= 979 ? menucollapsewidth - 20 : menucollapsewidth }, 500, function () {
            if (checkval == 2) {
                $(this).removeClass('open');
           }
            else {
                $(this).removeClass('initial');
                $(this).removeClass('close');
                $(this).addClass('open');
            }
        });
        $('#content').animate({ 'margin-left': menucollapsewidth }, 500);
		$('#content').removeClass('open');
        $('#sidemenu').animate({
            'max-width': menucollapsewidth,
            'min-width': menucollapsewidth
        }, 500);

        $('.nav-new a .caret').hide();
        $('#menu').navgoco('toggle', false);
      }
}
