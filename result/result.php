
<?php
    include ('../components/connection.php');
    $mail;
    if(isset($_POST['mail'])){
        $mail = $_POST['mail'];
    }
    $mail = mysqli_escape_string($conn,$mail);
    $sql = "SELECT * FROM users WHERE email='".$mail."'";
    $result = mysqli_query($conn,$sql);
    $set1;$set2;$set3;$set4;$user;$currentIndex;
    $average1=0;
    $average2=0;
    $average3=0;
    $average4=0;
    if($result){
        $user = mysqli_fetch_array($result,MYSQLI_ASSOC);
        $currentIndex = $user['currentIndex'];
        $set1 = $user['set1'];
        $set2 = $user['set2'];
        $set3 = $user['set3'];
        $set4 = $user['set4'];
        $sql = "SELECT * FROM users WHERE currentIndex > 20";
        $result = mysqli_query($conn,$sql);
        if($result){
            $users  = mysqli_fetch_all($result,MYSQLI_ASSOC);
            for($i=0;$i<count($users);$i++){
                $average1 += $users[$i]['set1'];
                $average2 += $users[$i]['set2'];
                $average3 += $users[$i]['set3'];
                $average4 += $users[$i]['set4'];
            }
            $average1/=count($users);
            $average2/=count($users);
            $average3/=count($users);
            $average4/=count($users);
        }
    }


?>


<!DOCTYPE html>
<html>
<head>
	<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="./result.css">
    <link rel="stylesheet" type="text/css" href="../common-styles/buttons.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.0.0-alpha/Chart.min.js"></script>
	<title>Politics Inc - Result</title>
</head>
<body>
    <div class="main">
    <!-- <?php include('../components/navbar2.php') ?> -->
        <div class="text">
        Your personal agreements with test data are as follows
        </div>
        <div class="literature">

            <div class="chart" style="position:relative;">
                <canvas id="myChart">
                    <script>
                        var ctx = document.getElementById('myChart').getContext('2d');
                        var chartOptions = {
                                aspectRatio:1,
                                scale: {
                                    beginAtZero : true,
                                    max:100,
                                    ticks:{
                                        beginAtZero: true,
                                        min: 0,
                                        max:100,
                                        display:true,
                                        showLabelBackdrop:false,
                                        fontSize:13,
                                        fontColor: '#dddccc',
                                        spanSize:10
                                    },
                                    angleLines:{
                                        color:'#dddccc',

                                    },
                                    pointLabels:{
                                        fontSize:16,
                                        fontColor:'#dddccc'
                                    },
                                    fontSize:13,
                                    gridLines:{
                                        display: true,
                                        color: '#dddccc'
                                    }
                                },
                                legend:{
                                    labels:{
                                        fontSize:18,
                                        fontColor: '#dddccc'
                                    }
                                }
                            };

                        var myChart = new Chart(ctx, {
                            type: 'radar',
                            data: {
                                labels: ['Fascist','Authoritarian','Capitalist','Conservative','Communist','Libertarian','Socialist','Liberal'],
                                datasets: [
                                    {
                                        label: 'You',
                                        backgroundColor: '#ffff0088',
                                        borderWidth: 1,
                                        data: [
                                            <?php echo 100 - $set1;?>,
                                            <?php echo 100 - $set2;?>,
                                            <?php echo $set3;?>,
                                            <?php echo 100 - $set4;?>,
                                            <?php echo $set1; ?>,
                                            <?php echo $set2; ?>,
                                            <?php echo 100 - $set3; ?>,
                                            <?php echo $set4; ?>],
                                        pointRadius: 5,
                                        borderColor: '#ffff00',
                                        pointBackgroundColor: '#ffff00'
                                    },
                                    {
                                        label: 'Average User',
                                        backgroundColor: '#00ff0088',
                                        borderWidth: 1,
                                        data: [
                                            <?php echo 100 - $average1;?>,
                                            <?php echo 100 - $average2;?>,
                                            <?php echo $average3;?>,
                                            <?php echo 100 - $average4;?>,
                                            <?php echo $average1 ?>,
                                            <?php echo $average2 ?>,
                                            <?php echo 100 - $average3 ?>,
                                            <?php echo $average4 ?>],
                                        pointRadius: 5,
                                        borderColor: '#00ff00',
                                        pointBackgroundColor: '#00ff00'
                                    }
                                ]
                            },
                            options : chartOptions ,

                        });
                        console.log(myChart.config.options.scales.r)
                        // myChart.scales.r.min = 0;
                        // myChart.scales.r.max = 100;
                        // myChart.scales.r.start = 0;
                        // myChart.scales.r.end = 100;
                    </script>


                </canvas>
            </div>

        </div>
        <form action="../main/intro.php" method="POST" id="form1">
            <input type='hidden' value=<?php echo $mail ?> name='mail'>
            <div class="button2" style="position: relative; left: 50%; transform: translateX(-50%);">
                        <span style="font-size:18px; font-weight:bold;">
                            <input type="submit" style="all:unset;" value="Back to Home" name="submit">
                        </span>
            </div>

        </form>


    </div>
</body>
</html>
