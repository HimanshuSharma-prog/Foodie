<?php
$to_email = "sharmahimanshu1611@gmail.com";
$subject = "Simple Email Test via PHP";
$body = "Hi, This is test email send by PHP Script";
$headers = "From: sender email";

if (mail($to_email, $subject, $body, $headers)) {
    echo "Email successfully sent to $to_email...";
} else {
    echo "Email sending failed...";
}

?>
<?php 
    include("db.php");

     ini_set('session.cookie_lifetime','2592000');

    session_start(); 
    
    
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

                        $sql="select * from userotp";
                        $query=mysqli_query($conn,$sql);

                        $row=mysqli_fetch_array($query);

                        if($email==$row['u_email']){

                            
                            if($count==1){
                                $row=mysqli_fetch_array($result);
                                $_SESSION['id']=$row['uid'];
                                $_SESSION['username']=$row['username'];
                                $_SESSION['email']=$row['email'];
                            }
                                
                            
                            $sql="UPDATE userotp SET otp='$otp' WHERE u_email='$email'";
                            $query=mysqli_query($conn,$sql);
                            
                            
                            if($query){
                                echo'<script>location.replace("/otpverify.php");</script>';
                            }
                            
        
                        }else{

                            
                            if($count==1){
                                $row=mysqli_fetch_array($result);
                                $_SESSION['id']=$row['uid'];
                                $_SESSION['username']=$row['username'];
                                $_SESSION['email']=$row['email'];
                            }
                            
                            $sql="INSERT INTO userotp(u_email,otp)VALUES('$email','$otp')";
                            $query=mysqli_query($conn,$sql);
                            
                            if($query){
                                echo'<script>location.replace("/otpverify.php");</script>';
                            }
                        }
                       
                    } else {
                        echo(" <div class='notification' id='notificationDiv'>
                            <div class='error'>
                                <p>OTP did not send check your email and network..........</p>
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
        ?>
    </div>
        <!--------------------------------------------nav------------------------------------------>
        <div class="nav" id="nav">
            <nav>
                <div class="title">
                     <a href="index.php">Foodie</a>
                </div>
                <div class="search">
                    <input type="text" placeholder="Search for a dish" id="search" name="search"><i class="fa fa-search"></i>
                </div>
                <div class="logindiv">
                    <a  id="loginbtn">Login</a> <p>|</p> <a href="signup.php">Sign Up</a>
                </div>
            </nav>
        </div>

        <!----------------------------------------------fix search bar------------------------------------------->
        <div class="fixsearch" id="fixsearch">
            <div class="search">
                <input type="text" placeholder="Search for a dish"><i class="fa fa-search"></i>
            </div>
        </div>

        <!-------------------------------------------food items--------------------------------------------------->

        <div class="smallnav">
            <ul>
                <li>
                    <img src="images/breakfast.png" alt="breakfast">
                    <span class="tooltip">
                        Breakfast
                    </span>
                </li>
                <li>
                    <img src="images/lunch.png" alt="">
                    <span class="tooltip">
                        Lunch
                    </span>
                </li>
                <li>
                    <img src="images/dinner.png" alt="">
                    <span class="tooltip">
                        Dinner
                    </span>
                </li>
                <li>
                    <img src="images/fruits.png" alt="">
                    <span class="tooltip">
                        Fruits
                    </span>
                </li>
                <li>
                    <img src="images/veg.png" alt="">
                    <span class="tooltip">
                        Veg food
                    </span>
                </li>
                <li>
                    <img src="images/non-veg.png" alt="">
                    <span class="tooltip">Non veg</span>
                </li>
                <li>
                    <img src="images/kfc-chicken.png" alt="">
                    <span class="tooltip">
                        KFC Chicken
                    </span>
                </li>
                <li>
                    <img src="images/french-fries.png" alt="">
                    <span class="tooltip">
                        French Fries
                    </span>
                </li>
                <li>
                    <img src="images/hamburger.png" alt="">
                    <span class="tooltip">
                        Hamburger
                    </span>
                </li>
                <li>
                    <img src="images/pizza.png" alt="">
                    <span class="tooltip">
                        Pizza
                    </span>
                </li>
                <li>
                    <img src="images/ice.png" alt="">
                    <span class="tooltip">
                        Ice-cream
                    </span>
                </li>
                <li>
                    <img src="images/cake.png" alt="">
                    <span class="tooltip">
                        Cake
                    </span>
                </li>
                <li>
                    <img src="images/milk.png" alt="">
                    <span class="tooltip">
                        Milk
                    </span>
                </li>
                <li>
                    <img src="images/juice.png" alt="">
                    <span class="tooltip">
                        Fresh Juice
                    </span>
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

           <a class="card" href="item.php">
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
        <a class="card" href="item.php">
            <img src="images/c1.webp" alt="" class="img">
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

        <a class="card" href="item.php">
            <img src="images/burger.jfif" alt="" class="img">
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

        <a class="card" href="item.php">
            <img src="images/rice.jpg" alt="" class="img">
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
        <a class="card" href="item.php">
            <img src="images/momo.jpg" alt="" class="img">
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

        <a class="card" href="item.php">
            <img src="images/cake.jfif" alt="" class="img">
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
            
        <a class="card" href="item.php">
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
        <a class="card" href="item.php">
            <img src="images/c1.webp" alt="" class="img">
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

        <a class="card" href="item.php">
            <img src="images/burger.jfif" alt="" class="img">
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

        <a class="card" href="item.php">
            <img src="images/rice.jpg" alt="" class="img">
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
        <a class="card" href="item.php">
            <img src="images/momo.jpg" alt="" class="img">
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

        <a class="card" href="item.php">
            <img src="images/cake.jfif" alt="" class="img">
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
                    <p>Don't have account? <a href="#">Sign Up</a></p>
                    <p><a href="#">Forgot Password?</a></p>
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
        if ('serviceWorker' in navigator) {
            navigator.serviceWorker.register('sw.js', {
                scope: '.' // <--- THIS BIT IS REQUIRED
            }).then(function(registration) {
                // Registration was successful
                console.log('ServiceWorker registration successful with scope: ', registration.scope);
            }, function(err) {
                // registration failed :(
                console.log('ServiceWorker registration failed: ', err);
            });
        }
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