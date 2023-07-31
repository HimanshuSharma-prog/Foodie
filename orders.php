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
                        <li><a href="orders.php" class="navBtn navactive"><i class='bx bx-box' ></i> <p>Your Orders</p> <p class="option">Your Orders</p></a></li>
                        <li><a href="update_details.php" class="navBtn"><i class='bx bxs-user-detail' ></i> <p>Update Details</p> <p class="option">Update Details</p></a></li>
                        <li><a href="changepass.php" class="navBtn"><i class='bx bx-lock-alt' ></i> <p>Change Password</p> <p class="option">Change Password</p></a></li>
                    </ul>
                    <a href="logout.php" class="logoutbtn"><i class='bx bx-log-out' ></i> <p>Logout</p> <p class="option">Logout</p></a>
                </div>
                <div class="smalldiv" id="smallDiv">
                    
                    <!-----------------------------------------orders div--------------------------------->

                    <div class="ordersdiv"> 
                        <?php
                            if(isset($_SESSION['id'])){
                                $user_id=$_SESSION['id'];
                                $sql="SELECT * FROM user_orders WHERE user_id='".$user_id."' AND order_status='pending'";
                                $query=mysqli_query($conn,$sql);

                                if(mysqli_num_rows($query)>0){
                                    while($row=mysqli_fetch_array($query)){
                                        $f_name=$row['f_name'];
                                        $f_price=$row['f_price'];
                                        $f_qty=$row['f_qty'];
                                        $order_id=$row['order_id'];
                                        $f_image=$row['f_image'];
                                        $order_date=$row['order_date'];

                                        echo"<div class='div'>
                                        <div class='itemname'>
                                            <img src='fooditemimages/$f_image'>
                                            <div class='title'>                                
                                                <p>Name : $f_name</p>
                                                <p>Price : ₹ $f_price for one</p>
                                                <p>Qty : $f_qty</p>
                                                <p>Order date : $order_date</p>
                                            </div>
                                        </div>
                                        <div class='btndiv'>
                                            <a href='order_details.php?order_id=$order_id' class='btn'>Details</a>
                                            <a href='cancel_order.php?order_id=$order_id' class='btn'>Cancel order</a>
                                            <a href='invoice.php?order_id=$order_id' class='btn'>Invoice</a>
                                        </div>
                                    </div>";
                                    }
                                }

                                $sql1="SELECT * FROM user_orders WHERE user_id='".$user_id."' AND order_status='recieved'";
                                $query1=mysqli_query($conn,$sql1);

                                if(mysqli_num_rows($query1)>0){
                                    while($row1=mysqli_fetch_array($query1)){
                                        $f_name=$row1['f_name'];
                                        $f_price=$row1['f_price'];
                                        $f_qty=$row1['f_qty'];
                                        $order_id=$row1['order_id'];
                                        $f_image=$row1['f_image'];
                                        $order_date=$row1['order_date'];

                                        echo"<div class='div'>
                                        <div class='itemname'>
                                            <img src='fooditemimages/$f_image'>
                                            <div class='title'>                                
                                                <p>Name : $f_name</p>
                                                <p>Price : ₹ $f_price for one</p>
                                                <p>Qty : $f_qty</p>
                                                <p>Order date : $order_date</p>
                                            </div>
                                        </div>
                                        <div class='btndiv'>
                                            <a href='order_details.php?order_id=$order_id' class='btn'>Details</a>
                                            <a href='invoice.php?order_id=$order_id' class='btn'>Invoice</a>
                                        </div>
                                    </div>";
                                    }
                                }

                                $sql2="SELECT * FROM user_orders WHERE user_id='".$user_id."' AND order_status='canceled'";
                                $query2=mysqli_query($conn,$sql2);

                                if(mysqli_num_rows($query2)>0){
                                    while($row2=mysqli_fetch_array($query2)){
                                        $f_name=$row2['f_name'];
                                        $f_price=$row2['f_price'];
                                        $f_qty=$row2['f_qty'];
                                        $order_id=$row2['order_id'];
                                        $f_image=$row2['f_image'];
                                        $order_date=$row2['order_date'];

                                        echo"<div class='div'>
                                        <div class='itemname'>
                                            <img src='fooditemimages/$f_image'>
                                            <div class='title'>                                
                                                <p>Name : $f_name</p>
                                                <p>Price : ₹ $f_price for one</p>
                                                <p>Qty : $f_qty</p>
                                                <p>Order date : $order_date</p>
                                            </div>
                                        </div>
                                        <div class='btndiv'>
                                            <a href='order_details.php?order_id=$order_id' class='btn'>Details</a>
                                        </div>
                                    </div>";
                                    }
                                }
                                
                                $sql3="SELECT * FROM user_orders WHERE user_id='".$user_id."'";
                                $query3=mysqli_query($conn,$sql3);

                                if(mysqli_num_rows($query3)==0){
                                    echo "<div class='noorder'>
                                    <img src='images/no-orders.png'>
                                    <p>You have not ordered anything yet.</p>
                                </div>";
                                }
                                if(isset($_GET['error'])){
                                    $error=$_GET['error'];
                                    echo "$error";
                                }
                                if(isset($_GET['success'])){
                                    $success=$_GET['success'];
                                    echo "$success";
                                }
                            }
                        ?>
                        
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