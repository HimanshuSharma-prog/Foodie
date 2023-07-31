<?php
    include('db.php');  
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
                if(isset($_POST['reg_email'])){
                    $email=$_POST['reg_email'];

                    $sql="SELECT * FROM users WHERE email='$email'";
                    $query=mysqli_query($conn,$sql);
                    $row=mysqli_fetch_array($query);
                    $id=$row['uid'];

                    if(mysqli_num_rows($query)==0){  
                        echo(" <div class='notification' id='notificationDiv'>
                        <div class='error'>
                            <p>Email address is not registered..</p>
                        </div>");
                    }else{
                        $to_email = $email;
                        $subject = "Update password";
                        $body = "For updating your password visit http://localhost/verifyid.php?id=$id";
                        $headers = "From: foodie";
                        $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
    
            
                        if (mail($to_email, $subject, $body, $headers)) {
                            echo(" <div class='notification' id='notificationDiv'>
                            <div class='success'>
                                <p>Check your email for updating your password</p>
                            </div>");
                        }
                    }




                    // $newpass=md5($_POST['newpass']);
                    // $email=$_POST['email'];
                    // $confirmpass=md5($_POST['confirmpass']);

                    // $sql="SELECT * FROM users WHERE email='$email'";
                    // $query=mysqli_query($conn,$sql);

                    // if(mysqli_num_rows($query)==0){  
                    //     echo(" <div class='notification' id='notificationDiv'>
                    //     <div class='error'>
                    //         <p>Email address is not registered..</p>
                    //     </div>");
                    // }else{
                    //     $row=mysqli_fetch_array($query);
                    //     $id=$row['uid'];

                    //     if($newpass!=$confirmpass){
                    //         echo(" <div class='notification' id='notificationDiv'>
                    //         <div class='error'>
                    //             <p>Password did not match..</p>
                    //         </div>");
                    //     }else{
                    //         $sql1="UPDATE users SET password='$confirmpass' WHERE email='$email'AND uid='$id'";
                    //         $query=mysqli_query($conn,$sql1);
    
                    //         if($query){
                    //             echo(" <div class='notification' id='notificationDiv'>
                    //             <div class='success'>
                    //                 <p>Password updated successfully..</p>
                    //             </div>");
                    //         }
                    //     }
                        
                    // }
                    
                }
            ?>
        </div>
        <div class="otpdiv">
            <div class="nav">
                <a href="index.php">Foodie</a>
                <p>Forgot paasword</p>
            </div>

            <div class="formdiv">
                <form action="forgotpassword.php" method="POST">
                    <p>Enter your email from which you have registered</p>
                    <input type="email" name="reg_email" placeholder="Enter your email">
                    <input type="submit" value="Send email" class="btn">
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