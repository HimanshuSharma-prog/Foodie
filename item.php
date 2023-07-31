<?php
     ini_set('session.cookie_lifetime','2592000');

    session_start();
    include("db.php");
    if(!isset($_SESSION['id'])){
        header("location:index.php?error=First login to check food items details");
    }
    if(isset($_SESSION['email'])){
        $email=$_SESSION['email'];
        $id=$_SESSION['id'];
        $sql="SELECT * FROM users WHERE email='$email' AND uid='$id'";
        $query=mysqli_query($conn,$sql);

        $row=mysqli_fetch_array($query);

        $image=$row['uimage'];
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
   


    <link rel="shortcut icon" href="images/logo.png"><link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <link href='https://cdn.jsdelivr.net/npm/boxicons@2.0.5/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
</head>
<body>
    <div class="maindiv" id="maindiv">
        <div class="message" id="messageDiv">

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
        <div class="code">
            <?php
                include("usercart.php");
                if(isset($_GET['f_id'])){
                    $f_id=$_GET['f_id'];
                    $sql="SELECT * FROM fooditems WHERE f_id='".$f_id."'";
                    $query=mysqli_query($conn,$sql);
                    $row=mysqli_fetch_array($query);

                    $f_name=$row['f_name'];
                    $f_price=$row['f_price'];
                    $r_address=$row['r_address'];
                    $f_img1=$row['f_img1'];
                    $f_img2=$row['f_img2'];
                    $f_img3=$row['f_img3'];
                    $f_img4=$row['f_img4'];
                    $f_time=$row['f_time'];
                }
                if(isset($_GET['success'])){
                    $success=$_GET['success'];
                    echo "$success";
                }
                if(isset($_GET['error'])){
                    $error=$_GET['error'];
                    echo"$error";
                }
                
            ?>
        </div>
        
        <!-- --------------------------------------------------review div------------------------------------------ -->

        <div class="reviewcontainer" id="reviewDiv">
            <div class="formdiv">
                <div class="title">
                   <p>Add Review</p>
                   <div class="closebtn">
                    <i class="fa fa-times-circle" id="closebtn"></i>
                   </div>
                </div>
                <form action="review.php" method="POST" enctype="multipart/form-data">
                    <div class="ratingdiv">
                        <div class="rating">
                            <i class="fa fa-star" id="starOne"></i>
                            <i class="fa fa-star" id="starTwo"></i>
                            <i class="fa fa-star" id="starThree"></i>
                            <i class="fa fa-star" id="starFour"></i>
                            <i class="fa fa-star" id="starFive"></i>
                        </div>
                        <input type="range" name="rating" id="ratingInput" min="0" max="5" value="0" required>
                       
                    </div>
                    <div class="reviewdiv">
                        <textarea name="review" cols="30" rows="5" placeholder="Write your review..." required></textarea>
                    </div>
                    <div class="imgdiv">
                        <input type="file" name="reviewimg" required>
                    </div>
                    <div class="hidden">
                        <input type="text" name="f_id" value="<?php echo "$f_id" ?>" style="display: none;">
                    </div>
                    <div class="btndiv">
                        <input type="reset" value="Clear">
                        <input type="submit" value="Add Review">
                    </div>
                </form>
            </div>
        </div>


        
       <!------------------------------------------------------------product div------------------------------------->
        <div class="productcontainer">
            <div class="productImg">
                <div class="bigImg">
                    <img src="fooditemimages/<?php echo "$f_img1" ?>" id="resultImg">
                </div>
                <div class="smallImg">
                    <img src="fooditemimages/<?php echo "$f_img1" ?>" class="img">
                    <img src="fooditemimages/<?php echo "$f_img2" ?>" class="img">
                    <img src="fooditemimages/<?php echo "$f_img3" ?>" class="img">
                    <img src="fooditemimages/<?php echo "$f_img4" ?>" class="img">
                </div>
            </div>
            <div class="productdetails">
                <div class="title">
                    <p><?php echo "$f_name" ?></p>

                    <?php
                        $sql="SELECT * FROM user_review WHERE f_id='".$f_id."'";
                        $query=mysqli_query($conn,$sql);
                        if(mysqli_num_rows($query)>0){
                            $rating_sum=0;
                            while($row=mysqli_fetch_array($query)){
                                $rating=$row['rating'];
                                $rating_array=array($rating);
                                $array_sum=array_sum($rating_array);
                                $rating_sum+=$array_sum;
                            }
                            $sql1="SELECT COUNT(id) AS total FROM user_review WHERE f_id='".$f_id."'";
                            $query1=mysqli_query($conn,$sql1);
                            $t_review=mysqli_fetch_assoc($query1);
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
                        
                    ?>
                    
                </div>
                <div class="locdiv">
                    <i class='bx bxs-map' ></i><p><?php echo "$r_address" ?></p>
                </div>
                <div class="price">
                    <i class="fa fa-inr"></i> <?php echo "$f_price" ?> for one
                </div>
            </div>
            <div class="btndiv">
                <a href="#" class="btn" id="reviewDivBtn"><i class="fa fa-star-o"></i> Add Review</a>
                <a href="https://www.google.com/maps/search/<?php echo "$r_address" ?>" class="btn"  target="_blank"><i class='bx bxs-direction-right' ></i> Direction</a>
                <a href="cart.php?f_id=<?php echo "$f_id" ?>" class="btn"><i class='bx bx-cart-alt' ></i> Add Cart</a>
                <a href="https://api.whatsapp.com/send?text=<?php echo "https://" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI']; ?>" data-action="share/whatsapp/share" class="btn"  target="_blank"><i class='bx bx-share bx-flip-horizontal' ></i> Share</a>
            </div>
        </div>

        <!--------------------------------------------------------------other products------------------------>

        <div class="itemcontainer">
            <div class="itemnav">
                <a href="#" class="navtitle active" id="navTitle1">Same Item</a>
                <a href="#" class="navtitle" id="navTitle2">Reviews</a>
                <a href="#" class="navtitle" id="navTitle3">Photos</a>
            </div>
            <div class="sliderbar">
                <div class="slider" id="slider"></div>
            </div>
            <div class="smallcontainer">
                <div class="cardcontainer" id="cardContainer">
                    <?php
                        $sql="SELECT * FROM fooditems WHERE f_time='".$f_time."'";
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
                                   echo" </div>
                                    <div class='locdiv'>
                                        <i class='bx bxs-map' ></i><p>$address</p>
                                    </div>
                                </div>
                                
                            </a>";
                            }
                        }
                    ?>

                    <!---------------------------------card ----------------->

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
                        
                    </a>-->
                </div>

                <!-----------------------------review div------------------->

                <div class="reviewsdiv" id="reviewsDiv">
                    <?php
                        if(isset($_GET['f_id'])){
                            $f_id=$_GET['f_id'];
                            $sql="SELECT * FROM user_review WHERE f_id='".$f_id."'";
                            $query=mysqli_query($conn,$sql);

                            if(mysqli_num_rows($query)>0){
                                while($row=mysqli_fetch_array($query)){
                                    $user_id=$row['user_id'];
                                    $rating=$row['rating'];
                                    $review=$row['review'];
                                    $review_image=$row['review_image'];
                                    $emp_reply=$row['emp_reply'];

                                    $sql1="SELECT * FROM users WHERE uid='".$user_id."'";
                                    $query1=mysqli_query($conn,$sql1);

                                    $row1=mysqli_fetch_array($query1);

                                    $uname=$row1['username'];
                                    $image=$row1['uimage'];

                                    echo"<div class='reviewbox'>
                                    <div class='username'>
                                       <img src='userimage/$image'> <p>$uname</p>
                                    </div>";

                                    if($rating==1){
                                        echo"<div class='rating'>
                                        <i class='fa fa-star'></i>
                                        <i class='fa fa-star-o'></i>
                                        <i class='fa fa-star-o'></i>
                                        <i class='fa fa-star-o'></i>
                                        <i class='fa fa-star-o'></i> 1
                                    </div>";
                                    }elseif($rating==2){
                                        echo"<div class='rating'>
                                        <i class='fa fa-star'></i>
                                        <i class='fa fa-star'></i>
                                        <i class='fa fa-star-o'></i>
                                        <i class='fa fa-star-o'></i>
                                        <i class='fa fa-star-o'></i> 2
                                    </div>";
                                    }elseif($rating==3){
                                        echo"<div class='rating'>
                                        <i class='fa fa-star'></i>
                                        <i class='fa fa-star'></i>
                                        <i class='fa fa-star'></i>
                                        <i class='fa fa-star-o'></i>
                                        <i class='fa fa-star-o'></i> 3
                                    </div>";
                                    }elseif($rating==4){
                                        echo"<div class='rating'>
                                        <i class='fa fa-star'></i>
                                        <i class='fa fa-star'></i>
                                        <i class='fa fa-star'></i>
                                        <i class='fa fa-star'></i>
                                        <i class='fa fa-star-o'></i> 4
                                    </div>";
                                    }else{
                                        echo"<div class='rating'>
                                        <i class='fa fa-star'></i>
                                        <i class='fa fa-star'></i>
                                        <i class='fa fa-star'></i>
                                        <i class='fa fa-star'></i>
                                        <i class='fa fa-star'></i> 5
                                    </div>";
                                    }
                                    
                                    echo"<div class='feedback'>
                                            <p>$review</p>
                                        </div>
                                        <div class='reviewimg'>
                                            <img src='reviewimages/$review_image'>
                                        </div>";
                                    if($emp_reply == ''){
                                        echo"</div>";
                                    }else{
                                        echo" <div class='replydiv'>
                                                <h3>Owner reply</h3>
                                                <p>$emp_reply</p>
                                            </div>
                                        </div>";
                                    }
                                    
                                }
                            }
                        }
                    ?>

                    
                        
                    <!-- <!-- <div class="reviewbox">
                        <div class="username">
                           <img src="images/profileimg.jpg" alt=""> <p>Himanshu</p>
                        </div>
                        <div class="rating">
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star-half-o"></i> 4.5
                        </div>
                        <div class="feedback">
                            <p>they are making fool of customers only. sending cold soggy old batch of fries and the burger is good for nothing. no lettuce nothing in it in crispy chicken burger. standard and quality has become so low.</p>
                        </div>
                        <div class="reviewimg">
                            <img src="images/pizza.jpeg">
                        </div>
                    </div> -->
                    <!-- <div class="reviewbox">
                        <div class="username">
                           <img src="images/profileimg.jpg" alt=""> <p>Himanshu</p>
                        </div>
                        <div class="rating">
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star-half-o"></i> 4.5
                        </div>
                        <div class="feedback">
                            <p>they are making fool of customers only. sending cold soggy old batch of fries and the burger is good for nothing. no lettuce nothing in it in crispy chicken burger. standard and quality has become so low.</p>
                        </div>
                        <div class="reviewimg">
                            <img src="images/pizza.jpeg">
                        </div>
                        <div class="replydiv">
                            <h3>Owner reply</h3>
                            <p>they are making fool of customers only. sending cold soggy old batch of fries and the burger is good for nothing. no lettuce nothing in it in crispy chicken burger. standard and quality has become so low.</p>
                        </div>
                    </div>  -->
                </div>

                <!----------------------------------item photo-------------------->

                <div class="photodiv" id="photoDiv">
                    <img src="fooditemimages/<?php echo "$f_img1" ?>" class="img">
                    <img src="fooditemimages/<?php echo "$f_img2" ?>" class="img">
                    <img src="fooditemimages/<?php echo "$f_img3" ?>" class="img">
                    <img src="fooditemimages/<?php echo "$f_img4" ?>" class="img">
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

        var navTitle1=document.getElementById("navTitle1");
        var navTitle2=document.getElementById("navTitle2");
        var navTitle3=document.getElementById("navTitle3");
        var slider=document.getElementById("slider")
        var cardContainer=document.getElementById("cardContainer");
        var reviewsDiv=document.getElementById("reviewsDiv");
        var photoDiv=document.getElementById("photoDiv");

        navTitle1.onclick=function(){
            slider.style.marginLeft="0px"
            navTitle1.classList.add("active");
            navTitle2.classList.remove("active");
            navTitle3.classList.remove("active");
            cardContainer.style.display="flex";
            reviewsDiv.style.display="none";
            photoDiv.style.display="none";
        }

        navTitle2.onclick=function(){
            slider.style.marginLeft="120px"
            navTitle2.classList.add("active");
            navTitle1.classList.remove("active");
            navTitle3.classList.remove("active");
            cardContainer.style.display="none";
            reviewsDiv.style.display="flex";
            photoDiv.style.display="none";
        }

        navTitle3.onclick=function(){
            slider.style.marginLeft="240px"
            navTitle3.classList.add("active");
            navTitle2.classList.remove("active");
            navTitle1.classList.remove("active");
            cardContainer.style.display="none";
            reviewsDiv.style.display="none";
            photoDiv.style.display="flex";
        }
        

        var img=document.getElementById("resultImg");
        var smallimg=document.getElementsByClassName("img");
        smallimg[0].onmouseover=function(){
            img.src=smallimg[0].src;
        }
        smallimg[1].onmouseover=function(){
            img.src=smallimg[1].src;
        }
        smallimg[2].onmouseover=function(){
            img.src=smallimg[2].src;
        }
        smallimg[3].onmouseover=function(){
            img.src=smallimg[3].src;
        }

        document.getElementById("reviewDivBtn").onclick=function(){
            document.getElementById("reviewDiv").style.top="1vh";
        }
        document.getElementById("closebtn").onclick=function(){
            document.getElementById("reviewDiv").style.top="-110%";
        }

        var ratingInput=document.getElementById("ratingInput");
        var starOne=document.getElementById("starOne");
        var starTwo=document.getElementById("starTwo");
        var starThree=document.getElementById("starThree");
        var starFour=document.getElementById("starFour");
        var starFive=document.getElementById("starFive");

        ratingInput.oninput=function(){
            if(ratingInput.value == "1"){
                starOne.style.color="#EE3D4A";
                starTwo.style.color="#e8e8e8";
                starThree.style.color="#e8e8e8";
                starFour.style.color="#e8e8e8";
                starFive.style.color="#e8e8e8";
            }else if(ratingInput.value == "2"){
                starOne.style.color="#EE3D4A";
                starTwo.style.color="#EE3D4A";
                starThree.style.color="#e8e8e8";
                starFour.style.color="#e8e8e8";
                starFive.style.color="#e8e8e8";
            }else if(ratingInput.value == "3"){
                starOne.style.color="#EE3D4A";
                starTwo.style.color="#EE3D4A";
                starThree.style.color="#EE3D4A";
                starFour.style.color="#e8e8e8";
                starFive.style.color="#e8e8e8";
            }else if(ratingInput.value == "4"){
                starOne.style.color="#EE3D4A";
                starTwo.style.color="#EE3D4A";
                starThree.style.color="#EE3D4A";
                starFour.style.color="#EE3D4A";
                starFive.style.color="#e8e8e8";
            }else if(ratingInput.value == "5"){
                starOne.style.color="#EE3D4A";
                starTwo.style.color="#EE3D4A";
                starThree.style.color="#EE3D4A";
                starFour.style.color="#EE3D4A";
                starFive.style.color="#EE3D4A";
            }else{
                starOne.style.color="#e8e8e8";
                starTwo.style.color="#e8e8e8";
                starThree.style.color="#e8e8e8";
                starFour.style.color="#e8e8e8";
                starFive.style.color="#e8e8e8";
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