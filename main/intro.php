<?php
	include('../components/connection.php');
	$mail = '';
	$user = '';
	$sql = '';
	$result = '';
	$started = false;
	$currentQuesIndex;
	if(!isset($_GET['submit'])){
		//MAIL IS SET IF THE START BUTTON IS NOT CLICKED
		$mail = $_POST['mail'];
		//CHECK IF THE USER HAS ALREADY STARTED THE QUIZ
		$mail  = mysqli_real_escape_string($conn,$mail);
		$sql = "SELECT * FROM users WHERE email = '".$mail."'";
		$result = mysqli_query($conn,$sql);
		$user = mysqli_fetch_all($result,MYSQLI_ASSOC);
		if($user[0]['started'] == 'true'){
			$started = true;
			$currentQuesIndex = $user[0]['currentIndex'];
		}
	}
	else{
		$mail = $_GET['mail'];
		$mail = mysqli_real_escape_string($conn,$mail);
		$sql = "SELECT * FROM users WHERE email = '".$mail."'";
		$result = mysqli_query($conn,$sql);
		$user = mysqli_fetch_all($result,MYSQLI_ASSOC);
		if($user[0]['started'] == 'true'){
			//GO TO THE QUIZ QUESTION
			$started = true;
			//HIDDEN JS FORM TO SUBMIT EMAIL TO QUIZ PAGE VIA POST METHOD
			echo(
				"<form style='display:none;' name='form1' action='../quiz/quiz.php' method='POST'>
							<input type='hidden' name='mail' value='$mail'>
							<input type='start' name='start' value='start'>
						</form>
						<script type='text/javascript'>
							document.getElementsByName('form1')[0].submit();
				</script>"
			);
		}
		else{
			//GENERATE A RANDOM SUBSEQUENCE USING FISHER-YATES SHUFFLE ALGO
			$array = "";
			$setIndex = 1;
			$currentIndex = 1;
			$initial_array = array(0,1,2,3,4);
			for($i = 0;$i<=4;$i++){
				for($j=3;$j>=1;$j--){
					//SWAPPING THE ENTRIES
					$temp = rand(0,$j);
					$temp1 = $initial_array[$j];
					$initial_array[$j] = $initial_array[$temp];
					$initial_array[$temp] = $temp1;
				}
				for($k=0;$k<5;$k++){
					$array = $array."".$initial_array[$k];
				}
				$initial_array = array(0,1,2,3,4);
			}
			$started = "true";
			$started = mysqli_real_escape_string($conn,$started);
			$array  = mysqli_escape_string($conn,$array);
			$mail = mysqli_real_escape_string($conn,$mail);
			$sql = "UPDATE users
					SET `started`='".$started."', setIndex = 1, currentIndex = 1,`sequence`='".$array."'
					WHERE email = '".$mail."'";
			$result = mysqli_query($conn,$sql);
			if(!$result){
				echo "$result<br>";
			}
			else{
				//HIDDEN JS FORM TO SUBMIT EMAIL TO QUIZ PAGE VIA POST METHOD
				echo(
					"<form style='display:none;' name='form1' action='../quiz/quiz.php' method='POST'>
							<input type='hidden' name='mail' value='$mail'>
						</form>
						<script type='text/javascript'>
							document.getElementsByName('form1')[0].submit();
					</script>"
				);
			}

		}
	}


	mysqli_close($conn);

?>



<!DOCTYPE html>
<html>
<head>
	<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="./intro.css">
	<link rel="stylesheet" type="text/css" href="../common-styles/buttons.css">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Politics Inc - Homepage</title>
	<style>
		@media (max-width:500px){
			.button3--brown{
				font-size: 16px !important;
				padding:17px;
			}
		}
	</style>
</head>
<body>
	<div class="main">
		<?php include('../components/navbar2.php') ?>
		<div class="data">
			<?php if(!$started){ ?>
			<h4 class="text-heading">About the quiz<hr></h4>
			<div class="text-data">
				The quiz consists of 20 questions divided into 4 sections<br>
				Section 1 - Communism vs Fascism <br>
				Section 2 - Libertarianism vs Authoritarianism <br>
				Section 3 - Socialism vs Capitalism <br>
				Section 4 - Liberalism vs Conservatism <br>

				Each question has five options and each option descibes a different political stance
			</div>
			<div>
				<!-- Dummy form  -->
				<form action="intro.php" method="GET">
					<input type="submit" class="button3--brown" name="submit" value="START THE QUIZ">
					<input type="hidden" class="button3--brown" name="mail" value="<?php echo $mail?>">
				</form>

			</div>
			<?php }else if($started && $currentQuesIndex<21){ ?>
				<h4 class="text-heading">You have already started the quiz<hr></h4>
				<div class="text-data">Click the button to continue</div>
				<div>
					<!-- Dummy form  -->
					<form action="intro.php" method="GET">
						<input type="submit" class="button3--brown" name="submit" value="CONTINUE">
						<input type="hidden" class="button3--brown" name="mail" value="<?php echo $mail?>">
					</form>
				</div>

			<?php }else{ ?>
				<h4 class="text-heading">You have already finished the quiz<hr></h4>
				<div class="text-data">Click the button to view results</div>
				<div>
					<!-- Dummy form  -->
					<form action="intro.php" method="GET">
						<input type="submit" class="button3--brown" name="submit" value="VIEW RESULTS">
						<input type="hidden" class="button3--brown" name="mail" value="<?php echo $mail?>">
					</form>
				</div>
			<?php } ?>
		</div>
	</div>
</body>
</html>
