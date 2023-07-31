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
                        <img src="userimage/<?php echo"$image" ?>">
                        <p class="username"><?php echo"$uname" ?></p>
                        <!-- <div class="online">
                            <p> Online</p> 
                            <div class="circle"></div>
                        </div> -->
                    </div>
                    <ul id="navBtnDiv">
                        <li><a href="userdashboard.php" class="navBtn"><i class='bx bx-user'></i> <p>Your Details</p><p class="option">Your Details</p></a></li>
                        <li><a href="orders.php" class="navBtn"><i class='bx bx-box' ></i> <p>Your Orders</p> <p class="option">Your Orders</p></a></li>
                        <li><a href="update_details.php" class="navBtn navactive"><i class='bx bxs-user-detail' ></i> <p>Update Details</p> <p class="option">Update Details</p></a></li>
                        <li><a href="changepass.php" class="navBtn"><i class='bx bx-lock-alt' ></i> <p>Change Password</p> <p class="option">Change Password</p></a></li>
                    </ul>
                    <a href="logout.php" class="logoutbtn"><i class='bx bx-log-out' ></i> <p>Logout</p> <p class="option">Logout</p></a>
                </div>
                <div class="smalldiv" id="smallDiv">
                    <div class="code">
                        <?php
                            if(isset($_POST['f_name'])){

                                $f_name=$_POST['f_name'];
                                $l_name=$_POST['l_name'];
                                $uname=$_POST['username'];
                                $mobile=$_POST['mobile'];
                                $address=$_POST['address'];
                        
                                if(is_numeric($mobile)){
                                    $sql="SELECT * FROM users WHERE email='$email'";
                                    $query=mysqli_query($conn,$sql);
                                  
                        
                                        $image=rand(1,1000).'-'.$_FILES['uimage']['name'];
                                        $file_loc=$_FILES['uimage']['tmp_name'];
                                        $file_size=$_FILES['uimage']['size'];
                                        $file_type=$_FILES['uimage']['type'];
                                        $new_size=$file_size/1024;
                                        $folder='userimage/';
                                        $new_file_name=strtolower($image);
                                        $final_file=str_replace(' ','-',$new_file_name);
                                
                                        move_uploaded_file($file_loc,$folder.$final_file);
                                
                                        $sql="UPDATE users SET f_name='$f_name',l_name='$l_name',username='$uname',mobile='$mobile',uimage='$final_file',address='$address' WHERE uid='$id'";
                                        $query=mysqli_query($conn,$sql);
                                
                                        if($query){
                                            echo "
                                                    <div class='notification' id='notificationDiv'>
                                                            <div class='success'>
                                                                <p>Account details update successfully....</p>
                                                            </div>
                                                    </div>";

                                        }
                        
                               
                                }else{
                                    echo(" <div class='notification' id='notificationDiv'>
                                    <div class='error'>
                                    <p>Please enter only numbers for Mobile No.......</p>
                                    </div>");
                                }
                            }
                        ?>
                    </div>
                    
                    <!-----------------------------------------update details  div--------------------------------->
                     
                    <div class="updatedetailsdiv">
                        <form action="update_details.php" method="post" enctype="multipart/form-data">
                            <input type="text" name="f_name" placeholder="First name" value="<?php echo"$fname" ?>">
                            <input type="text" name="l_name" placeholder="Last name" value="<?php echo"$lname" ?>">
                            <input type="text" name="username" placeholder="Username" value="<?php echo"$uname" ?>">
                            <input type="text" name="mobile" placeholder="Mobile no" maxlength="10" value="<?php echo"$mobile" ?>">
                            <div class="img">
                                <p>Select profile image</p>
                                <div class="imgdiv">
                                    <input type="file" name="uimage">
                                    <img src="userimage/<?php echo"$image" ?>">
                                </div>
                            </div>
                            <textarea name="address"  cols="30" rows="10" placeholder="Address"><?php echo"$address" ?></textarea>
                            <input type="submit" value="Update Details" class="btn">
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