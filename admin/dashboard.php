<?php
     ini_set('session.cookie_lifetime','2592000');

    session_start();
    include("db.php");
    date_default_timezone_set('Asia/Kolkata'); 
    if(!isset($_SESSION['a_id'])){
        header("Location:index.php?error= <div class='notification' id='notificationDiv'><div class='error'><p>First login for entering into dashboard..</p></div></div></div>");
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
                <div class="btndiv">
                    <div class="notifybtn">
                        <i class='bx bxs-bell' id="notifyBtn"></i>
                    </div>
                    <div class="menubtn" id="menuBtn">
                        <i class='bx bx-menu' id="openBtn"></i><i class="fa fa-times" id="closeBtn"></i>
                    </div>
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
                    
                    if(isset($_GET['success'])){
                        $successs=$_GET['success'];
                        echo "$successs";
                    }
                    if(isset($_GET['notify_remove'])){
                        $notify_remove=$_GET['notify_remove'];
                        $sql="UPDATE user_orders SET notify='seen' WHERE id='".$notify_remove."'";
                        $query=mysqli_query($conn,$sql);
                    }
                ?>

                <!----------------------------sidenav-------------------------------->

                <div class="sidenav" id="sideNav">
                    <div class="userimg">
                        <img src="adminimages/<?php echo "$image";?>">
                        <p><?php echo "$admin_name";?></p>
                    </div>
                    <ul>
                        <li><a class="navBtn active" href="dashboard.php"><i class='bx bx-home-alt'></i><span>Dashboard</span><p class="option">Dashboard</p></a></li>
                        <li><a href="users.php"><i class='bx bx-user'></i> <span>Total users</span> <p class="option">Total users</p></a></li>
                        <li><a href="emp.php"><i class='bx bxs-user' ></i> <span>Employee</span><p class="option">Employee</p></a></li>
                        <li><a class="navBtn" href="item.php"><i class='bx bx-box' ></i> <span>Total items</span> <p class="option">Total items</p></a></li>
                        <li><a class="navBtn" href="add_item.php"><i class='bx bx-add-to-queue'></i> <span>Add items</span> <p class="option">Add items</p></a></li>
                        <li><a class="navBtn" href="orders.php"><i class='bx bx-box'></i> <span>User orders</span> <p class="option">User orders</p></a></li>
                        <li><a class="navBtn" href="restaurant.php"><i class='bx bx-restaurant' ></i> <span>Restaurant</span> <p class="option">Restaurant</p></a></li>
                        <li><a class="navBtn" href="update_item.php"><i class='bx bxs-box' ></i> <span>Update items</span> <p class="option">Update items</p></a></li>
                        <li><a class="navBtn " href="review.php"><i class='bx bx-star' ></i> <span>All reviews</span> <p class="option">All reviews</p></a></li>
                        <li><a class="navBtn" href="changepass.php"><i class='bx bx-lock-alt' ></i> <span>Change Password</span> <p class="option">Change Password</p></a></li>
                        <li> <a href="logout.php" class="logoutbtn"><i class='bx bx-log-out' ></i> <span>Logout</span> <p class="option">Logout</p></a></li>
                    </ul>
                </div>

                <!-----------------------------------------div container------------------------------>

                <div class="divcontainer">

                <div class="notifydiv" id="notifyDiv">
                    <?php
                        if(isset($_SESSION['a_id'])){
                            $emp_id=$_SESSION['a_id'];
                            $sql="SELECT * FROM user_orders WHERE emp_id='".$emp_id."' AND notify='send'";
                            $query=mysqli_query($conn,$sql);
                            if(mysqli_num_rows($query)>0){
                                while($row=mysqli_fetch_array($query)){
                                    $user_id=$row['user_id'];
                                    $f_id=$row['f_id'];
                                    $f_name=$row['f_name'];
                                    $f_qty=$row['f_qty'];

                                    $update_id=$row['id'];

                                    $order_time=$row['order_time'];

                                    $sql1="SELECT * FROM users WHERE uid='".$user_id."'";
                                    $query1=mysqli_query($conn,$sql1);

                                    $row1=mysqli_fetch_array($query1);
                                    $u_address=$row1['address'];
                                    
                                    echo" <div class='div'>
                                            <div class='closebtn'>
                                                <p> New order recieved</p>
                                                <a href='dashboard.php?notify_remove=$update_id'> <i class='fa fa-times' aria-hidden='true' class='closeNotify'></i></a>
                                            </div>
                                            <p><strong>Food id</strong> : $f_id</p>
                                            <p><strong>Item name</strong> : $f_name </p>
                                            <p><strong>Quantity</strong> : $f_qty </p>
                                            <p><strong>Delivery address</strong> : $u_address</p>
                                        </div>";
                                    
                                        $time1=strtotime($order_time);
                                        $time=  date("h:i:s");
                                        $time2=strtotime($time);
                                        $final_time=($time2 - $time1)/60;
            
                                        $time=abs($final_time*60);
                                      
                                }
                                if($time < 60){
                                    $txt="a new ".$f_name."order received check the notification for more details";
                                    $txt=htmlspecialchars($txt);
                                    $txt=rawurlencode($txt);
                                    $audio=file_get_contents('https://translate.google.com/translate_tts?ie=UTF-8&client=gtx&q='.$txt.'&tl=en-IN');
                                    $speech="<audio controls='controls' autoplay style='display: none;'><source src='data:audio/mpeg;base64,".base64_encode($audio)."'</audio>";
                                    echo "$speech";
                                }
                                

                            }else{
                                echo" <div class='nonotify'>
                                <img src='images/no-notify.png' alt=''>
                                <p>No notification</p>
                            </div>";
                            }
                        }
                       
                    ?>
                   
                </div>  


                <?php
                    if(isset($_SESSION['a_id'])){
                        $emp_id=$_SESSION['a_id'];
                        $sql="SELECT * FROM user_orders WHERE emp_id='".$emp_id."' AND order_status='recieved'";
                        $query=mysqli_query($conn,$sql);

                        if(mysqli_num_rows($query)>0){
                            $total_income=0;
                            while($row=mysqli_fetch_array($query)){
                                $income=$row['t_price'];
                                $income_array=array($income);
                                $income_sum=array_sum($income_array);
                                $total_income+=$income_sum;
                            }
                        }else{
                            $total_income=0;
                        }

                        $sql1="SELECT COUNT(f_id) AS items FROM fooditems WHERE emp_id='".$emp_id."'";
                        $query1=mysqli_query($conn,$sql1);
                        $items=mysqli_fetch_assoc($query1);
                        $total_items=$items['items'];

                        $sql1="SELECT COUNT(f_id) AS items FROM fooditems WHERE emp_id='".$emp_id."'";
                        $query1=mysqli_query($conn,$sql1);
                        $items=mysqli_fetch_assoc($query1);
                        $total_items=$items['items'];

                        $sql1="SELECT COUNT(f_id) AS available FROM fooditems WHERE emp_id='".$emp_id."' AND f_status='Available'";
                        $query1=mysqli_query($conn,$sql1);
                        $available=mysqli_fetch_assoc($query1);
                        $total_available=$available['available'];

                        $sql1="SELECT COUNT(f_id) AS not_available FROM fooditems WHERE emp_id='".$emp_id."' AND f_status='Not available'";
                        $query1=mysqli_query($conn,$sql1);
                        $not_available=mysqli_fetch_assoc($query1);
                        $total_not_available=$not_available['not_available'];

                        $sql1="SELECT COUNT(order_id) AS orders FROM user_orders WHERE emp_id='".$emp_id."'";
                        $query1=mysqli_query($conn,$sql1);
                        $orders=mysqli_fetch_assoc($query1);
                        $total_orders=$orders['orders'];

                        $sql1="SELECT COUNT(order_id) AS recieved FROM user_orders WHERE emp_id='".$emp_id."' AND order_status='recieved'";
                        $query1=mysqli_query($conn,$sql1);
                        $recieved=mysqli_fetch_assoc($query1);
                        $total_recieved=$recieved['recieved'];

                        $sql1="SELECT COUNT(order_id) AS canceled FROM user_orders WHERE emp_id='".$emp_id."' AND order_status='canceled'";
                        $query1=mysqli_query($conn,$sql1);
                        $canceled=mysqli_fetch_assoc($query1);
                        $total_canceled=$canceled['canceled'];

                        $sql1="SELECT COUNT(uid) AS user FROM users";
                        $query1=mysqli_query($conn,$sql1);
                        $user=mysqli_fetch_assoc($query1);
                        $total_users=$user['user'];

                        $sql1="SELECT COUNT(emp_id) AS emp FROM emp";
                        $query1=mysqli_query($conn,$sql1);
                        $emp=mysqli_fetch_assoc($query1);
                        $total_emp=$emp['emp'];

                        
                    }
                ?>

                    <!------------------------home div------------------------>

                    <div class="homediv" id="homeDiv">
                        <div class="carddiv">
                            <div class="card">
                                <h2>₹ <?php echo "$total_income"; ?></h2>
                                <p>Total income</p>
                            </div>
                            <div class="card">
                                <h2><?php echo "$total_users"; ?></h2>
                                <p>Total users</p>
                            </div>
                            <div class="card">
                                <h2><?php echo "$total_emp"; ?></h2>
                                <p>Total employee</p>
                            </div>
                            <div class="card">
                                <h2><?php echo "$total_items"; ?></h2>
                                <p>Total food item</p>
                            </div>
                            <div class="card">
                                <h2><?php echo "$total_available"; ?></h2>
                                <p>Available food item</p>
                            </div>
                            <div class="card">
                                <h2><?php echo "$total_not_available"; ?></h2>
                                <p>Not available food item</p>
                            </div>
                            <div class="card">
                                <h2 id="notifyOrder"><?php echo "$total_orders"; ?></h2>
                                <p>Total customers orders</p>
                            </div>
                            <div class="card">
                                <h2><?php echo "$total_recieved"; ?></h2>
                                <p>Total delivered orders</p>
                            </div>
                            <div class="card">
                                <h2><?php echo "$total_canceled"; ?></h2>
                                <p>Total canceled orders</p>
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

        var notifyBtn=document.getElementById("notifyBtn");
        var notifyDiv=document.getElementById("notifyDiv");

        notifyBtn.onclick=function(){
            if(notifyDiv.style.height == "97.5%"){
                notifyDiv.style.height="0px";
                notifyDiv.style.overflow="hidden";
                notifyDiv.style.padding="0px";
            }else{
                notifyDiv.style.height="97.5%";
                notifyDiv.style.overflow="auto";
                notifyDiv.style.padding="10px";
            }
            
        }


        setTimeout(function(){
            // var notifyValue=document.getElementById("notifyOrder");
            // var notifyOrder=notifyValue.innerHTML;
            
            // $.ajax({
            //     url: 'notify.php',
            //     method: 'POST',
            //     data: {notify:notifyOrder},
            //     success: function(data){
            //         console.log(notifyOrder);
            //     }
            // })
            location.reload();
        },15000);  


        var navBtnDiv=document.getElementById("navBtnDiv");
        var navBtn=document.getElementsByClassName("navBtn");

        for(var i=0;i<navBtn.length;i++){
            navBtn[i].addEventListener("click",function(){
                var active=document.getElementsByClassName("navactive");
                active[0].className=active[0].className.replace(" navactive","");
                this.className += " navactive";
            });
        }
    </script>
</body>
</html>