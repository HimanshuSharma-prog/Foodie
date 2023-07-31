<?php 
    include("db.php");
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
            
            if(isset($_GET['error'])){
                $err=$_GET['error'];
                echo(" <div class='notification' id='notificationDiv'>
                            <div class='error'>
                                <p>$err</p>
                            </div>");
            }
        ?>
    </div>
        <!--------------------------------------------nav------------------------------------------>
        <div class="nav" id="nav">
            <nav>
                <div class="title">
                     <a href="index.php">Foodie</a>
                </div>
                    <form action="search.php" method="POST" class="search" autocomplete="on">
                        <input type="text" placeholder="Search for a dish" id="search" name="f_search"><i class="fa fa-search"></i>
                    </form>
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
           <!--card-->
           <?php
                if(isset($_POST['f_search'])){
                    $search=$_POST['f_search'];

                        $sql="SELECT * FROM fooditems WHERE f_name='".$search."' AND f_status='Available'";
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
                                        </div>
                                        <div class='rating'>
                                            <i class='fa fa-star'></i>
                                            <i class='fa fa-star'></i>
                                            <i class='fa fa-star'></i>
                                            <i class='fa fa-star'></i>
                                            <i class='fa fa-star-half-o'></i> 4.5
                                        </div>
                                    </div>
                                    <div class='locdiv'>
                                        <i class='bx bxs-map' ></i><p>$address</p>
                                    </div>
                                </div>
                                
                            </a>";
                            }
                        }else{
                            $sql="SELECT * FROM fooditems WHERE f_price='".$search."' AND f_status='Available'";
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
                                            </div>
                                            <div class='rating'>
                                                <i class='fa fa-star'></i>
                                                <i class='fa fa-star'></i>
                                                <i class='fa fa-star'></i>
                                                <i class='fa fa-star'></i>
                                                <i class='fa fa-star-half-o'></i> 4.5
                                            </div>
                                        </div>
                                        <div class='locdiv'>
                                            <i class='bx bxs-map' ></i><p>$address</p>
                                        </div>
                                    </div>
                                    
                                </a>";
                                }
                            }else{
                                  
                                $sql="SELECT * FROM fooditems WHERE f_cat='".$search."' AND f_status='Available'";
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
                                                </div>
                                                <div class='rating'>
                                                    <i class='fa fa-star'></i>
                                                    <i class='fa fa-star'></i>
                                                    <i class='fa fa-star'></i>
                                                    <i class='fa fa-star'></i>
                                                    <i class='fa fa-star-half-o'></i> 4.5
                                                </div>
                                            </div>
                                            <div class='locdiv'>
                                                <i class='bx bxs-map' ></i><p>$address</p>
                                            </div>
                                        </div>
                                        
                                    </a>";
                                    }
                                }else{
                                    $sql="SELECT * FROM fooditems WHERE f_time='".$search."' AND f_status='Available'";
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
                                                    </div>
                                                    <div class='rating'>
                                                        <i class='fa fa-star'></i>
                                                        <i class='fa fa-star'></i>
                                                        <i class='fa fa-star'></i>
                                                        <i class='fa fa-star'></i>
                                                        <i class='fa fa-star-half-o'></i> 4.5
                                                    </div>
                                                </div>
                                                <div class='locdiv'>
                                                    <i class='bx bxs-map' ></i><p>$address</p>
                                                </div>
                                            </div>
                                            
                                        </a>";
                                        }
                                    }else{
                                        $sql="SELECT * FROM fooditems WHERE f_type='".$search."' AND f_status='Available'";
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
                                                        </div>
                                                        <div class='rating'>
                                                            <i class='fa fa-star'></i>
                                                            <i class='fa fa-star'></i>
                                                            <i class='fa fa-star'></i>
                                                            <i class='fa fa-star'></i>
                                                            <i class='fa fa-star-half-o'></i> 4.5
                                                        </div>
                                                    </div>
                                                    <div class='locdiv'>
                                                        <i class='bx bxs-map' ></i><p>$address</p>
                                                    </div>
                                                </div>
                                                
                                            </a>";
                                            }
                                        }else{
                                            echo "<div class='notfound'>
                                            <p>No food item available as '$search', or the food item is currently not available.</p>
                                            <img src='images/not-found2.png' alt=''>
                                        </div>";
                                        }
                                    }
                                }
                            }
                        }
                }
                if(isset($_GET['time'])){
                    $time=$_GET['time'];
                    $sql="SELECT * FROM fooditems WHERE f_time='".$time."'";
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
                                    </div>
                                    <div class='rating'>
                                        <i class='fa fa-star'></i>
                                        <i class='fa fa-star'></i>
                                        <i class='fa fa-star'></i>
                                        <i class='fa fa-star'></i>
                                        <i class='fa fa-star-half-o'></i> 4.5
                                    </div>
                                </div>
                                <div class='locdiv'>
                                    <i class='bx bxs-map' ></i><p>$address</p>
                                </div>
                            </div>
                            
                        </a>";
                        }
                    }else{
                        echo "<div class='notfound'>
                        <p>No food item available as '$time'</p>
                        <img src='images/not-found2.png' alt=''>
                    </div>";
                    }
                }elseif(isset($_GET['cat'])){
                    $cat=$_GET['cat'];
                    $sql="SELECT * FROM fooditems WHERE f_cat='".$cat."'";
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
                                    </div>
                                    <div class='rating'>
                                        <i class='fa fa-star'></i>
                                        <i class='fa fa-star'></i>
                                        <i class='fa fa-star'></i>
                                        <i class='fa fa-star'></i>
                                        <i class='fa fa-star-half-o'></i> 4.5
                                    </div>
                                </div>
                                <div class='locdiv'>
                                    <i class='bx bxs-map' ></i><p>$address</p>
                                </div>
                            </div>
                            
                        </a>";
                        }
                    }else{
                        echo "<div class='notfound'>
                        <p>No food item available as '$cat'</p>
                        <img src='images/not-found2.png' alt=''>
                    </div>";
                    }
                }elseif(isset($_GET['type'])){
                    $type=$_GET['type'];
                    $sql="SELECT * FROM fooditems WHERE f_type='".$type."'";
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
                                    </div>
                                    <div class='rating'>
                                        <i class='fa fa-star'></i>
                                        <i class='fa fa-star'></i>
                                        <i class='fa fa-star'></i>
                                        <i class='fa fa-star'></i>
                                        <i class='fa fa-star-half-o'></i> 4.5
                                    </div>
                                </div>
                                <div class='locdiv'>
                                    <i class='bx bxs-map' ></i><p>$address</p>
                                </div>
                            </div>
                            
                        </a>";
                        }
                    }else{
                        echo "<div class='notfound'>
                        <p>No food item available as '$type'</p>
                        <img src='images/not-found2.png' alt=''>
                    </div>";
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
            
        </a> -->

        </div>   
        
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
        // document.getElementById("showPass").onclick=function(){
        //     document.getElementById("passInput").type="text";
        //     document.getElementById("hidePass").style.display="block";
        //     document.getElementById("showPass").style.display="none";
        // }
        // document.getElementById("hidePass").onclick=function(){
        //     document.getElementById("passInput").type="password";
        //     document.getElementById("showPass").style.display="block";
        //     document.getElementById("hidePass").style.display="none";
        // }
        // document.getElementById("loginbtn").onclick=function(){
        //     document.getElementById("loginform").style.top="1vh";
        // }
        // document.getElementById("closebtn").onclick=function(){
        //     document.getElementById("loginform").style.top="-110%";
        // }
        document.getElementById("notificationDiv").onmousemove=function(){
            document.getElementById("notificationDiv").style.top="-20vh";
        }
    </script>
</body>
</html>