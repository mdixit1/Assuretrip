<?php
error_reporting(0);
session_start();
include('../function.php');
include('../connection/index.php');
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Add Keywords</title>
<?php echo headdata(); ?>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="<?php echo $url; ?>css/font-awesome.min.css" type="text/css" rel="stylesheet"/>
<link href="<?php echo $url; ?>css/bootstrap.min.css" type="text/css" rel="stylesheet"/>
<link href="css/styleplus.css" type="text/css" rel="stylesheet"/>
<link href="css/responsive-manage.css" type="text/css" rel="stylesheet"/>
<script src="<?php echo $url; ?>js/jquery-3.2.1.min.js" type="text/javascript"> </script>
<script src="<?php echo $url; ?>js/bootstrap.min.js" type="text/javascript"></script>
<script src="js/index.js"></script>
<script>
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

$(document).ready(function(e) {
    $("#login-pop , #book-pop").click(function(e) {
        $(".login-popup").fadeIn()
    });
	
	$("#pop-close , .pop-off").click(function(e) {
        $(".login-popup").fadeOut()
    });
});

$(document).ready(function(e) {
    $("#login-pop1 , #book-pop").click(function(e) {
        $(".login-popup").fadeIn()
    });
	
	$("#pop-close , .pop-off").click(function(e) {
        $(".login-popup").fadeOut()
    });
});

function ckdel(){
	
	return confirm('Are you sure');	
	
}
</script>
</head>
<body>
<?php include('aheader.php'); ?>

<div class="slidebody see-trans5s">
    <?php include('topheader.php'); ?>
    <div class="fulldv adminbody">
    <div class="fulldv subcate_sect">
	
      <div class="fulldv category-maindv">
        <div class="see-12 topbox">
            <input type="button" id="login-pop" value="Add Keyword" class="btn-blue">
        </div>
    
        <!--<div class="overlaydv login-popup">
            <div class="pop-off"></div>
            <div class="overlaydv-in">
                <div class="overlaydv-inner">
                    <div class="log-pop-inner">  
                        <form>
                          <span><a href="keywords.php">&times;</a></span>
                          <h4>Add Keyword</h4>
                          <div class="fulldv cattag">
                              <input type="text" name="cate" id="cate" placeholder="Enter State Name" required/>
                              <button type="button" id="submit" class="btn-blue">Add</button>
                          </div>
                        </form>
                        <br>
                        <div id="showdata"></div> 
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>-->
         
        <div class="fulldv category">
            <div class="fulldv">
                <h2>Keyword</h2>
            </div>
           <div class="col-md-6 cattable p0">
               <table class="see-table see-table-each">
                    <tr class="bluetr">
                        <th>Keyword Name</th>
                        <th>Edit</th>
                    </tr>
                   <tr>
                        <td>travel agency</td>
                        <td>
                            <a href="#" id="forgote" onClick="return ckdel();">
                                <span class="catdelete"><i class="fa fa-trash"></i></span>
                            </a> &nbsp;
                            <a href="#" id="forgote">
                                <span class="catedit"><i class="fa fa-edit"></i></span>
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td>cheap airline tickets</td>
                        <td>
                            <a href="#" id="forgote" onClick="return ckdel();">
                                <span class="catdelete"><i class="fa fa-trash"></i></span>
                            </a> &nbsp;
                            <a href="#" id="forgote">
                                <span class="catedit"><i class="fa fa-edit"></i></span>
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td>cheap air tickets</td>
                        <td>
                            <a href="#" id="forgote" onClick="return ckdel();">
                                <span class="catdelete"><i class="fa fa-trash"></i></span>
                            </a> &nbsp;
                            <a href="#" id="forgote">
                                <span class="catedit"><i class="fa fa-edit"></i></span>
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td>cheap air</td>
                        <td>
                            <a href="#" id="forgote" onClick="return ckdel();">
                                <span class="catdelete"><i class="fa fa-trash"></i></span>
                            </a> &nbsp;
                            <a href="#" id="forgote">
                                <span class="catedit"><i class="fa fa-edit"></i></span>
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td>cheap airfare</td>
                        <td>
                            <a href="#" id="forgote" onClick="return ckdel();">
                                <span class="catdelete"><i class="fa fa-trash"></i></span>
                            </a> &nbsp;
                            <a href="#" id="forgote">
                                <span class="catedit"><i class="fa fa-edit"></i></span>
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td>cheap plane tickets</td>
                        <td>
                            <a href="#" id="forgote" onClick="return ckdel();">
                                <span class="catdelete"><i class="fa fa-trash"></i></span>
                            </a> &nbsp;
                            <a href="#" id="forgote">
                                <span class="catedit"><i class="fa fa-edit"></i></span>
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td>airplane ticket</td>
                        <td>
                            <a href="#" id="forgote" onClick="return ckdel();">
                                <span class="catdelete"><i class="fa fa-trash"></i></span>
                            </a> &nbsp;
                            <a href="#" id="forgote">
                                <span class="catedit"><i class="fa fa-edit"></i></span>
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td>airline flights</td>
                        <td>
                            <a href="#" id="forgote" onClick="return ckdel();">
                                <span class="catdelete"><i class="fa fa-trash"></i></span>
                            </a> &nbsp;
                            <a href="#" id="forgote">
                                <span class="catedit"><i class="fa fa-edit"></i></span>
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td>travel deals</td>
                        <td>
                            <a href="#" id="forgote" onClick="return ckdel();">
                                <span class="catdelete"><i class="fa fa-trash"></i></span>
                            </a> &nbsp;
                            <a href="#" id="forgote">
                                <span class="catedit"><i class="fa fa-edit"></i></span>
                            </a>
                        </td>
                    </tr>
                </table>
                <br><br><br>
                <script>
        showdata();
            $('#submit').click(function(){
                var catname = $('#cate').val();
				$('#cate').val('');
			    $.ajax({
                    url:'keywords.php',  
                    method:'POST',
                    async:false,
                    data:{
                        'saverecord' : 1,
                        'cate' : catname
			        },
                    dataType:"text",
                    success: function(data){
						if(data == 3){
                        //	alert("category Inserted");
                            showdata();	
                        }
                        else if(data == 4){
                            alert('Sorry please enter category');
                        }
                    }
                });
            });
            
            function showdata(){
                $.ajax({
                    url:'keywords.php', 
                    type: 'POST',
                    async:false,
                    data:{
                        'show' : 1	
                    },
                    success: function(r){
                        $('#showdata').html(r);
                    }
                });	
            }
    </script>
           </div>
        </div>
    </div>
</div>
</div>
</div>
</body>
</html>