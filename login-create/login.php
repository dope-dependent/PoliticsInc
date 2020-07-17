<?php
	include ('../components/connection.php');
	//FORM VALIDATION IN LOGIN INDEX
	$errors = array('mail'=>'', 'pass'=>'');
	$mail = '';
	$password='';	
	if(isset($_POST['submit'])){
		//CHECK THE EMAIL	
		$password = $_POST['password'];
		$mail = $_POST['mail'];	
		if(empty($_POST['mail'])){			
			$errors['mail'] = "Please enter an E-Mail address";
		}
		else{
			if(!filter_var($mail,FILTER_VALIDATE_EMAIL)){
				$errors['mail'] = 'Please enter a valid E-Mail address';
			}
		}
		if(!array_filter($errors)){
			//CHECK IF NOT PRESENT
		
			$mail = mysqli_real_escape_string($conn,$_POST['mail']);
			$password = mysqli_real_escape_string($conn,$_POST['password']);			

			$sql = "SELECT * FROM users WHERE email = '".$mail."'";
			$result  = mysqli_query($conn,$sql);
			$user = mysqli_fetch_array($result,MYSQLI_ASSOC);
			if($user==null){
				$errors['mail'] = 'There is no account with this E-Mail address';
			}
			else{
				if($user['password']!=$password){
					$errors['pass'] = 'Incorrect password';
					mysqli_close($conn);
				}
				else{
					//SUBMIT THE E-MAIL ID USING HIDDEN JS FORM
					echo (
						"<form style='display:none;' name='form1' action='../main/intro.php' method='POST'>
							<input type='hidden' name='mail' value='$mail'>
						</form>
						<script type='text/javascript'>
							document.getElementsByName('form1')[0].submit();
						</script>"
					);
				}

			}
		}
	
	}
	

 ?>

<!DOCTYPE html>
<html>
<head>
	<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="../common-styles/buttons.css"></link>
	<link rel="stylesheet" type="text/css" href="./styles.css"></link>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>
		Politics Inc - Login
	</title>
</head>
<body>
	<div class="main">
		<?php include('../components/navbar1.php') ?>
			<div class="margin-top-med center">
				<form class="formarea center" action="login.php" method="POST">
				<h1 style="margin:10px; margin-bottom: 20px">Sign in to your account</h1>
				<label>E-Mail Address</label>
				<div><input class="center"
							autocomplete="off"
							type="text" 
							name="mail" 
							<?php if($errors['mail']!=''){
								echo "style='border-bottom: 2px solid #ED3330 !important;'";;
							} else{
								echo "style='border-bottom: 2px solid #FFFFFF'";;
							} ?>
							value="<?php echo htmlspecialchars($mail) ?>"></div>
					<div style="color: #ED3330; margin-bottom:10px;"><?php echo($errors['mail']); ?></div>
				<label>Password</label>
				<div><input class="center" 
							type="text" 
							name="password"
							autocomplete="off"
							<?php if($errors['pass']!=''){
								echo "style='border-bottom: 2px solid #ED3330 !important;'";;
							} else{
								echo "style='border-bottom: 2px solid #FFFFFF'";;
							} ?> 
							value='<?php echo htmlspecialchars($password)?>'></div>
					<div style="color: #ED3330; margin-bottom:10px;"><?php echo($errors['pass']); ?></div>
				<div style="margin:20px auto;"><a style="font-weight: 100; text-decoration:none;color:#86c232"href="./create.php"> Don't have an account?</a></div>
				<div class="button2" style="position: relative; left: 50%; transform: translateX(-50%);">
					<span style="font-size:18px; font-weight:bold;">
						<input type="submit" style="all:unset;" value="Sign In" name="submit">
					</span>
				</div>
			</form>			
		</div>
	</div>
</body>
</html>