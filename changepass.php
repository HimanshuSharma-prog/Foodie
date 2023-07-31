<?php
     ini_set('session.cookie_lifetime','2592000');

    session_start();
    if(!isset($_SESSION['id'])){
         header('Location:/index.php');
     }

    include("db.php");
    if(isset($_SESSION['email'])){
        $email=$_SESSION['email'];
        $id=$_SESSION['id'];
        $sql="SELECT * FROM users WHERE email='$email' AND uid='$id'";
        $query=mysqli_query($conn,$sql);

        $row=mysqli_fetch_array($query);
        $image=$row['uimage'];
        $uname=$row['username'];
    }
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
    <link rel="stylesheet" href="css/dashboard.css?<?php echo time();?>">


    <link rel="shortcut icon" href="images/logo.png"><link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <link href='https://cdn.jsdelivr.net/npm/boxicons@2.0.5/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
</head>
<body>
    <div class="maindiv" id="maindiv">
        <div class="usercontainer">
            <div class="navcontainer">
                <div class="nav">
                    <div class="title">
                         <a href="index.php">Foodie</a>
                    </div>
                    <div class="menudiv">
                        <a href="#" id="menuBtn" class="menubtn">
                            <i class='bx bx-menu' id="openBtn"></i><i class="fa fa-times-circle" id="closeBtn"></i>
                        </a>
                    </div>
                </div>
            </div>
            <!--  -->
            <div class="maincontainer">
                <div class="sidenav" id="sideNav">
                    <div class="userimg">
                    <img src="userimage/<?php echo "$image" ?>">
                        <p class="username"><?php echo "$uname" ?></p>
                        <!-- <div class="online">
                            <p> Online</p> 
                            <div class="circle"></div>
                        </div> -->
                    </div>
                    <ul id="navBtnDiv">
                        <li><a href="userdashboard.php" class="navBtn"><i class='bx bx-user'></i> <p>Your Details</p><p class="option">Your Details</p></a></li>
                        <li><a href="orders.php" class="navBtn"><i class='bx bx-box' ></i> <p>Your Orders</p> <p class="option">Your Orders</p></a></li>
                        <li><a href="update_details.php" class="navBtn"><i class='bx bxs-user-detail' ></i> <p>Update Details</p> <p class="option">Update Details</p></a></li>
                        <li><a href="changepass.php" class="navBtn navactive"><i class='bx bx-lock-alt' ></i> <p>Change Password</p> <p class="option">Change Password</p></a></li>
                    </ul>
                    <a href="logout.php" class="logoutbtn"><i class='bx bx-log-out' ></i> <p>Logout</p> <p class="option">Logout</p></a>
                </div>
                <div class="smalldiv" id="smallDiv">
                    
                    <!-----------------------------------------change password  div--------------------------------->
                     <div class="code">
                        <?php
                            if(isset($_SESSION['email'])){
                                $email=$_SESSION['email'];
                                $id=$_SESSION['id'];
                                $sql="SELECT * FROM users WHERE email='$email' AND uid='$id'";
                                $query=mysqli_query($conn,$sql);
                        
                                $row=mysqli_fetch_array($query);
                        
                                if(isset($_POST['oldpass'])){
                                    $oldpass=md5($_POST['oldpass']);
                                    $newpass=md5($_POST['newpass']);
                                    $confirmpass=md5($_POST['confirmpass']);
                        
                                    $pass=$row['password'];
                        
                                    if($oldpass != $pass){
                                        echo(" <div class='notification' id='notificationDiv'>
                                                    <div class='error'>
                                                        <p>The old password did not match.</p>
                                                </div>");
                                    }elseif($newpass == $oldpass){
                                        echo(" <div class='notification' id='notificationDiv'>
                                                    <div class='error'>
                                                        <p>You are not suppose to use old password as new password.</p>
                                                </div>");
                                    }elseif($newpass != $confirmpass){
                                        echo(" <div class='notification' id='notificationDiv'>
                                                    <div class='error'>
                                                        <p>New password did not match.</p>
                                                </div>");
                                    }else{
                                        $sql="UPDATE users SET password='$confirmpass' WHERE uid='$id'";
                                        $query=mysqli_query($conn,$sql);
                        
                                        if($query){
                                            echo(" <div class='notification' id='notificationDiv'>
                                                    <div class='success'>
                                                        <p>Password updated successfully..</p>
                                                </div>");
                                        }else{
                                            echo(" <div class='notification' id='notificationDiv'>
                                                    <div class='error'>
                                                        <p>Password not update.</p>
                                                </div>");
                                        }
                                    }
                                }
                        
                                
                            }
                        ?>
                     </div>
                    <div class="changepassdiv">
                        <form action="changepass.php" method="POST">
                            <input type="text" name="oldpass" placeholder="Old password">
                            <input type="text" name="newpass" placeholder="New password">
                            <input type="text" name="confirmpass" placeholder="Confirm password">
                            <input type="submit" value="Change password" class="btn">
                        </form>
                    </div>
                    





                </div> 
            </div>
            
        </div>

    </div>

    <script>
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
        
        document.getElementById("notificationDiv").onmousemove=function(){
            document.getElementById("notificationDiv").style.top="-20vh";
        }
    </script>
</body>
</html>