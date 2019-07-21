$(document).ready(function(e) {
    $("#login-pop , #book-pop").click(function(e) {
        $(".login-popup").fadeIn()
    });
	
	$("#pop-close , .pop-off").click(function(e) {
        $(".login-popup").fadeOut()
    });
});


$(document).ready(function(e) {
    $("#forgote").click(function(e) {
        $(".forgote-popup").fadeIn()
    });
	
	$("#pop-close , .pop-off").click(function(e) {
        $(".forgote-popup").fadeOut()
    });
});	

$(document).ready(function(e) {
    $("#forgote1").click(function(e) {
        $(".forgote-popup").fadeIn()
    });
	
	$("#pop-close , .pop-off").click(function(e) {
        $(".forgote-popup").fadeOut()
    });
});	

$(document).ready(function(e) {
    $("#forgote2").click(function(e) {
        $(".forgote-popup").fadeIn()
    });
	
	$("#pop-close , .pop-off").click(function(e) {
        $(".forgote-popup").fadeOut()
    });
});

// slide body //////

$(document).ready(function(e) {
    $(".navbtn , .navgoin").click(function(e) {
        $(".slidebody, .headersection").toggleClass('addfullwith')
    });
	$(".navbtn , .navgoin").click(function(e) {
        $(".slideadd").toggleClass('goleft')
    });
});	


/// nav btn //////
$(document).ready(function(e) {
    $(".navbtn , .navgoin").click(function(e) {
        $(".spnnavbtn1").fadeToggle()
    });
	$(".navbtn , .navgoin").click(function(e) {
        $(".spnnavbtn2").fadeToggle()
    });
});	


$(function(){
		$("a.hidelink").each(function (index, element){
			var href = $(this).attr("href");
			$(this).attr("hiddenhref", href);
			$(this).removeAttr("href");
		});
		$("a.hidelink").click(function(){
			url = $(this).attr("hiddenhref");
			window.open(url, '_top');
		})
	});

