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
    }else{
        header('Location:/index.php');
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
   
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/responsive.css">

   
    <link rel="shortcut icon" href="images/logo.png"><link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <link href='https://cdn.jsdelivr.net/npm/boxicons@2.0.5/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
</head>
<body>
    <div class="maindiv" id="maindiv">
        <div class="code">
            <?php
                if(isset($_GET['success'])){
                    $success=$_GET['success'];
                    echo "$success";
                }
                if(isset($_GET['error'])){
                    $error=$_GET['error'];
                    echo "$error";
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
                    <a href="userdashboard.php"><img src="userimage/<?php echo "$image"?>" class="userimg"></a> <p>|</p> <a href="#" class="cartbtn" id="cartBtn"><i class='bx bx-cart-alt' ></i> </a>
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

        <!-----------------------------------------------------------card div---------------------------------------------------->

        <div class="container">

            <?php
                include("usercart.php");
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
                            }elseif($final_avg==5){
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

        var cartBtn=document.getElementById("cartBtn");
        var cartContainer=document.getElementById("cartContainer");
        var cartCloseBtn=document.getElementById("cartCloseBtn");

        cartBtn.onclick=function(){
            cartContainer.style.right="0";
        }
        cartCloseBtn.onclick=function(){
            cartContainer.style.right="-500px"
        }

        document.getElementById("notificationDiv").onmousemove=function(){
            document.getElementById("notificationDiv").style.top="-20vh";
        }
    </script>
    <script src="js/main.js"></script>
</body>
</html>