// windows scrolling up
$(window).scroll(function() {    
    var scroll = $(window).scrollTop();
    if (scroll >= 50) { $(".mainnav").addClass("scrolling"); } 
	else { $(".mainnav").removeClass("scrolling");}
});

// tabs partner page
$(document).ready(function(){
	$('ul.tabs li').click(function(){
		var tab_id = $(this).attr('data-tab');

		$('ul.tabs li').removeClass('current');
		$('.tab-content').removeClass('current');

		$(this).addClass('current');
		$("#"+tab_id).addClass('current');
	})

})



$('.slider').cycle({ 
    fx:    'fade', 
    pause:  1 
});

/*--------------- secound sider--------------------------------*/

$('.slider2').cycle({ 
    fx:    'fade', 
    pause:  1 
});
/*--------------- secound sider--------------------------------*/

$('.slide-2').cycle({ 
    fx:    'fade', 
    pause:  1 
});


/*----------------- demo coding ----------------------------*/


$(document).ready(function() {
  $("#fadeindv").focus(function() {
      $('.dark-dv').fadeIn('');       
      //return false;
    });
	 $(".dark-dv").click(function() {
      $('.dark-dv').fadeOut('');       
      //return false;
    });    
});

$(document).ready(function() {
  $(".fadeindv").focus(function() {
      $('.dark-dv').fadeIn('');       
      //return false;
    });
	 $(".dark-dv").click(function() {
      $('.dark-dv , #citylist').fadeOut('');       
      //return false;
    });    
});



/*--------------- secound sider--------------------------------*/

$('.testi-slide').cycle({ 
    fx:    'fade', 
    pause:  1 
});


// fixed button div //////////////////////////////////

$(document).ready(function() {
    $('.call-dv').click(function() {
        $('.receive-dv').toggleClass('receive-dv2');
    });
});





// city main slider div //////////////////////////////////

/*$('.ct-main-slide').cycle({ 
    fx:    'scrollHorz', 
    pause:  1 ,
	speed:  1000,
	timeout: 1,
	next:   '#next2',
	prev:   '#prev2'

});*/


$('.slide-box1').cycle({ 
    fx:    'scrollHorz', 
    pause:  1 ,
	timeout: 0,
	speed: 500,
	next:   '.nextin1',
	prev:   '.previn1'

});


$('.slide-box2').cycle({ 
    fx:    'scrollHorz', 
    pause:  1 ,
	timeout: 0,
	speed: 500,
	next:   '.nextin2',
	prev:   '.previn2'

});

$('.slide-box3').cycle({ 
    fx:    'scrollHorz', 
    pause:  1 ,
	timeout: 0,
	speed: 500,
	next:   '.nextin3',
	prev:   '.previn3'

});





// state main slider div //////////////////////////////////

/*$('.state-slide-main').cycle({ 
    fx:    'scrollHorz', 
    pause:  1 ,
	speed:  1000,
	timeout: 1,
	next:   '#next-one',
	prev:   '#prev-one'

});*/

// hotel detail page slider coding //////////////////////////////////

$('.resort-detail-slide-in').cycle({ 
    fx:    'scrollHorz', 
    pause:  1 ,
	speed:  1000,
	timeout: 1,
	next:   '#foreword-nxt',
	prev:   '#backword-pre'

});


// hotel detail page slider coding //////////////////////////////////

$(document).ready(function(e) {
    $("#login-pop").click(function(e) {
        $(".login-popup").fadeIn()
    });
	
	$("#pop-close , .pop-off").click(function(e) {
        $(".login-popup").fadeOut()
    });
	
	$("#forgote").click(function(e) {
        $(".login-popup").fadeOut(1000)
    });
});


// hotel detail page slider coding //////////////////////////////////

$(document).ready(function(e) {
    $("#forgote").click(function(e) {
        $(".forgote-popup").fadeIn()
    });
	
	$("#pop-close , .pop-off").click(function(e) {
        $(".forgote-popup").fadeOut()
    });
});





//////// logo in popup ///////////////////////////////////////////////////

(function($,W,D)
{
    var JQUERY4U = {};

    JQUERY4U.UTIL =
    {
        setupFormValidation: function()
        {
            //form validation rules
            $("#register-form").validate({
                rules: {
                    email: {
                        required: true,
                        email: true
                    },
                    password: {
                        required: true,
                        minlength: 8
                    },

                    agree: "required"
                },
                messages: {

                    password: {
                        required: "Please provide a password",
                        minlength: "Your password must be at least 8 characters long"
                    },
                    email: "Please enter a valid email address",
                    agree: "Please accept our policy"
                },
                submitHandler: function(form) {
                    form.submit();
                }
            });
        }
    }

    //when the dom has loaded setup form validation rules
    $(D).ready(function($) {
        JQUERY4U.UTIL.setupFormValidation();
    });

})(jQuery, window, document);



//////// forgote popup ///////////////////////////////////////////////////

