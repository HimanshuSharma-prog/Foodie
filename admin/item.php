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
                    if(isset($_GET['success'])){
                        $success=$_GET['success'];
                        echo "$success";
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
                        <li><a class="navBtn active" href="item.php"><i class='bx bx-box' ></i> <span>Total items</span> <p class="option">Total items</p></a></li>
                        <li><a class="navBtn" href="add_item.php"><i class='bx bx-add-to-queue'></i> <span>Add items</span> <p class="option">Add items</p></a></li>
                        <li><a class="navBtn" href="orders.php"><i class='bx bx-box'></i> <span>User orders</span> <p class="option">User orders</p></a></li>
                        <li><a class="navBtn" href="restaurant.php"><i class='bx bx-restaurant' ></i> <span>Restaurant</span> <p class="option">Restaurant</p></a></li>
                        <li><a class="navBtn" href="update_item.php"><i class='bx bxs-box' ></i> <span>Update items</span> <p class="option">Update items</p></a></li>
                        <li><a class="navBtn " href="review.php"><i class='bx bx-star' ></i> <span>All reviews</span> <p class="option">All reviews</p></a></li>
                        <li><a class="navBtn" href="changepass.php"><i class='bx bx-lock-alt' ></i> <span>Change Password</span> <p class="option">Change Password</p></a></li>
                        <li> <a href="logout.php" class="logoutbtn"><i class='bx bx-log-out' ></i> <span>Logout</span> <p class="option">Logout</p></a></li>
                    </ul>
                </div>

            <!-------------------------content div----------------------->

            <div class="divcontainer">
            <?Php
                    if(isset($_GET['delete_id'])){
                        $delete_id=$_GET['delete_id'];

                        $sql="DELETE FROM fooditems WHERE f_id='".$delete_id."'";
                        $query=mysqli_query($conn,$sql);

                        if($query){
                            $success="<div class='notification' id='notificationDiv'><div class='success'><p>Food item deleted successfully..</p></div> </div>";
                            header("Location:item.php?success=$success");
                        }else{
                            $err="<div class='notification' id='notificationDiv'><div class='error'><p>Something went wrong, try after some time.</p></div> </div>";
                            header("Location:item.php?error=$err");
                        }
                    }
                ?>
                
                <!---------------------------------------item div------------------------->
                
                <div class="itemdiv">
                    <div class="tablediv">
                        <div class="searchdiv">
                            <form action="">
                                <input type="text" name="search" placeholder="Search item by time">
                                <input type="submit" value="Search" class="btn">
                            </form>
                        </div>
                        <div class="table">
                            <table class="fixheader">
                                <thead>
                                    <tr>
                                        <th>Food Id</th>
                                        <th>Image</th>
                                        <th>Name</th>
                                        <th>Price</th>
                                        <th>Status</th>
                                        <th>Category</th>
                                        <th>Food time</th>
                                        <th>Food type</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                        if(isset($_POST['f_search'])){
                                            $search=$_POST['f_search'];
                                            $emp_id=$_SESSION['a_id'];
                                            $sql="SELECT * FROM fooditems WHERE f_time='".$search."' AND emp_id='".$emp_id."'";
                                            $query=mysqli_query($conn,$sql);

                                            if(mysqli_num_rows($query)>0){
                                                while($row=mysqli_fetch_array($query)){
                                                    $f_id=$row['f_id'];
                                                    $f_name=$row['f_name'];
                                                    $f_image=$row['f_img1'];
                                                    $f_price=$row['f_price'];
                                                    $f_status=$row['f_status'];
                                                    $f_cat=$row['f_cat'];
                                                    $f_time=$row['f_time'];
                                                    $f_type=$row['f_type'];

                                                    echo"<tr>
                                                        <td>$f_id</td>
                                                        <td><img src='/foodie/fooditemimages/$f_image'></td>
                                                        <td>$f_name</td>
                                                        <td>₹ $f_price for one</td>
                                                        <td>$f_status</td>
                                                        <td>$f_cat</td>
                                                        <td>$f_time</td>
                                                        <td>$f_type</td>
                                                        <td><div class='btndiv'><a href='update_item.php?update_id=$f_id' class='upbtn'>Update</a><a href='item.php?updata_id=$f_id' class='delbtn'>Delete</a> </div></td>
                                                    </tr>";
                                                }
                                            }
                                        }else{
                                            $emp_id=$_SESSION['a_id'];
                                            $sql="SELECT * FROM fooditems WHERE emp_id='".$emp_id."'";
                                            $query=mysqli_query($conn,$sql);

                                            if(mysqli_num_rows($query)>0){
                                                while($row=mysqli_fetch_array($query)){
                                                    $f_id=$row['f_id'];
                                                    $f_name=$row['f_name'];
                                                    $f_image=$row['f_img1'];
                                                    $f_price=$row['f_price'];
                                                    $f_status=$row['f_status'];
                                                    $f_cat=$row['f_cat'];
                                                    $f_time=$row['f_time'];
                                                    $f_type=$row['f_type'];

                                                    echo"<tr>
                                                        <td>$f_id</td>
                                                        <td><img src='/foodie/fooditemimages/$f_image'></td>
                                                        <td>$f_name</td>
                                                        <td>₹ $f_price for one</td>
                                                        <td>$f_status</td>
                                                        <td>$f_cat</td>
                                                        <td>$f_time</td>
                                                        <td>$f_type</td>
                                                        <td><div class='btndiv'><a href='update_item.php?update_id=$f_id' class='upbtn'>Update</a><a href='item.php?delete_id=$f_id' class='delbtn'>Delete</a> </div></td>
                                                    </tr>";
                                                }
                                            }
                                        }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="btnDiv">
                            <a href="item.php" class="btn">Show all</a>
                            <!-- <a href="#" class="btn">Previous</a>
                            <a href="#" class="btn">Next</a> -->
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