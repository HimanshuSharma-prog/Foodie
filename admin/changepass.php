<?php
     ini_set('session.cookie_lifetime','2592000');

    session_start();
    include("db.php");

    if(!isset($_SESSION['a_id'])){
        header("Location:index.php?error= <div class='notification' id='notificationDiv'><div class='error'><p>First login for entering into dashboard..</p></div></div>");
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
   
    <link rel="stylesheet" href="css/dashboard.css?<?php echo time();?>">


    <link rel="shortcut icon" href="images/logo.png"><link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <link href='https://cdn.jsdelivr.net/npm/boxicons@2.0.5/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
</head>
<body>
    <div class="maindiv" id="maindiv">
        <div class="container">
            <div class="topnav">
                <div class="title">
                    <a href="dashboard.php">Foodie</a>
                    <p>for admin</p>
                </div>
                <div class="menubtn" id="menuBtn">
                    <i class='bx bx-menu' id="openBtn"></i><i class="fa fa-times" id="closeBtn"></i>
                </div>
            </div>

            <div class="maincontainer">
            <?php
                    if(isset($_SESSION['a_id'])){
                        $id=$_SESSION['a_id'];
                        $sql="SELECT * FROM admin WHERE admin_id='".$id."'";
                        $query=mysqli_query($conn,$sql);
                        $row=mysqli_fetch_array($query);

                        $image=$row['admin_image'];
                        $admin_name=$row['admin_name'];
                    }
                    if(isset($_GET['error'])){
                        $err=$_GET['error'];
                        echo "$err";
                    }
                ?>

                <!----------------------------sidenav-------------------------------->

                <div class="sidenav" id="sideNav">
                    <div class="userimg">
                        <img src="adminimages/<?php echo "$image";?>">
                        <p><?php echo "$admin_name";?></p>
                    </div>
                    <ul>
                        <li><a class="navBtn" href="dashboard.php"><i class='bx bx-home-alt'></i><span>Dashboard</span><p class="option">Dashboard</p></a></li>
                        <li><a href="users.php"><i class='bx bx-user'></i> <span>Total users</span> <p class="option">Total users</p></a></li>
                        <li><a href="emp.php"><i class='bx bxs-user' ></i> <span>Employee</span><p class="option">Employee</p></a></li>
                        <li><a class="navBtn" href="item.php"><i class='bx bx-box' ></i> <span>Total items</span> <p class="option">Total items</p></a></li>
                        <li><a class="navBtn" href="add_item.php"><i class='bx bx-add-to-queue'></i> <span>Add items</span> <p class="option">Add items</p></a></li>
                        <li><a class="navBtn" href="orders.php"><i class='bx bx-box'></i> <span>User orders</span> <p class="option">User orders</p></a></li>
                        <li><a class="navBtn" href="restaurant.php"><i class='bx bx-restaurant' ></i> <span>Restaurant</span> <p class="option">Restaurant</p></a></li>
                        <li><a class="navBtn" href="update_item.php"><i class='bx bxs-box' ></i> <span>Update items</span> <p class="option">Update items</p></a></li>
                        <li><a class="navBtn " href="review.php"><i class='bx bx-star' ></i> <span>All reviews</span> <p class="option">All reviews</p></a></li>
                        <li><a class="navBtn active" href="changepass.php"><i class='bx bx-lock-alt' ></i> <span>Change Password</span> <p class="option">Change Password</p></a></li>
                        <li> <a href="logout.php" class="logoutbtn"><i class='bx bx-log-out' ></i> <span>Logout</span> <p class="option">Logout</p></a></li>
                    </ul>
                </div>

            <!-------------------------content div----------------------->

            <div class="divcontainer">
            <?php
                if(isset($_SESSION['a_id'])){
                    $admin_email=$_SESSION['a_email'];
                    $admin_id=$_SESSION['a_id'];
                    $sql="SELECT * FROM admin WHERE admin_email='".$admin_email."' AND admin_id='".$admin_id."'";
                    $query=mysqli_query($conn,$sql);
            
                    $row=mysqli_fetch_array($query);
            
                    if(isset($_POST['oldpass'])){
                        $oldpass=md5($_POST['oldpass']);
                        $newpass=md5($_POST['newpass']);
                        $confirmpass=md5($_POST['confirmpass']);
            
                        $pass=$row['admin_password'];
            
                        if($oldpass != $pass){
                            echo(" <div class='notification' id='notificationDiv'>
                                        <div class='error'>
                                            <p>The old password did not match.</p>
                                    </div>
                                    </div>");
                        }elseif($newpass == $oldpass){
                            echo(" <div class='notification' id='notificationDiv'>
                                        <div class='error'>
                                            <p>You are not suppose to use old password as new password.</p>
                                    </div>
                                    </div>");
                        }elseif($newpass != $confirmpass){
                            echo(" <div class='notification' id='notificationDiv'>
                                        <div class='error'>
                                            <p>New password did not match.</p>
                                    </div>
                                    </div>");
                        }else{
                            $sql="UPDATE admin SET admin_password='$confirmpass' WHERE admin_id='".$admin_id."'";
                            $query=mysqli_query($conn,$sql);
            
                            if($query){
                                echo(" <div class='notification' id='notificationDiv'>
                                        <div class='success'>
                                            <p>Password updated successfully..</p>
                                    </div>
                                    </div>");
                            }else{
                                echo(" <div class='notification' id='notificationDiv'>
                                        <div class='error'>
                                            <p>Password not update.</p>
                                    </div>
                                    </div>");
                            }
                        }
                    }
            
                    
                }                
            ?>
                
                <!---------------------------------------change password  div------------------------->
                
               <div class="changepassdiv">
                    <form action="changepass.php" method="POST">
                        <input type="password" name="oldpass" placeholder="Old password">
                        <input type="password" name="newpass" placeholder="New password">
                        <input type="password" name="confirmpass" placeholder="Confirm password">
                        <input type="submit" value="Reset password" class="btn">
                    </form>
               </div>
               
                


            </div>


            </div>




        </div>

    </div>
    <script>
        var menuBtn=document.getElementById("menuBtn");
        var sideNav=document.getElementById("sideNav");
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
                var active=document.getElementsByClassName("active");
                active[0].className=active[0].className.replace(" active","");
                this.className += " active";
            });
        }
        
    </script>
</body>
</html>