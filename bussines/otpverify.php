<?php
    include('db.php');
     ini_set('session.cookie_lifetime','2592000');

    session_start();    
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Foodie</title>
    <link rel="manifest" href="/mainfest.json">
   
    <link rel="stylesheet" href="css/style.css?<?php echo time();?>">
    <link rel="stylesheet" href="css/responsive.css?<?php echo time();?>">


    <link rel="shortcut icon" href="images/logo.png"><link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <link href='https://cdn.jsdelivr.net/npm/boxicons@2.0.5/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
</head>
<body>
    <div class="maindiv" id="maindiv">
        <div class="code">
            <?php 
                if(isset($_SESSION['otp_e_id'])){
                    if(isset($_POST['otp'])){
                        
                        $id=$_SESSION['otp_e_id'];
                        $otp=$_POST['otp'];

                        $sql="SELECT * from empotp where emp_id='".$id."' limit 1";
                        $query=mysqli_query($conn,$sql);

                        $row=mysqli_fetch_array($query);
                         
                        if($otp == $row['otp']){
                            $emp_id=$row['emp_id'];
                            $sql1="SELECT * FROM emp WHERE emp_id='".$emp_id."'";
                            $query1=mysqli_query($conn,$sql1);
                            if(mysqli_num_rows($query1)==1){
                                $row1=mysqli_fetch_array($query1);
                                $_SESSION['e_id']=$row1['emp_id'];
                                $_SESSION['e_name']=$row1['emp_name'];
                                $_SESSION['e_email']=$row1['emp_email'];
                            }
                            header('Location:index.php');
                        }
                        else{
                            echo(" <div class='notification' id='notificationDiv'>
                            <div class='error'>
                                <p>Your otp is wrong....</p>
                            </div>");
                        }  
                    }
                }else{
                    echo(" <div class='notification' id='notificationDiv'>
                            <div class='error'>
                                <p>Something went wrong please try again..</p>
                            </div>
                            </div>");
                }
            ?>
        </div>
        <div class="otpdiv">
            <div class="nav">
                <a href="index.php">Foodie</a>
                <p>OTP verification</p>
            </div>

            <div class="formdiv">
                <form action="otpverify.php" method="POST">
                    <p>Enter the otp that has sended on your email</p>
                    <input type="text" name="otp" placeholder="Enter OTP">
                    <input type="submit" value="Verify OTP" class="btn">
                </form>
            </div>
        </div>

    </div>
    <script>
        document.getElementById("notificationDiv").onmousemove=function(){
            document.getElementById("notificationDiv").style.top="-20vh";
        }
    </script>

</body>
</html>