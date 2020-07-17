<?php
    include('../components/connection.php');
    include('../components/questions.php');
    $user = null;
    $question = '';
    $setText = '';
    $mail = $_POST['mail'];
    $mail = mysqli_real_escape_string($conn,$mail);
    $sql = "SELECT * FROM users WHERE email='".$mail."'";
    $result = mysqli_query($conn,$sql);
    global $currentQuesIndex;
    global $setIndex;
    global $patternArray;
    if($result){
        $user = mysqli_fetch_array($result,MYSQLI_ASSOC);
        if($user){
            $currentQuesIndex = $user['currentIndex'];
            $setIndex = $user['setIndex'];
            $patternArray = $user['sequence'];
            if($currentQuesIndex>20){
                echo(
                    "<form id='form2' action='../result/result.php' method='POST'>
                        <input type='hidden' value='$mail' name='mail'>
                    </form>
                    <script>
                        document.getElementById('form2').submit();
                    </script>
                " );
            }
            else{
                $question = $questions[$setIndex-1][intval($patternArray[$currentQuesIndex-1])];
            }

        }

    }
    if(isset($_POST["$currentQuesIndex"]) && !isset($_POST['start']) && isset($_POST['data'])){
        //GO TO THE RESULT PAGE IF WE WERE ON THE LAST QUESTION

        $sql = "SELECT * FROM users WHERE email='".$mail."'";
        $result = mysqli_query($conn,$sql);
        $user = mysqli_fetch_array($result,MYSQLI_ASSOC);
        $string = 'set'.$setIndex;
        $currentValue = $user[$string];
        $updatedValue = intval($currentValue) + intval($_POST['data'])/5;
        $sql = "UPDATE users
                    SET $string=$updatedValue
                    WHERE email='".$mail."'";
        $result = mysqli_query($conn,$sql);
        $currentQuesIndex++;
        $setIndex = floor(($currentQuesIndex-1)/5) + 1;
        if($currentQuesIndex>20){
            if($currentQuesIndex==21){
                $sql = "UPDATE users
                            SET currentIndex=$currentQuesIndex, setIndex=$setIndex
                            WHERE email='".$mail."'";
                $result = mysqli_query($conn,$sql);
            }
            echo(
                "<form id='form1' action='../result/result.php' method='POST'>
                    <input type='hidden' value='$mail' name='mail'>
                </form>
                <script>
                    document.getElementById('form1').submit();
                </script>
            " );
        }
        else{
            $question = $questions[$setIndex-1][intval($patternArray[$currentQuesIndex-1])];
            $sql = "UPDATE users
                        SET currentIndex=$currentQuesIndex, setIndex=$setIndex
                        WHERE email='".$mail."'";
            $result = mysqli_query($conn,$sql);
        }


    }
    switch ($setIndex){
        case 1:$setText = "Set 1: Communism vs Fascism";
                break;
        case 2:$setText = "Set 2: Libertarianism vs Authoritarianism";
                break;
        case 3:$setText = "Set 3: Socialism vs Capitalism";
                break;
        case 4:$setText = "Set 4: Liberalism vs Conservatism";
                break;
        default: break;
    }
    mysqli_close($conn);


?>


<!DOCTYPE html>
<html>
<head>
	<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="./quiz.css">
    <link rel="stylesheet" type="text/css" href="../common-styles/buttons.css">
    <link rel="stylesheet" type="text/css" href="../common-styles/radio.css">
    <meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Politics Inc - Quiz</title>
</head>
<body>
    <div class="main">
        <?php include("../components/navbar3.php") ?>
        <hr style="border:1px solid #e0e0c0;margin:0 10px;background-color:#e0e0e0">
        <div>
            <div class='set-text'><?php echo $setText; ?></div>
            <div class='area-question'><?php
                echo $question;
            ?></div>
            <div class="options-large">
                <!-- <ul class="options">
                    <li style="border-color:#14a76c; color:#14a76c;" value="" name="80">Completely agree </li>
                    <li style="border-color:#14a76c9f; color:#14a76c9f">Partially Agree </li>
                    <li style="border-color:#f0f0f07f; color:#f0f0f07f">Neither Agree nor Disagree </li>
                    <li style="border-color:#ff652f9f; color:#ff652f9f">Partially Disagree</li>
                    <li style="border-color:#ff652f; color:#ff652f">Completely Disagree</li>
                </ul> -->
                <form action="quiz.php" method="POST">
                <section class="dark">
                    <label>
                        <input type="radio" name="dark" value="100">
                        <span class="design"></span>
                        <span class="text">Agree fully</span>
                    </label>

                    <label>
                        <input type="radio" name="dark" value="75">
                        <span class="design"></span>
                        <span class="text">Agree partially</span>
                    </label>

                    <label>
                        <input type="radio" name="dark" value="50" checked>
                        <span class="design"></span>
                        <span class="text">Neither agree nor disagree</span>
                    </label>
                    <label>
                        <input type="radio" name="dark" value="25">
                        <span class="design"></span>
                        <span class="text">Disagree partially</span>
                    </label>
                    <label>
                        <input type="radio" name="dark" value="0">
                        <span class="design"></span>
                        <span class="text">Disagree fully</span>
                    </label>
                    <input type="hidden" style="all:unset;" name="mail" value="<?php echo $mail ?>">
                    </section>
                    <input id='something' type='hidden' value = '50' name = 'data'>
                          <script type="text/javascript">
                            let c = document.getElementsByName('dark');
                            c.forEach((input)=>{
                                input.addEventListener("click",()=>{
                                    document.getElementById('something').value = input.value;
                                    console.log(document.getElementById('something').value);
                                });
                            });
                          </script>
                    <span style="display:inline-block; text-align:center; width:100%; max-width:250px; cursor:pointer;" class="button3">
                        <input type="submit" style="all:unset;" name="<?php echo $currentQuesIndex; ?>" value="Continue">

                    </span>
                </form>
            </div>

        </div>
    </div>


</body>
</html>
