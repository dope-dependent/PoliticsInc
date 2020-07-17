<?php

	include('../components/connection.php');
	$errors = array('mail'=>'', 'password'=>'');
	$mail = '';
	$password='';
	$logintext = '';	
	if(isset($_POST['submit'])){
		//CHECK THE EMAIL	
		$mail = $_POST['mail'];	
		if(empty($_POST['mail'])){			
			$errors['mail'] = "Please enter an E-Mail address";
		}
		else{
			if(!filter_var($mail,FILTER_VALIDATE_EMAIL)){
				$errors['mail'] = 'Please enter a valid E-Mail address';
			}
		}
		//CHECK THE PASSWORD LENGTH
		$password = $_POST['password'];
		if(empty($password)){
			$errors['password'] = "Please enter a password";
		}
		else{
			//CHECK PASSWORD LENGTH
			if(strlen($password)<6){
				$errors['password'] = "Password should have greater than or equal to 6 characters";
			}
			else if(strlen($password)>15){
				$errors['password'] = 'Password should have less than or equal to 15 characters';
 			}
		}
		if(!array_filter($errors)){
			//CHECK IF THE DATABASE CONTAINS THE EMAIL ADDRESS
			$password = mysqli_real_escape_string($conn,$_POST['password']);
			$mail = mysqli_real_escape_string($conn,$_POST['mail']);
			$sql = "SELECT * FROM users WHERE email='".$mail."'";
			$result = mysqli_query($conn,$sql);	
			$user = mysqli_fetch_all($result,MYSQLI_ASSOC);
			if(count($user)==0){
				$errors['mail'] = '';
				$sql = "INSERT INTO users(email,`password`,`started`,setIndex,`sequence`,currentIndex) VALUES ('".$mail."','".$password."','false',-1,'',-1)";
				if(mysqli_query($conn,$sql)){
					$logintext = "HERE";
					mysqli_close($conn);
				}
				
			}
			else {					
				print_r($user);
				$errors['mail'] = "An account already exists with this E-Mail address";
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
	<title>Politics Inc - Create Account </title>

</head>

<body>
	<div class="main">
		<?php include('../components/navbar1.php') ?>
		<div class="margin-top-med center">
				<form class="formarea center" action="create.php" method="POST">
				<h1 style="margin:10px; margin-bottom: 20px">Create a New Account</h1>
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
					<div style="color: #ED3330; margin:10px auto;"><?php echo($errors['mail']); ?></div>
				<label>Password <span style="font-weight:300">(6-15 characters)</span></label>
				<div><input class="center" 
							type="text" 
							name="password"
							autocomplete="off" 
							<?php if($errors['password']!=''){
								echo "style='border-bottom: 2px solid #ED3330 !important;'";;
							} else{
								echo "style='border-bottom: 2px solid #FFFFFF'";;
							} ?>
							value='<?php echo htmlspecialchars($password)?>'></div>
							
				<div style="color: #ED3330; margin:10px auto;"><?php echo($errors['password']); ?></div>
				<div class="button2" style="position: relative; left: 50%; transform: translateX(-50%);">
					<span style="font-size:18px; font-weight:bold;">
						<input type="submit" style="all:unset;" value="Create Account" name="submit">
					</span>
				</div>
				<div style="margin:20px auto;"><a style="font-weight: 100; text-decoration:none; color:#86c232"href="login.php">						
					<?php if($logintext=="HERE"){
						echo "Account successfully created. Click me to login";
					}?>
			
				</a></div>
			</form>			
		</div>
	</div>

</body>

</html>