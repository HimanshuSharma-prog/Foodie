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
                    
                    if(isset($_GET['message'])){
                        $message=$_GET['message'];
                        echo "$message";
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
                        <li><a class="navBtn  active" href="restaurant.php"><i class='bx bx-restaurant' ></i> <span>Restaurant</span> <p class="option">Restaurant</p></a></li>
                        <li><a class="navBtn" href="update_item.php"><i class='bx bxs-box' ></i> <span>Update items</span> <p class="option">Update items</p></a></li>
                        <li><a class="navBtn " href="review.php"><i class='bx bx-star' ></i> <span>All reviews</span> <p class="option">All reviews</p></a></li>
                        <li><a class="navBtn" href="changepass.php"><i class='bx bx-lock-alt' ></i> <span>Change Password</span> <p class="option">Change Password</p></a></li>
                        <li> <a href="logout.php" class="logoutbtn"><i class='bx bx-log-out' ></i> <span>Logout</span> <p class="option">Logout</p></a></li>
                    </ul>
                </div>

            <!-------------------------content div----------------------->

            <div class="divcontainer">
                
                <!---------------------------------------restaurant div------------------------->
                <?php
                    if(isset($_POST['r_update'])){
                        $emp_id=$_SESSION['a_id'];
                        $r_name=$_POST['r_name'];
                        $r_mobile=$_POST['r_mobile'];
                        $r_address=$_POST['r_address'];

                        $image=rand(1,1000).'-'.$_FILES['r_image']['name'];
                        $file_loc=$_FILES['r_image']['tmp_name'];
                        $file_size=$_FILES['r_image']['size'];
                        $file_type=$_FILES['r_image']['type'];
                        $new_size=$file_size/1024;
                        $folder='restaurantimage/';
                        $new_file_name=strtolower($image);
                        $final_file=str_replace(' ','-',$new_file_name);
                
                        if(move_uploaded_file($file_loc,$folder.$final_file)){
                            $sql="UPDATE restaurant SET r_name='$r_name',r_mobile='$r_mobile',r_image='$final_file',r_address='$r_address' WHERE emp_id='".$emp_id."'";
                            $query=mysqli_query($conn,$sql);

                            if($query){
                                $sql1="UPDATE fooditems SET r_address='$r_address' WHERE emp_id='".$emp_id."'";
                                $query1=mysqli_query($conn,$sql1);
                                if($query1){
                                    $success="<div class='notification' id='notificationDiv'><div class='success'><p>Restaurant details updated successfylly..</p></div> </div>";
                                    header("Location:restaurant.php?success=$success");
                                }else{
                                    $err="<div class='notification' id='notificationDiv'><div class='error'><p>Something went wrong, try after some time.</p></div> </div>";
                                    header("Location:restaurant.php?error=$err");
                                }
                            }else{
                                $err="<div class='notification' id='notificationDiv'><div class='error'><p>Something went wrong, try after some time.</p></div> </div>";
                                header("Location:restaurant.php?error=$err");
                            }
                        }
                    }
                    if(isset($_GET['success'])){
                        $success=$_GET['success'];
                        echo"$success";
                    }
                    if(isset($_GET['error'])){
                        $error=$_GET['error'];
                        echo"$error";
                    }

                    if(isset($_POST['r_add'])){
                        $emp_id=$_SESSION['a_id'];
                        $r_name=$_POST['r_name'];
                        $r_email=$_POST['r_email'];
                        $r_mobile=$_POST['r_mobile'];
                        $r_address=$_POST['r_address'];
                
                        if(is_numeric($r_mobile)){
                            $sql="SELECT * FROM restaurant WHERE r_email='$r_email'";
                            $query=mysqli_query($conn,$sql);
                            if(mysqli_num_rows($query) > 0){
                
                                $row=mysqli_fetch_assoc($query);
                
                                if($r_email==$row['r_email']){
                                    echo(" <div class='notification' id='notificationDiv'>
                                    <div class='error'>
                                        <p>The email address is already existed. Please add different email..</p>
                                    </div>
                                    </div>");
                                }
                            }else{
                
                                $image=rand(1,1000).'-'.$_FILES['r_image']['name'];
                                $file_loc=$_FILES['r_image']['tmp_name'];
                                $file_size=$_FILES['r_image']['size'];
                                $file_type=$_FILES['r_image']['type'];
                                $new_size=$file_size/1024;
                                $folder='restaurantimage/';
                                $new_file_name=strtolower($image);
                                $final_file=str_replace(' ','-',$new_file_name);
                        
                                move_uploaded_file($file_loc,$folder.$final_file);
                        
                                $sql="INSERT INTO restaurant(emp_id,r_name,r_email,r_mobile,r_image,r_address,claimed) VALUES ('$emp_id','$r_name','$r_email','$r_mobile','$final_file','$r_address','yes')";
                                $query=mysqli_query($conn,$sql);
                        
                                if($query){
                                    echo "
                                            <div class='notification' id='notificationDiv'>
                                                    <div class='success'>
                                                        <p>Restaurant registered successfully..</p>
                                                    </div>
                                            </div>";
                                }
                            }
                
                       
                        }else{
                            echo(" <div class='notification' id='notificationDiv'>
                            <div class='error'>
                            <p>Please enter only numbers for Mobile No.......</p>
                            </div>");
                        }
                    }
                    if(isset($_SESSION['a_id'])){
                        $emp_id=$_SESSION['a_id'];
                        $sql="SELECT * FROM restaurant WHERE emp_id='".$emp_id."'";
                        $query=mysqli_query($conn,$sql);

                        if(mysqli_num_rows($query)==0){
                            echo"<div class='restaurantdiv'>
                            <img src='images/r1.png'>
                            <form action='restaurant.php' method='POST' enctype='multipart/form-data'>
                                <input type='text' name='r_name' placeholder='Restaurant name'>
                                <input type='email' name='r_email' placeholder='Restaurant email'>
                                <input type='text' name='r_mobile' placeholder='Restaurant mobile no.'>
                                <div class='imgdiv'>
                                    <p>Select restaurant image</p>
                                    <input type='file' name='r_image'>
                                </div>
                                <textarea name='r_address' cols='30' rows='5' placeholder='Address'></textarea>
                                <input type='submit' value='Add restaurant' class='btn' name='r_add'>
                            </form>
                        </div>";
                        }else{
                            $sql="SELECT * FROM restaurant WHERE emp_id='".$emp_id."'";
                            $query=mysqli_query($conn,$sql);
                            $row=mysqli_fetch_array($query);
                            $r_image=$row['r_image'];
                            $r_name=$row['r_name'];
                            $r_mobile=$row['r_mobile'];
                            $r_address=$row['r_address'];
                            echo"<div class='restaurantdiv'>
                            <img src='restaurantimage/$r_image'>
                            <form action='restaurant.php' method='POST' enctype='multipart/form-data'>
                                <input type='text' name='r_name' placeholder='Restaurant name' value='$r_name'>
                                <input type='text' name='r_mobile' placeholder='Restaurant mobile no.' value='$r_mobile'>
                                <div class='imgdiv'>
                                    <p>Select restaurant image</p>
                                    <input type='file' name='r_image'>
                                </div>
                                <textarea name='r_address' cols='30' rows='5' placeholder='Address'>$r_address</textarea>
                                <input type='submit' value='Update restaurant details' class='btn' name='r_update'>
                            </form>
                        </div>";
                        }
                    }
                ?>
                
                


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