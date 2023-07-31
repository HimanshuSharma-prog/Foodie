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

        $fname=$row['f_name'];
        $lname=$row['l_name'];
        $uname=$row['username'];
        $mobile=$row['mobile'];
        $image=$row['uimage'];
        $address=$row['address'];
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
                        <img src="userimage/<?php echo"$image" ?>">
                        <p class="username"><?php echo"$uname" ?></p>
                        <!-- <div class="online">
                            <p> Online</p> 
                            <div class="circle"></div>
                        </div> -->
                    </div>
                    <ul id="navBtnDiv">
                        <li><a href="userdashboard.php" class="navBtn navactive"><i class='bx bx-user'></i> <p>Your Details</p><p class="option">Your Details</p></a></li>
                        <li><a href="orders.php" class="navBtn"><i class='bx bx-box' ></i> <p>Your Orders</p> <p class="option">Your Orders</p></a></li>
                        <li><a href="update_details.php" class="navBtn"><i class='bx bxs-user-detail' ></i> <p>Update Details</p> <p class="option">Update Details</p></a></li>
                        <li><a href="changepass.php" class="navBtn"><i class='bx bx-lock-alt' ></i> <p>Change Password</p> <p class="option">Change Password</p></a></li>
                    </ul>
                    <a href="logout.php" class="logoutbtn"><i class='bx bx-log-out' ></i> <p>Logout</p> <p class="option">Logout</p></a>
                </div>
                <div class="smalldiv" id="smallDiv">
                    <div class="detailsdiv">
                        <div class="smallcontainer">
                            <div class="orderdetailsdiv">
                                <div class="smallcard">
                                    <?php
                                        if(isset($_SESSION['id'])){
                                            $user_id=$_SESSION['id'];
                                            
                                            $sql="SELECT COUNT(id) AS total FROM user_orders WHERE user_id='".$user_id."'";
                                            $query=mysqli_query($conn,$sql);
                                            $t_orders=mysqli_fetch_assoc($query);
                                            $total_orders=$t_orders['total'];

                                            $sql1="SELECT COUNT(id) AS recieved FROM user_orders WHERE user_id='".$user_id."' AND order_status='recieved'";
                                            $query1=mysqli_query($conn,$sql1);
                                            $r_orders=mysqli_fetch_assoc($query1);
                                            $recived_orders=$r_orders['recieved'];

                                            $sql2="SELECT COUNT(id) AS canceled FROM user_orders WHERE user_id='".$user_id."' AND order_status='canceled'";
                                            $query2=mysqli_query($conn,$sql2);
                                            $c_orders=mysqli_fetch_assoc($query2);
                                            $canceled_orders=$c_orders['canceled'];

 
                                        }
                                    ?>
                                    <img src="images/total-order.png" alt="">
                                    <h1>Total Orders</h1>
                                    <h2><?php echo "$total_orders"; ?></h2>
                                </div>
                                <div class="smallcard">
                                    <img src="images/order-recieved.png" alt="">
                                    <h1>Recieved Orders</h1>
                                    <h2><?php echo "$recived_orders"; ?></h2>
                                </div>
                                <div class="smallcard">
                                    <img src="images/order-cancel.png" alt="">
                                    <h1>Canceled Orders</h1>
                                    <h2><?php echo "$canceled_orders"; ?></h2>
                                </div>
                            </div>
                            <div class="userdetailsdiv">
                                    <p>Username : <?php echo"$uname" ?></p>
                                    <p>Email : <?php echo"$email" ?></p>
                                    <p>Full Name: <?php echo"$fname" ?> <?php echo"$lname" ?></p>
                                    <p>Phone No : <?php echo"$mobile" ?></p>
                                    <p>Password : ********</p>
                                    <p>Address : <?php echo"$address" ?></p>
                            </div>
                        </div>
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