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
                        <li><a href="emp.php" class="active"><i class='bx bxs-user' ></i> <span>Employee</span><p class="option">Employee</p></a></li>
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

                    <!------------------------total users div------------------------>

                    <div class="empdiv">
                        <div class="tablediv">
                            <table border="1">
                                <tr>
                                    <th>Slno.</th>
                                    <th>First name</th>
                                    <th>Last name</th>
                                    <th>Employee name</th>
                                    <th>Email</th>
                                    <th>Mobile no.</th>
                                    <th>Restaurant name</th>
                                    <th>Restaurant email</th>
                                    <th>Restaurant No.</th>
                                    <th>Restaurant address</th>
                                </tr>
                                <?php
                                    $sql="SELECT * FROM emp";
                                    $query=mysqli_query($conn,$sql);
                                    if(mysqli_num_rows($query)>0){
                                        $slno=0;
                                        while($row=mysqli_fetch_array($query)){
                                            $emp_id=$row['emp_id'];
                                            $f_name=$row['f_name'];
                                            $l_name=$row['l_name'];
                                            $uname=$row['emp_name'];
                                            $email=$row['emp_email'];
                                            $mobile=$row['emp_mobile'];
                                            $slno++;

                                            $sql1="SELECT * FROM restaurant WHERE emp_id='".$emp_id."'";
                                            $query1=mysqli_query($conn,$sql1);

                                            $row1=mysqli_fetch_array($query1);

                                            $r_name=$row1['r_name'];
                                            $r_email=$row1['r_email'];
                                            $r_mobile=$row1['r_mobile'];
                                            $r_address=$row1['r_address'];

                                            echo"<tr>
                                            <td>$slno</td>
                                            <td>$f_name</td>
                                            <td>$l_name</td>
                                            <td>$uname</td>
                                            <td>$email</td>
                                            <td>$mobile</td>
                                            <td>$r_name</td>
                                            <td>$r_email</td>
                                            <td>$r_mobile</td>
                                            <td>$r_address</td>
                                        </tr>";
                                        }
                                    }
                                ?>
                                <!-- <tr>
                                    <td>1</td>
                                    <td>Himanshu</td>
                                    <td>Sharma</td>
                                    <td>himanshu</td>
                                    <td>sharmahimanshu1611@gmail.com</td>
                                    <td>7056652515</td>
                                    <td>Shri balaji</td>
                                    <td>shribalaji@gmail.com</td>
                                    <td>6361720268</td>
                                    <td>cmp centre and school, neelasandra. bangalore, karnataka, 560025</td>
                                </tr>
                                    <td>1</td>
                                    <td>Himanshu</td>
                                    <td>Sharma</td>
                                    <td>himanshu</td>
                                    <td>sharmahimanshu1611@gmail.com</td>
                                    <td>7056652515</td>
                                    <td>Shri balaji</td>
                                    <td>shribalaji@gmail.com</td>
                                    <td>6361720268</td>
                                    <td>cmp centre and school, neelasandra. bangalore, karnataka, 560025</td>
                                </tr>
                                    <td>1</td>
                                    <td>Himanshu</td>
                                    <td>Sharma</td>
                                    <td>himanshu</td>
                                    <td>sharmahimanshu1611@gmail.com</td>
                                    <td>7056652515</td>
                                    <td>Shri balaji</td>
                                    <td>shribalaji@gmail.com</td>
                                    <td>6361720268</td>
                                    <td>cmp centre and school, neelasandra. bangalore, karnataka, 560025</td>
                                </tr>
                                    <td>1</td>
                                    <td>Himanshu</td>
                                    <td>Sharma</td>
                                    <td>himanshu</td>
                                    <td>sharmahimanshu1611@gmail.com</td>
                                    <td>7056652515</td>
                                    <td>Shri balaji</td>
                                    <td>shribalaji@gmail.com</td>
                                    <td>6361720268</td>
                                    <td>cmp centre and school, neelasandra. bangalore, karnataka, 560025</td>
                                </tr>
                                    <td>1</td>
                                    <td>Himanshu</td>
                                    <td>Sharma</td>
                                    <td>himanshu</td>
                                    <td>sharmahimanshu1611@gmail.com</td>
                                    <td>7056652515</td>
                                    <td>Shri balaji</td>
                                    <td>shribalaji@gmail.com</td>
                                    <td>6361720268</td>
                                    <td>cmp centre and school, neelasandra. bangalore, karnataka, 560025</td>
                                </tr>
                                    <td>1</td>
                                    <td>Himanshu</td>
                                    <td>Sharma</td>
                                    <td>himanshu</td>
                                    <td>sharmahimanshu1611@gmail.com</td>
                                    <td>7056652515</td>
                                    <td>Shri balaji</td>
                                    <td>shribalaji@gmail.com</td>
                                    <td>6361720268</td>
                                    <td>cmp centre and school, neelasandra. bangalore, karnataka, 560025</td>
                                </tr>
                                    <td>1</td>
                                    <td>Himanshu</td>
                                    <td>Sharma</td>
                                    <td>himanshu</td>
                                    <td>sharmahimanshu1611@gmail.com</td>
                                    <td>7056652515</td>
                                    <td>Shri balaji</td>
                                    <td>shribalaji@gmail.com</td>
                                    <td>6361720268</td>
                                    <td>cmp centre and school, neelasandra. bangalore, karnataka, 560025</td>
                                </tr>
                                    <td>1</td>
                                    <td>Himanshu</td>
                                    <td>Sharma</td>
                                    <td>himanshu</td>
                                    <td>sharmahimanshu1611@gmail.com</td>
                                    <td>7056652515</td>
                                    <td>Shri balaji</td>
                                    <td>shribalaji@gmail.com</td>
                                    <td>6361720268</td>
                                    <td>cmp centre and school, neelasandra. bangalore, karnataka, 560025</td>
                                </tr>
                                    <td>1</td>
                                    <td>Himanshu</td>
                                    <td>Sharma</td>
                                    <td>himanshu</td>
                                    <td>sharmahimanshu1611@gmail.com</td>
                                    <td>7056652515</td>
                                    <td>Shri balaji</td>
                                    <td>shribalaji@gmail.com</td>
                                    <td>6361720268</td>
                                    <td>cmp centre and school, neelasandra. bangalore, karnataka, 560025</td>
                                </tr>
                                    <td>1</td>
                                    <td>Himanshu</td>
                                    <td>Sharma</td>
                                    <td>himanshu</td>
                                    <td>sharmahimanshu1611@gmail.com</td>
                                    <td>7056652515</td>
                                    <td>Shri balaji</td>
                                    <td>shribalaji@gmail.com</td>
                                    <td>6361720268</td>
                                    <td>cmp centre and school, neelasandra. bangalore, karnataka, 560025</td>
                                </tr>
                                    <td>1</td>
                                    <td>Himanshu</td>
                                    <td>Sharma</td>
                                    <td>himanshu</td>
                                    <td>sharmahimanshu1611@gmail.com</td>
                                    <td>7056652515</td>
                                    <td>Shri balaji</td>
                                    <td>shribalaji@gmail.com</td>
                                    <td>6361720268</td>
                                    <td>cmp centre and school, neelasandra. bangalore, karnataka, 560025</td>
                                </tr>
                                    <td>1</td>
                                    <td>Himanshu</td>
                                    <td>Sharma</td>
                                    <td>himanshu</td>
                                    <td>sharmahimanshu1611@gmail.com</td>
                                    <td>7056652515</td>
                                    <td>Shri balaji</td>
                                    <td>shribalaji@gmail.com</td>
                                    <td>6361720268</td>
                                    <td>cmp centre and school, neelasandra. bangalore, karnataka, 560025</td>
                                </tr>
                                    <td>1</td>
                                    <td>Himanshu</td>
                                    <td>Sharma</td>
                                    <td>himanshu</td>
                                    <td>sharmahimanshu1611@gmail.com</td>
                                    <td>7056652515</td>
                                    <td>Shri balaji</td>
                                    <td>shribalaji@gmail.com</td>
                                    <td>6361720268</td>
                                    <td>cmp centre and school, neelasandra. bangalore, karnataka, 560025</td>
                                </tr> -->
                                
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
    </script>
</body>
</html>