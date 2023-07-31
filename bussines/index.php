<?php
     ini_set('session.cookie_lifetime','2592000');

    session_start();
    if(!isset($_SESSION['e_id'])){
        header('Location:login.php');
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

    <link rel="shortcut icon" href="images/logo.png">
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <link href='https://cdn.jsdelivr.net/npm/boxicons@2.0.5/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
</head>
<body>
    <div class="maindiv" id="maindiv">
        <div class="code">
            <?php 
                include("db.php");
                 if(isset($_POST['r_email'])){
                    $emp_id=$_SESSION['e_id'];
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
                    
                            $sql="INSERT INTO restaurant(emp_id,r_name,r_email,r_mobile,r_image,r_address,claimed) VALUES ('$emp_id','$r_name','$r_email','$r_mobile','$final_file','$r_address','no')";
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
                if(isset($_GET['message'])){
                    $message=$_GET['message'];
                    echo "$message";
                }
            ?>
        </div>

        <!----------------nav ----------------->
        <?php
            if(isset($_SESSION['e_id'])){
                $id=$_SESSION['e_id'];
                $email=$_SESSION['e_email'];

                $sql="SELECT * FROM emp WHERE emp_id='".$id."' AND emp_email='".$email."'";
                $query=mysqli_query($conn,$sql);

                $row=mysqli_fetch_array($query);

                $image=$row['emp_image'];
            }
        ?>
            <div class="navdiv">
                <div class="nav" id="navDiv">
                    <nav>
                        <div class="title">
                            <a href="index.php">Foodie</a>
                            <p>for business</p>
                        </div>
                        <div class="btndiv">
                            <a href="edashboard.php" class="loginbtn"><img src="empimages/<?php echo "$image"; ?>"</a>
                            <p class="line">|</p>
                            <a href="logout.php" class="accbtn"><i class='bx bx-log-out'></i></a>
                        </div>
                    </nav>
                </div>
            </div>

            
            <!---------------------------------------why uou should ----------------------->

            <div class="smalldiv">
                <div class="title">
                    <h2>Partner with Foodie</h2>
                    <p>for free and get more customers!</p>
                </div>
                <div class="btndiv">
                    <a href="#regFormDiv" class="regbtn">Register your restaurant</a>
                    <a href="#SearchDiv" class="listbtn">Restaurant already listed? Claim now</a>
                </div>
                <div class="whydiv">
                    <h2>Why should you partner with Foodie?</h2>
                    <p>Foodie enables you to get 60% more revenue, 10x new customers and boost your brand visibility by providing insights to improve your businenss.</p>
                    <div class="carddiv">
                        <div class="card">
                            <img src="images/earth.png">
                            <div class="title">
                                <h2>500+ cities</h2>
                                <p>in india</p>
                            </div>
                        </div>
                        <div class="card">
                            <img src="images/restaurant.png">
                            <div class="title">
                                <h2>2 lakhs+</h2>
                                <p>restaurant listings</p>
                            </div>
                        </div>
                        <div class="card">
                            <img src="images/orders.png">
                            <div class="title">
                                <h2>3 crore+</h2>
                                <p>monthly orders</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!---------------------------------------------claim now--------------------------------------->

            <div class="smalldiv" id="SearchDiv">
                <div class="searchdiv">
                    <h1>Already have your restaurant listed?</h1>
                    <p>Search here and claim the ownership of your restaurant</p>
                    <form action="index.php" method="POST">
                        <div class="search">
                            <i class='bx bx-restaurant'></i>
                            <input type="text" name="r_search" placeholder="search your restaurant name">
                        </div>
                    </form>
                </div>

                <!----------------------------------------restaurant list ---------------------------->
                
                <div class="rlistdiv">
                    <h2>Your Search Result</h2>
                    <div class="carddiv">
                        <?php
                        include("db.php");
                            if(isset($_POST['r_search'])){
                                $search=$_POST['r_search'];
                                $sql="SELECT * FROM restaurant WHERE r_name='".$search."' AND claimed='no'";
                                $query=mysqli_query($conn,$sql);
                                $count=mysqli_num_rows($query);

                                if($count > 0){
                                    while($row=mysqli_fetch_array($query)){
                                        $r_name=$row['r_name'];
                                        $r_email=$row['r_email'];
                                        $r_id=$row['r_id'];
                                        $r_address=$row['r_address'];
                                        $r_image=$row['r_image'];

                                        echo"
                                        <div class='card'>
                                        <img src='restaurantimage/$r_image'>
                                        <div class='rnamediv'>
                                            <h3>$r_name</h3>
                                            <p>$r_email</p>
                                            <br>
                                            <p><i class='bx bxs-map' ></i> $r_address</p>
                                        </div>
                                        <div class='btndiv'>
                                            <a href='r_claim.php?r_id=$r_id' class='btn'>Claim Now</a>
                                            <a href='r_remove.php?r_id=$r_id' class='btn'>Remove</a>
                                        </div>
                                    </div>
                                        ";
                                    }
                                }else{
                                    echo("<div class='notification' id='notificationDiv'>
                                    <div class='error'>
                                        <p>No restaurant found with this name...</p>
                                    </div>
                                    </div>");
                                }
                                    
                            }
                        ?>
                        
                    </div>
                </div>
            </div>


            <!---------------------------------------------how it works div--------------------------------->

            <div class="smalldiv">
                <div class="howdiv">
                    <p>How  Foodie Works?</p>
                    <div class="carddiv">
                        <div class="card">
                            <img src="images/form.png">
                            <h2>Step 1</h2>
                            <h4>Create your page on Foodie</h4>
                            <p>Help users discover your place by creating a listing on Foodie</p>
                        </div>
                        <div class="card">
                            <img src="images/deliverytruck.png">
                            <h2>Step 2</h2>
                            <h4>Register for online ordering</h4>
                            <p>And deliver orders to millions of customers with ease</p>
                        </div>
                        <div class="card">
                            <img src="images/pack.png">
                            <h2>Step 3</h2>
                            <h4>Start receiving order online</h4>
                            <p>Manage orders on our partner app, web dashboard or API partners</p>
                        </div>
                    </div>
                </div>
            </div>

           <!-------------------------------------------register your restaurant--------------------------------------->
           
           <div class="smalldiv" id="regFormDiv">
               <div class="regformdiv">
                    <h1>Register your Restaurant</h1>   
                   <div class="formdiv">
                       <img src="images/rb1.jpg">
                       <form action="index.php" method="POST" enctype="multipart/form-data">
                           <div class="div">
                                <i class='bx bx-restaurant'></i>
                                <input type="text" name="r_name" placeholder="Restaurant name">
                           </div>
                           <div class="div">
                                <i class="fa fa-envelope-o"></i>
                                <input type="email" name="r_email" placeholder="Restaurant email">
                           </div>
                           <div class="div">
                                <i class='bx bx-phone' ></i>
                                <input type="text" name="r_mobile" maxlength="10" placeholder="Restaurant mobile no.">
                           </div>
                           <div class="img">
                                <p><i class='bx bx-image'></i> Select restaurant image</p>
                                <input type="file" name="r_image" required>
                           </div>
                           <div class="address">
                                <i class='bx bx-current-location' ></i>
                                <textarea name="r_address" id="" cols="30" rows="7" placeholder="Restaurant address"></textarea>
                           </div>
                           <input type="submit" value="Register Restaurant" class="btn">
                       </form>
                   </div>
               </div>
           </div>

           <!-------------------------------------------------------------footer---------------------------------->

        <footer>
            <div class="container">
                <div class="social">
                    <h3>Social Link</h3>
                    <a href=""><i class='bx bxl-facebook'></i> facebook</a>
                    <a href=""><i class='bx bxl-instagram' ></i> instagram</a>
                    <a href=""><i class='bx bxl-play-store' ></i> play store</a>
                    <a href=""><i class='bx bxl-apple' ></i> apple store</a>
                </div>
                <div class="title">
                     <a href="index.php">Foodie</a>
                    <p>Our Purpose is to provide best, safe, pure and hygienic food.</p>
                </div>
                <div class="useful">
                    <h3>Useful Link</h3>
                    <a href=""><i class='bx bx-user'></i> About Us</a>
                    <a href="index.php"><i class='bx bx-home-circle' ></i> Add Restaurant</a>
                    <a href=""><i class='bx bx-building-house' ></i> Business App</a>
                    <a href=""><i class='bx bx-check-shield' ></i> Return Policy</a>
                </div>
            </div>
            <div class="copyright">
                <p>Copyright &copy; 2021-<span>Foodie</span></p>
            </div>
        </footer>
    </div>   
    
    <script>
        var maindiv=document.getElementById('maindiv');
        maindiv.onscroll=()=>{
            var nav=document.getElementById('navDiv');
            var sticky=nav.offsetTop;
            if(maindiv.scrollTop > sticky){
                nav.classList.add('fixed');
            }
            else{
                nav.classList.remove('fixed');
            }
        }
       
        
        document.getElementById("notificationDiv").onmousemove=function(){
            document.getElementById("notificationDiv").style.top="-20vh";
        }
    </script>
</body>
</html>