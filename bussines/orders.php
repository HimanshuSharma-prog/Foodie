<?php
     ini_set('session.cookie_lifetime','2592000');

    session_start();
    include("db.php");
    if(!isset($_SESSION['e_id'])){
        header('Location:index.php');
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
   
    <link rel="stylesheet" href="css/edashboard.css?<?php echo time();?>">


    <link rel="shortcut icon" href="images/logo.png"><link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <link href='https://cdn.jsdelivr.net/npm/boxicons@2.0.5/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
</head>
<body>
    <div class="maindiv" id="maindiv">
        <div class="container">
            <div class="topnav">
                <div class="title">
                    <a href="edashboard.php">Foodie</a>
                    <p>for business</p>
                </div>
                <div class="menubtn" id="menuBtn">
                    <i class='bx bx-menu' id="openBtn"></i><i class="fa fa-times" id="closeBtn"></i>
                </div>
            </div>

            <div class="maincontainer">
            <div class="code">
                <?php
                    if(isset($_SESSION['e_id'])){
                        $id=$_SESSION['e_id'];
                        $sql="SELECT * FROM emp WHERE emp_id='".$id."'";
                        $query=mysqli_query($conn,$sql);
                        $row=mysqli_fetch_array($query);

                        $image=$row['emp_image'];
                        $emp_name=$row['emp_name'];

                        $sql="SELECT * FROM restaurant WHERE emp_id='".$id."'";
                        $query=mysqli_query($conn,$sql);
                        $row=mysqli_fetch_array($query);

                        $claimed=$row['claimed'];
                        if($claimed=='no'){
                            $err="<div class='notification' id='notificationDiv'><div class='error'><p>To access users order feature first claim your restaurant.</p></div> </div>";
                            header("Location:edashboard.php?error=$err");
                        }
                        
                    }
                ?>
            </div>

                <!------------------------------side nav------------------->

                <div class="sidenav" id="sideNav">
                    <div class="userimg">
                        <img src="empimages/<?php echo "$image";?>"">
                        <p><?php echo "$emp_name";?></p>
                    </div>
                <ul id="navBtnDiv">
                    <li><a class="navBtn" href="edashboard.php"><i class='bx bx-home-alt'></i><span>Dashboard</span><p class="option">Dashboard</p></a></li>
                    <li><a class="navBtn" href="details.php"><i class='bx bx-user'></i> <span>Your Details</span><p class="option">Your Details</p></a></li>
                    <li><a class="navBtn" href="item.php"><i class='bx bx-box' ></i> <span>Total items</span> <p class="option">Total items</p></a></li>
                    <li><a class="navBtn" href="add_item.php"><i class='bx bx-add-to-queue'></i> <span>Add items</span> <p class="option">Add items</p></a></li>
                    <li><a class="navBtn active" href="orders.php"><i class='bx bx-box'></i> <span>User orders</span> <p class="option">User orders</p></a></li>
                    <li><a class="navBtn" href="restaurant.php"><i class='bx bx-restaurant' ></i> <span>Restaurant</span> <p class="option">Restaurant</p></a></li>
                    <li><a class="navBtn" href="update_item.php"><i class='bx bxs-box' ></i> <span>Update items</span> <p class="option">Update items</p></a></li>
                    <li><a class="navBtn" href="update_details.php"><i class='bx bxs-user-detail' ></i> <span>Update Details</span> <p class="option">Update Details</p></a></li>
                    <li><a class="navBtn" href="review.php"><i class='bx bx-star' ></i> <span>All reviews</span> <p class="option">All reviews</p></a></li>
                    <li><a class="navBtn" href="changepass.php"><i class='bx bx-lock-alt' ></i> <span>Change Password</span> <p class="option">Change Password</p></a></li>
                </ul>
                <a href="logout.php" class="logoutbtn"><i class='bx bx-log-out' ></i> <span>Logout</span> <p class="option">Logout</p></a>
            </div>

            <!-------------------------content div----------------------->

            <div class="divcontainer">
                
                <!---------------------------------------user orders div------------------------->
                
                <div class="userordersdiv">
                    <div class="tablediv">
                        <table border="1">
                            <tr>
                                <th>Slno.</th>
                                <th>Order Id</th>
                                <th>Username</th>
                                <th>User Email</th>
                                <th>Food item</th>
                                <th>Payment type</th>
                                <th>Payment status</th>
                                <th>Order status</th>
                                <th>Reason</th>
                            </tr>
                            <?php
                                if(isset($_SESSION['e_id'])){
                                    $emp_id=$_SESSION['e_id'];

                                    $sql="SELECT * FROM user_orders WHERE emp_id='".$emp_id."'";
                                    $query=mysqli_query($conn,$sql);

                                    if(mysqli_num_rows($query)>0){
                                        $slno=0;
                                        while($row=mysqli_fetch_array($query)){
                                            $order_id=$row['order_id'];
                                            $user_id=$row['user_id'];
                                            $f_name=$row['f_name'];
                                            $payment_type=$row['payment_type'];
                                            $payment_status=$row['payment_status'];
                                            $order_status=$row['order_status'];
                                            $reason=$row['reason'];

                                            $sql1="SELECT * FROM users WHERE uid='".$user_id."'";
                                            $query1=mysqli_query($conn,$sql1);

                                            $row1=mysqli_fetch_array($query1);

                                            $username=$row1['username'];
                                            $email=$row1['email'];

                                            $slno++;

                                            echo"<tr>
                                            <td>$slno</td>
                                            <td>$order_id</td>
                                            <td>$username</td>
                                            <td>$email</td>
                                            <td>$f_name</td>
                                            <td>$payment_type</td>
                                            <td>$payment_status</td>
                                            <td>$order_status</td>
                                            <td>$reason</td>
                                        </tr>";
                                        }
                                    }
                                }
                            ?>
                        </table>
                    </div>
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
        
        document.getElementById("notificationDiv").onmousemove=function(){
            document.getElementById("notificationDiv").style.top="-20vh";
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