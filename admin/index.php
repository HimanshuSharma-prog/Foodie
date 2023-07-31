<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Foodie</title>
    <link rel="manifest" href="/mainfest.json">
   
    <link rel="stylesheet" href="css/style.css?<?php echo time();?>">


    <link rel="shortcut icon" href="images/logo.png"><link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <link href='https://cdn.jsdelivr.net/npm/boxicons@2.0.5/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
</head>
<body>
    <div class="maindiv" id="maindiv">
        <?php 
            include("db.php");
             ini_set('session.cookie_lifetime','2592000');

    session_start();
            if(isset($_POST['email'])){
                $email=$_POST['email'];
                $password=md5($_POST['password']);
        
                $sql="select * from admin where admin_email='".$email."'AND admin_password='".$password."' limit 1";
        
                $result=mysqli_query($conn,$sql);
        
                $count=mysqli_num_rows($result); 
                
                if($count==1){
                    $row=mysqli_fetch_array($result);
                    $_SESSION['a_id']=$row['admin_id'];
                    $_SESSION['a_name']=$row['admin_name'];
                    $_SESSION['a_email']=$row['admin_email'];

                    header("Location:dashboard.php");
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
                            </div>
                            </div>");
            }
        ?>
        <div class="admindiv">
            <div class="logindiv">
                <div class="title">
                    <a href="#">Foodie</a>
                    <p>Admin login</p>
                </div>
                <div class="formdiv">
                    <img src="images/formimg.jpg">
                    <form action="index.php" method="POST">
                        <div class="email">
                            <i class="fa fa-envelope-o"></i>
                            <input type="email" name="email" placeholder="Admin Email" required>
                        </div>
                        <div class="password">
                            <i class='bx bx-lock' ></i>
                            <input type="password" name="password" id="passInput" placeholder="Password" required>
                            <i class='bx bx-show' id="showPass"></i><i class='bx bx-hide' id="hidePass"></i>
                        </div>
                        <input type="submit" value="Login" class="btn">
                        <p>Don't have account? <a href="signup.php">Sign up</a></p>
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
    </script>
    <!-- <script>
        var menuBtn=document.getElementById("menuBtn");
        var sideNav=document.getElementById("sideNav");
        var smallDiv=document.getElementById("smallDiv");
        var closeBtn=document.getElementById("closeBtn");
        var openBtn=document.getElementById("openBtn");

        if(screen.width > 450){
            $(document).ready(function(){
                sideNav.style.marginLeft="0px";
            });
        }; 

        menuBtn.onclick=function(){
            if(sideNav.style.marginLeft == "0px"){
                sideNav.style.marginLeft="-320px";
                closeBtn.style.display="none";
                openBtn.style.display="block";
            }
            else{
                sideNav.style.marginLeft="0px";
                closeBtn.style.display="block";
                openBtn.style.display="none";
            }
        }

        var navBtnDiv=document.getElementById("navBtnDiv");
        var navBtn=document.getElementsByClassName("navBtn");

        for(var i=0;i<navBtn.length;i++){
            navBtn[i].addEventListener("click",function(){
                var active=document.getElementsByClassName("navactive");
                active[0].className=active[0].className.replace(" navactive","");
                this.className += " navactive";
            });
        }
    </script> -->
</body>
</html>