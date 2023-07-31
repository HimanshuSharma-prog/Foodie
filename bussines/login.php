<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Foodie</title>
    <link rel="manifest" href="/mainfest.json">
   
    <link rel="stylesheet" href="css/style.css?<?php echo time();?>">
    <link rel="stylesheet" href="css/responsive.css">

    <link rel="shortcut icon" href="images/logo.png">
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <link href='https://cdn.jsdelivr.net/npm/boxicons@2.0.5/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
</head>
<body>
    <div class="maindiv" id="maindiv">
    <div class="code">
        <?php 
            include("db.php");
             ini_set('session.cookie_lifetime','2592000');

    session_start();
            if(isset($_POST['email'])){
                $email=$_POST['email'];
                $password=md5($_POST['password']);
        
                $sql="select * from emp where emp_email='".$email."'AND emp_password='".$password."' limit 1";
        
                $result=mysqli_query($conn,$sql);
        
                $count=mysqli_num_rows($result); 
                
                if(mysqli_num_rows($result)==1){
                    $otp=rand(1111,9999);
        
                    $to_email = $_POST['email'];
                    $subject = "OTP verification";
                    $body = "Your otp for login as employee : ".$otp;
                    $headers = "From: foodie";

        
                    if (mail($to_email, $subject, $body, $headers)) {

                        
                        if($count==1){
                            $row=mysqli_fetch_array($result);
                            $_SESSION['otp_e_id']=$row['emp_id'];
                        }

                        $user_id=$_SESSION['otp_e_id'];

                        $sql="SELECT * FROM empotp WHERE emp_id='".$user_id."' AND emp_email='".$email."' limit 1";
                        $query=mysqli_query($conn,$sql);


                        if(mysqli_num_rows($query)==1){

                            $sql="UPDATE empotp SET otp='$otp' WHERE emp_id='$user_id'";
                            $query=mysqli_query($conn,$sql);

                            if($query){
                                header('Location:otpverify.php');
                            }
                            
        
                        }else{
                            $sql="INSERT INTO empotp(emp_id,emp_email,otp)VALUES('$user_id','$email','$otp')";
                            $query=mysqli_query($conn,$sql);

                            
                            if($query){
                                header('Location:otpverify.php');
                            }
                        }
                       
                    } else {
                        echo(" <div class='notification' id='notificationDiv'>
                            <div class='error'>
                                <p>OTP did not send check your email and network..........</p>
                            </div>");
                    }
        
                    
                }else{
                    echo(" <div class='notification' id='notificationDiv'>
                            <div class='error'>
                                <p>You Have Entered Incorrect email & password..</p>
                            </div>
                            </div>");
                }                     
            }
            if(isset($_GET['error'])){
                $err=$_GET['error'];
                echo(" <div class='notification' id='notificationDiv'>
                            <div class='error'>
                                <p>$err</p>
                            </div>");
            }
        ?>
    </div>

        <!-----------------------------login form--------------------------------->
        <div class="formcontainer" id="formDiv">
                <div class="formdiv" >
                    <div class="title">
                        <a href="#">Foodie</a>
                        <p>For Business</p>
                    </div>
                    <div class="col">
                        <img src="images/formimg.jpg">
                        <form action="login.php" method="POST">
                            <div class="username">
                                <i class="fa fa-envelope-o"></i>
                                <input type="email" name="email" placeholder="Your Email" required>
                            </div>
                            <div class="password">
                                <i class='bx bx-lock' ></i>
                                <input type="password" name="password" id="passInput" placeholder="Password" required>
                                <i class='bx bx-show' id="showPass"></i><i class='bx bx-hide' id="hidePass"></i>
                            </div>
                            <input type="submit" value="Login" class="loginbtn">
                            <p>Don't have account? <a href="signup.php">Create Account</a></p>
                            <p><a href="#">Forgot Password?</a></p>
                        </form>
                    </div>
                </div>
            </div>

            </div>   
    
    <script>
        document.getElementById("showPass").onclick=function(){
            document.getElementById("passInput").type="text";
            document.getElementById("hidePass").style.display="block";
            document.getElementById("showPass").style.display="none";
        }
        document.getElementById("hidePass").onclick=function(){
            document.getElementById("passInput").type="password";
            document.getElementById("showPass").style.display="block";
            document.getElementById("hidePass").style.display="none";
        }       
        document.getElementById("notificationDiv").onmousemove=function(){
            document.getElementById("notificationDiv").style.top="-20vh";
        }
    </script>
</body>
</html>