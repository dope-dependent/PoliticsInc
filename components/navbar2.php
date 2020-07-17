<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
    /* COLORS
    SEPIA - #704214
    WHEAT - #FFFDD0
    BURGUNDY - #800020 
    */
    .central{
        padding:5px 5px 8px 5px; 
        font-family:'Open Sans',sans serif; 
        text-align:left; 
        background-color:#FFFDD0;
    }
    .button{ 
        border:none; 
        color:#704214;
        text-decoration: none;
        font-family: 'Open Sans', sans-serif;
        font-weight: 600;
        padding:15px;
        font-size:16px;
    }
    .button--home{
        font-size:30px;
        padding:7px 15px;
    }
    .button:hover{
        text-shadow: 0px 0px 1px #704214;
    } 
    .heading{
        font-size:20px; 
        font-weight:300; 
        color:#704214;
        padding:12px;
    } 
    /* DEFINE MEDIA QUERY FOR MOBILE SIZE */


</style>

<div class="central">
    <a href="#" class="button button--home" style="float:left;"><i class="fa fa-home"></i></a>
    <a href="/project/login-create/login.php" class="button" style="float: right;">LOGOUT</a>
    <h3 class="heading"> Signed in as <span style="font-weight:400"><?php echo $mail ?></span></h3>
</div>
    