(function($,W,D)
{
    var JQUERY4U = {};

    JQUERY4U.UTIL =
    {
        setupFormValidation: function()
        {
            //form validation rules
            $("#register-form-forgote").validate({
                rules: {
                    email: {
                        required: true,
                        email: true
                    },
                },
                messages: { email: "Please enter a Registered email",
				
				},
                submitHandler: function(form) {
                    form.submit();
                }
            });
        }
    }

    //when the dom has loaded setup form validation rules
    $(D).ready(function($) {
        JQUERY4U.UTIL.setupFormValidation();
    });

})(jQuery, window, document);



//////// datepicker book now page  ///////////////////////////////////////////////////

$(document).ready(function(e) {
    $(function() {
		$( "#child-1" ).datepicker();
	 });
	 
	 $(function() {
		$( "#child-2" ).datepicker();
	 });
	 
	 $(function() {
		$( "#child-3" ).datepicker();
	 });
	 
	 $(function() {
		$( "#aniversary" ).datepicker();
	 });

});


//////// datepicker index page  ///////////////////////////////////////////////////

$(document).ready(function(){
    $(function(){
		$( "#datepicker" ).datepicker({
			minDate: 'dateToday',
			dateFormat: 'd - M - y', 
			onSelect: function(selected){ 
			$("#datepicker2").datepicker("option","minDate",selected);
         }
		});
	 });
	 
	 $(function() {
		$( "#datepicker2" ).datepicker({
			dateFormat: 'd - M - y',
			onSelect: function(selected){
				$("#datepicker").datepicker("option","maxDate",selected);
            }
		});
	 });
});




//////// datepicker hotel page  ///////////////////////////////////////////////////

$(document).ready(function() {
    $(function(){
		$( "#select-from" ).datepicker({
			minDate: 'dateToday',
			dateFormat: 'd - M - y', 
			onSelect: function(selected){ 
			$("#select-till").datepicker("option","minDate",selected);
         }
			});
	 });
	 
	 $(function() {
		$( "#select-till" ).datepicker({
			dateFormat: 'd - M - y',
			onSelect: function(selected){
				$("#select-from").datepicker("option","maxDate",selected);
         }
				 
			});
	 });
});


///////////////for ///////////////

function onlydigit(input){
	var digit = /[^0-9]/g;
	input.value = input.value.replace(digit,"");
}



//////// scroll window top //////////////////////////////////////////
$(function() {
	var $elem = $('#content');
	$('#button').click(function (e) {
	$('html, body').animate({scrollTop: '0px'}, 800);
	});
});


//////// scroll window top //////////////////////////////////////////

$(document).ready(function(e) {
    $(".menu-dv , .menu-dv2").click(function(e) {
        $(".clo-se , .clo-se-first").fadeToggle()
    });
	$(".menu-dv , .menu-dv2").click(function(e) {
        $(".top-link").slideToggle()
    });
});


$(window).on('scroll',function() {    
    var scroll = $(window).scrollTop();

    if (scroll >= 500) {
        $(".scroll-top").addClass("add");
    } else {
        $(".scroll-top").removeClass("add");
    }
});


// first time popup
$(document).ready(function() {
	if(localStorage.getItem('popState') != 'shown'){
        $("#popup").delay(2000).fadeIn();
        localStorage.setItem('popState','shown')
    }
    $('.closepopup').click(function(e) {$('#popup , .applestoredv , .paytmpopup').fadeOut(); });
	$('.popslose').click(function(e) { $('#popup').fadeOut();  });
	$('.store').click(function(e) { $('.applestoredv').fadeIn();  });
	$('.popslose').click(function(e) { $('.applestoredv , .paytmpopup').fadeOut();  });
	
	$('.ptm').click(function(e) { $('.paytmpopup').fadeIn();  });
	
	
});



$(function () {
	$(".downtag2 .main2").click(function () {
		var slideDown = $(this).parent().find(".toggle2").text() == "+" ? false : true;
		$(".submain2").slideUp(300);
		$(".toggle2").text('+');
		if(!slideDown){
			$(this).parent().find('.submain2').slideDown(300);
			$(this).parent().find('.toggle2').text('-');
		}
		$(".submain").slideUp(300);
		$(".toggle").text('+');
		if(!slideDown){
			$(this).parent().find('.submain2').slideDown(300);
			$(this).parent().find('.toggle2').text('-');
		}
	});
	$(".submain").not().hide();
});	


$(function () {
	$(".downtag .main").click(function () {
		var slideDown = $(this).parent().find(".toggle").text() == "+" ? false : true;
		$(".submain").slideUp(300);
		$(".toggle").text('+');
		if(!slideDown){
			$(this).parent().find('.submain').slideDown(300);
			$(this).parent().find('.toggle').text('-');
		}
		
		$(".submain2").slideUp(300);
		$(".toggle2").text('+');
		if(!slideDown){
			$(this).parent().find('.submain2').slideDown(300);
			$(this).parent().find('.toggle2').text('-');
		}
	});
	$(".submain").not().hide();
});	

// header slider
