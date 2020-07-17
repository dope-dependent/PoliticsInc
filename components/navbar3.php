<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
    /* COLORS
    SEPIA - #704214
    WHEAT - #FFFDD0
    BURGUNDY - #800020 
    STYLISH BLUE - #66FCF1
    YELLOW - #FAED26
    */
    .central{
        padding:5px 5px 8px 5px; 
        font-family:'Open Sans',sans serif; 
        text-align:center; 
        background-color:transparent;
    }
    .button{ 
        border:none; 
        color:whitesmoke;
        text-decoration: none;
        font-family: 'Open Sans', sans-serif;
        font-weight: 600;
        padding:15px;
        font-size:16px;
        cursor: pointer;
    }
    .button--home{
        font-size:30px !important;
        padding:7px 15px;
        cursor: pointer;
        position: absolute;
        top:0;
        left:0;
        z-index: 100;
    }
    .button:hover{
        text-shadow: 0px 0px 1px #704214;
    } 
    .heading{
        font-size:20px; 
        font-weight:300; 
        color:whitesmoke;
        padding:12px;
    } 
    /* DEFINE MEDIA QUERY FOR MOBILE SIZE */


</style>

<div class="central">
    <?php 
        echo(
				"<form style='font-size=30px;' name='form1' action='../main/intro.php' method='POST'>
                            <input type='hidden' class = 'button-home' name='mail' value='".$mail."'>
                        <div id='form-submit' class='button button--home'>
                                <i class='fa fa-home'></i>
                        </div>
				</form>
					<script type='text/javascript'>
					    document.getElementById('form-submit').onclick = ()=>{
                                console.log(document.getElementsByName('form1'));
                                document.getElementsByName('form1')[0].submit();                                
                        } ;
				    </script>"
			);	
    ?>
    <a href="/project/login-create/login.php" class="button" style="float: right;">LOGOUT</a>
    <h3 class="heading"> Signed in as <span style="font-weight:400"><?php echo $mail ?></span></h3>
</div>
    
