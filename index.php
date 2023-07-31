<?php 
    include("db.php");

    ini_set('session.cookie_lifetime','2592000');

    session_start(); 
    if(isset($_SESSION['id']) || isset($_COOKIE['id'])){
        header("location:loggedin.php");
    }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Foodie</title>
   
    <link rel="stylesheet" href="css/style.css?<?php echo time();?>">
    <link rel="stylesheet" href="css/responsive.css?<?php echo time();?>">
    <link rel="manifest" href="mainfest.json">


    <link rel="shortcut icon" href="images/logo.png"><link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <link href='https://cdn.jsdelivr.net/npm/boxicons@2.0.5/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
</head>
<body>
    <div class="maindiv" id="maindiv">

    <div class="code">
        <?php 
             if(isset($_POST['email'])){
                $email=$_POST['email'];
                $password=md5($_POST['password']);
        
                $sql="select * from users where email='".$email."'AND password='".$password."' limit 1";
        
                $result=mysqli_query($conn,$sql);
        
                $count=mysqli_num_rows($result); 
                
                
                if(mysqli_num_rows($result)==1){
                    $otp=rand(1111,9999);
        
                    $to_email = $_POST['email'];
                    $subject = "OTP verification";
                    $body = "Your otp for login is : ".$otp;
                    $headers = "From: foodie";

        
                    if (mail($to_email, $subject, $body, $headers)) {

                        if($count==1){
                            $row=mysqli_fetch_array($result);
                            $_SESSION['otp_email']=$row['email'];
                            $_SESSION['otp_id']=$row['uid'];
                        }

                        $user_id=$_SESSION['otp_id'];

                        $sql="SELECT * FROM userotp WHERE user_id='".$user_id."' AND u_email='".$email."' limit 1";
                        $query=mysqli_query($conn,$sql);
                        

                        if(mysqli_num_rows($query)==1){

                            $sql="UPDATE userotp SET otp='$otp' WHERE user_id='$user_id'";
                            $query=mysqli_query($conn,$sql);

                            if($query){
                                header('Location:otpverify.php');
                            }
                            
        
                        }else{
                            $sql="INSERT INTO userotp(user_id,u_email,otp)VALUES('$user_id','$email','$otp')";
                            $query=mysqli_query($conn,$sql);

                            
                            if($query){
                                header('Location:otpverify.php');
                            }
                        }
                       
                    } else {
                        echo(" <div class='notification' id='notificationDiv'>
                            <div class='error'>
                                <p>OTP did not send kindely check your email and network.....</p>
                            </div>");
                    }
        
                    
                }else{
                    echo(" <div class='notification' id='notificationDiv'>
                            <div class='error'>
                                <p>You Have Entered Incorrect email & password..</p>
                            </div>
                            </div>");
                }                     
            }
            if(isset($_GET['error'])){
                $err=$_GET['error'];
                echo(" <div class='notification' id='notificationDiv'>
                            <div class='error'>
                                <p>$err</p>
                            </div>");
            }
            if(isset($_GET['success'])){
                $success=$_GET['success'];
                echo "$success";
            }
        ?>
    </div>
        <!--------------------------------------------nav------------------------------------------>
        <div class="nav" id="nav">
            <nav>
                <div class="title">
                     <a href="index.php">Foodie</a>
                </div>
                <form action="search.php" method="POST" class="search">
                    <input type="text" placeholder="Search for a dish" id="search" name="f_search"><i class="fa fa-search"></i>
                </form>
                <div class="logindiv">
                    <a href="#" id="loginbtn">Login</a> <p>|</p> <a href="signup.php">Sign Up</a>
                </div>
            </nav>
        </div>

        <!----------------------------------------------fix search bar------------------------------------------->
        <div class="fixsearch" id="fixsearch">
            <form action="search.php" method="POST" class="search">
                <input type="text" placeholder="Search for a dish" id="search" name="f_search"><i class="fa fa-search"></i>
            </form>
        </div>

        <!-------------------------------------------food items--------------------------------------------------->

        <div class="smallnav">
            <ul>
                <li><a href="search.php?time=Breakfast">
                    <img src="images/breakfast.png" alt="breakfast">
                    <span class="tooltip">
                        Breakfast
                    </span>
                </a>
                </li>
                <li><a href="search.php?time=Lunch">
                    <img src="images/lunch.png">
                    <span class="tooltip">
                        Lunch
                    </span>
                </a>
                </li>
                <li><a href="search.php?time=Dinner">
                    <img src="images/dinner.png">
                    <span class="tooltip">
                        Dinner
                    </span>
                </a>
                </li>
                <li><a href="search.php?type=fast food">
                    <img src="images/fast-food (2).png">
                    <span class="tooltip">
                        Fast food
                    </span>
                </a>
                </li>
                <li>
                    <a href="search.php?type=Veg food">
                        <img src="images/veg.png">
                        <span class="tooltip">
                            Veg food
                        </span>
                    </a>
                </li>
                <li><a href="search.php?type=Non veg">
                    <img src="images/non-veg.png">
                    <span class="tooltip">Non veg</span>
                </a>
                </li>
                <li><a href="search.php?cat=KFC chicken">
                <img src="images/kfc-chicken.png">
                    <span class="tooltip">
                        KFC Chicken
                    </span>
                </a>
                </li>
                <li><a href="search.php?cat=French fries">
                <img src="images/french-fries.png">
                    <span class="tooltip">
                        French Fries
                    </span>
                </a>
                </li>
                <li><a href="search.php?cat=Hambruger">
                <img src="images/hamburger.png">
                    <span class="tooltip">
                        Hamburger
                    </span>
                </a>
                </li>
                <li><a href="search.php?cat=Pizza">
                <img src="images/pizza.png">
                    <span class="tooltip">
                        Pizza
                    </span>
                </a>
                </li>
                <li><a href="search.php?cat=Ice-cream">
                <img src="images/ice.png">
                    <span class="tooltip">
                        Ice-cream
                    </span>
                </a>
                </li>
                <li><a href="search.php?cat=Cake">
                <img src="images/cake.png">
                    <span class="tooltip">
                        Cake
                    </span>
                </a>
                </li>
                <li><a href="search.php?cat=Omelet">
                <img src="images/omelet.png">
                    <span class="tooltip">
                        Omelet
                    </span>
                </a>  
                </li>
                <li><a href="search.php?cat=Juice">
                <img src="images/juice.png">
                    <span class="tooltip">
                        Fresh Juice
                    </span>
                </a> 
                </li>
            </ul>
        </div>
        
        <!-- ---------------------------------------------------------sorting nav-----------------------------------------------

        <div class="sortnav">
            <p class="location">Delivery at Cmp Center & School</p>
            <form action="">
                <select name="" id="">
                    <optgroup label="Select a Sort type">
                        <option value="pureVeg">Pure-Veg</option>
                        <option value="200">Less than 200</option>
                        <option value="500">Less than 500</option>
                        <option value="offer">Great Offer</option>
                    </optgroup>
                </select>
                <input type="submit" value="Search" class="btn">
            </form>
            
        </div> -->

        <!-----------------------------------------------------------card div---------------------------------------------------->

        <div class="container">
           <!--card-->
           <?php
                $sql="SELECT * FROM fooditems WHERE f_status='Available' ORDER BY f_id DESC";
                $query=mysqli_query($conn,$sql);
                if(mysqli_num_rows($query)>0){
                    while($row=mysqli_fetch_array($query)){
                        $name=$row['f_name'];
                        $price=$row['f_price'];
                        $image=$row['f_img1'];
                        $address=$row['r_address'];
                        $f_id=$row['f_id'];

                        echo "<a class='card' href='item.php?f_id=$f_id'>
                        <img src='fooditemimages/$image' alt='' class='img'>
                        <div class='blurdiv'>
                            <div class='name'>
                                <p>$name</p>
                            </div>
                            <div class='pricediv'>
                                <div class='price'>
                                    <i class='fa fa-inr'></i> $price for one
                                </div>";
                            
                                $sql1="SELECT * FROM user_review WHERE f_id='".$f_id."'";
                                $query1=mysqli_query($conn,$sql1);
                                if(mysqli_num_rows($query1)>0){
                                    $rating_sum=0;
                                    while($row1=mysqli_fetch_array($query1)){
                                        $rating=$row1['rating'];
                                        $rating_array=array($rating);
                                        $array_sum=array_sum($rating_array);
                                        $rating_sum+=$array_sum;
                                    }
                                    $sql2="SELECT COUNT(id) AS total FROM user_review WHERE f_id='".$f_id."'";
                                    $query2=mysqli_query($conn,$sql2);
                                    $t_review=mysqli_fetch_assoc($query2);
                                    $sum_review=$t_review['total'];
        
                                    $final_avg=$rating_sum/$sum_review;
                                    $final_avg=round($final_avg,1,PHP_ROUND_HALF_UP);
        
                                    if($final_avg==1){
                                        echo"<div class='rating'>
                                        <i class='fa fa-star'></i>
                                        <i class='fa fa-star-o'></i>
                                        <i class='fa fa-star-o'></i>
                                        <i class='fa fa-star-o'></i>
                                        <i class='fa fa-star-o'></i> $final_avg
                                    </div>";
                                    }elseif($final_avg<=1.5){
                                        echo"<div class='rating'>
                                        <i class='fa fa-star'></i>
                                        <i class='fa fa-star-half-o'></i>
                                        <i class='fa fa-star-o'></i>
                                        <i class='fa fa-star-o'></i>
                                        <i class='fa fa-star-o'></i> $final_avg
                                    </div>";
                                    }elseif($final_avg==2){
                                        echo"<div class='rating'>
                                        <i class='fa fa-star'></i>
                                        <i class='fa fa-star'></i>
                                        <i class='fa fa-star-o'></i>
                                        <i class='fa fa-star-o'></i>
                                        <i class='fa fa-star-o'></i> $final_avg
                                    </div>";
                                    }elseif($final_avg<=2.5){
                                        echo"<div class='rating'>
                                        <i class='fa fa-star'></i>
                                        <i class='fa fa-star'></i>
                                        <i class='fa fa-star-half-o'></i>
                                        <i class='fa fa-star-o'></i>
                                        <i class='fa fa-star-o'></i> $final_avg
                                    </div>";
                                    }elseif($final_avg==3){
                                        echo"<div class='rating'>
                                        <i class='fa fa-star'></i>
                                        <i class='fa fa-star'></i>
                                        <i class='fa fa-star'></i>
                                        <i class='fa fa-star-o'></i>
                                        <i class='fa fa-star-o'></i> $final_avg
                                    </div>";
                                    }elseif($final_avg<=3.5){
                                        echo"<div class='rating'>
                                        <i class='fa fa-star'></i>
                                        <i class='fa fa-star'></i>
                                        <i class='fa fa-star'></i>
                                        <i class='fa fa-star-half-o'></i>
                                        <i class='fa fa-star-o'></i> $final_avg
                                    </div>";
                                    }elseif($final_avg==4){
                                        echo"<div class='rating'>
                                        <i class='fa fa-star'></i>
                                        <i class='fa fa-star'></i>
                                        <i class='fa fa-star'></i>
                                        <i class='fa fa-star'></i>
                                        <i class='fa fa-star-o'></i> $final_avg
                                    </div>";
                                    }elseif($final_avg>=4.5){
                                        echo"<div class='rating'>
                                        <i class='fa fa-star'></i>
                                        <i class='fa fa-star></i>
                                        <i class='fa fa-star'></i>
                                        <i class='fa fa-star'></i>
                                        <i class='fa fa-star-half-o'></i> $final_avg
                                    </div>";
                                    }else{
                                        echo"<div class='rating'>
                                        <i class='fa fa-star'></i>
                                        <i class='fa fa-star'></i>
                                        <i class='fa fa-star'></i>
                                        <i class='fa fa-star'></i>
                                        <i class='fa fa-star'></i> $final_avg
                                    </div>";
                                    }
                                }else{
                                    echo"<div class='rating'>
                                    <i class='fa fa-star-o'></i>
                                    <i class='fa fa-star-o'></i>
                                    <i class='fa fa-star-o'></i>
                                    <i class='fa fa-star-o'></i>
                                    <i class='fa fa-star-o'></i> 0
                                    </div>";
                                }
                                
                            echo"</div>
                            <div class='locdiv'>
                                <i class='bx bxs-map' ></i><p>$address</p>
                            </div>
                        </div>
                        
                    </a>";
                    }
                }
           ?>

           <!-- <a class="card" href="item.php">
            <img src="images/p4.jpg" alt="" class="img">
            <div class="blurdiv">
                <div class="name">
                    <p>test card</p>
                </div>
                <div class="pricediv">
                    <div class="price">
                        <i class="fa fa-inr"></i> 120 for one
                    </div>
                    <div class="rating">
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star-half-o"></i> 4.5
                    </div>
                </div>
                <div class="locdiv">
                    <i class='bx bxs-map' ></i><p>shop Address</p>
                </div>
            </div>
            
        </a>
        -->

        </div>   
        <!----------------------------------------------------------login form------------------------->

        <div class="formcontainer" id="loginform">
            <div class="formdiv">
                <div class="title">
                    <h1>User Login</h1>
                    <i class="fa fa-times-circle" id="closebtn"></i>
                </div>
                <form action="index.php" method="POST">
                    <div class="username">
                        <i class="fa fa-envelope-o"></i>
                        <input type="email" name="email" placeholder="User Email" required>
                    </div>
                    <div class="password">
                        <i class='bx bx-lock' ></i>
                        <input type="password" name="password" id="passInput" placeholder="Password" required>
                        <i class='bx bx-show' id="showPass"></i><i class='bx bx-hide' id="hidePass"></i>
                    </div>
                    <input type="submit" value="Login" class="loginbtn">
                    <p>Don't have account? <a href="signup.php">Sign Up</a></p>
                    <p><a href="forgotpassword.php">Forgot Password?</a></p>
                </form>
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
                    <a href="bussines/index.php"><i class='bx bx-home-circle' ></i> Add Restaurant</a>
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
        // if ('serviceWorker' in navigator) {
        //     navigator.serviceWorker.register('sw.js', {
        //         scope: '.' // <--- THIS BIT IS REQUIRED
        //     }).then(function(registration) {
        //         // Registration was successful
        //         console.log('ServiceWorker registration successful with scope: ', registration.scope);
        //     }, function(err) {
        //         // registration failed :(
        //         console.log('ServiceWorker registration failed: ', err);
        //     });
        // }
       </script>

    <script>
        if(screen.width > 900){
            var maindiv=document.getElementById('maindiv');
            maindiv.onscroll=()=>{
                var nav=document.getElementById('nav');
                var sticky=nav.offsetTop;
                if(maindiv.scrollTop > sticky){
                    nav.classList.add('fixed');
                }
                else{
                    nav.classList.remove('fixed');
                }
            }
        }

        if(screen.width < 900){
            var maindiv=document.getElementById('maindiv');
            maindiv.onscroll=()=>{
                var fixsearch=document.getElementById('fixsearch');
                var sticky=fixsearch.offsetTop;
                if(maindiv.scrollTop > sticky){
                    fixsearch.classList.add('fixed');
                }
                else{
                    fixsearch.classList.remove('fixed');
                }
            }
        }
        document.getElementById("showPass").onclick=function(){
            document.getElementById("passInput").type="text";
            document.getElementById("hidePass").style.display="block";
            document.getElementById("showPass").style.display="none";
        }
        document.getElementById("hidePass").onclick=function(){
            document.getElementById("passInput").type="password";
            document.getElementById("showPass").style.display="block";
            document.getElementById("hidePass").style.display="none";
        }
        document.getElementById("loginbtn").onclick=function(){
            document.getElementById("loginform").style.top="1vh";
        }
        document.getElementById("closebtn").onclick=function(){
            document.getElementById("loginform").style.top="-110%";
        }
        document.getElementById("notificationDiv").onmousemove=function(){
            document.getElementById("notificationDiv").style.top="-20vh";
        }
    </script>
</body>
</html>