<?php
     ini_set('session.cookie_lifetime','2592000');

    session_start();
    include("db.php");
    if(!isset($_SESSION['e_id'])){
        header('Location:index.php');
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
   
    <link rel="stylesheet" href="css/edashboard.css?<?php echo time();?>">


    <link rel="shortcut icon" href="images/logo.png"><link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <link href='https://cdn.jsdelivr.net/npm/boxicons@2.0.5/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
</head>
<body>
    <div class="maindiv" id="maindiv">
        <div class="container">
            <div class="topnav">
                <div class="title">
                    <a href="edashboard.php">Foodie</a>
                    <p>for business</p>
                </div>
                <div class="menubtn" id="menuBtn">
                    <i class='bx bx-menu' id="openBtn"></i><i class="fa fa-times" id="closeBtn"></i>
                </div>
            </div>

            <div class="maincontainer">
            <div class="code">
                <?php
                    if(isset($_SESSION['e_id'])){
                        $id=$_SESSION['e_id'];
                        $sql="SELECT * FROM emp WHERE emp_id='".$id."'";
                        $query=mysqli_query($conn,$sql);
                        $row=mysqli_fetch_array($query);

                        $image=$row['emp_image'];
                        $emp_name=$row['emp_name'];

                        $sql="SELECT * FROM restaurant WHERE emp_id='".$id."'";
                        $query=mysqli_query($conn,$sql);
                        $row=mysqli_fetch_array($query);

                        $claimed=$row['claimed'];
                        if($claimed=='no'){
                            $err="<div class='notification' id='notificationDiv'><div class='error'><p>To access update item feature first claim your restaurant.</p></div> </div>";
                            header("Location:edashboard.php?error=$err");
                        }
                        
                    }
                    if(isset($_POST['update_f_id'])){
                        $update_f_id=$_POST['update_f_id'];
                        $emp_id=$_SESSION['e_id'];
                        
                        $f_name=$_POST['item_name'];
                        $f_price=$_POST['item_price'];
                        $f_status=$_POST['status'];
                        $f_cat=$_POST['food_cat'];
                        $f_time=$_POST['food_time'];
                        $f_type=$_POST['food_type'];

                        $f_image1=rand(1,1000000)."-".$_FILES["img1"]["name"];
                        $f_image2=rand(1,1000000)."-".$_FILES["img2"]["name"];
                        $f_image3=rand(1,1000000)."-".$_FILES["img3"]["name"];
                        $f_image4=rand(1,1000000)."-".$_FILES["img4"]["name"];

                                        
                        $file_loc1=$_FILES['img1']['tmp_name'];
                        $file_loc2=$_FILES['img2']['tmp_name'];
                        $file_loc3=$_FILES['img3']['tmp_name'];
                        $file_loc4=$_FILES['img4']['tmp_name'];

                        $file_size1=$_FILES['img1']['size'];
                        $file_size2=$_FILES['img2']['size'];
                        $file_size3=$_FILES['img3']['size'];
                        $file_size4=$_FILES['img4']['size'];

                        $file_type1=$_FILES['img1']['type'];
                        $file_type2=$_FILES['img2']['type'];
                        $file_type3=$_FILES['img3']['type'];
                        $file_type4=$_FILES['img4']['type'];

                        $new_size1=$file_size1/1024;
                        $new_size2=$file_size2/1024;
                        $new_size3=$file_size3/1024;
                        $new_size4=$file_size4/1024;

                        $folder="../../foodie/fooditemimages/";

                        $new_file_name1=strtolower($f_image1);
                        $new_file_name2=strtolower($f_image2);
                        $new_file_name3=strtolower($f_image3);
                        $new_file_name4=strtolower($f_image4);

                        $final_file1=str_replace(' ','-',$new_file_name1);
                        $final_file2=str_replace(' ','-',$new_file_name2);
                        $final_file3=str_replace(' ','-',$new_file_name3);
                        $final_file4=str_replace(' ','-',$new_file_name4);

                        move_uploaded_file($file_loc1,$folder.$final_file1);
                        move_uploaded_file($file_loc2,$folder.$final_file2);
                        move_uploaded_file($file_loc3,$folder.$final_file3);
                        if(move_uploaded_file($file_loc4,$folder.$final_file4)){
                            $sql="UPDATE fooditems SET f_name='$f_name',f_price='$f_price',f_type='$f_type',f_cat='$f_cat',f_time='$f_time',f_status='$f_status',f_img1='$final_file1',f_img2='$final_file2',f_img3='$final_file3',f_img4='$final_file4' WHERE f_id='".$update_f_id."' AND emp_id='".$emp_id."'";
                            $query=mysqli_query($conn,$sql);

                            if($query){
                                $success="<div class='notification' id='notificationDiv'><div class='success'><p>Item updated successfully..</p></div> </div>";
                                header("Location:update_item.php?success=$success");
                            }else{
                                $error="<div class='notification' id='notificationDiv'><div class='error'><p>Something went wrong, try after soem time.</p></div> </div>";
                                header("Location:update_item.php?error=$error");
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
                ?>
            </div>

                <!------------------------------side nav------------------->

                <div class="sidenav" id="sideNav">
                    <div class="userimg">
                    <img src="empimages/<?php echo "$image";?>"">
                    <p><?php echo "$emp_name";?></p>
                    </div>
                    <ul id="navBtnDiv">
                        <li><a class="navBtn" href="edashboard.php"><i class='bx bx-home-alt'></i><span>Dashboard</span><p class="option">Dashboard</p></a></li>
                        <li><a class="navBtn" href="details.php"><i class='bx bx-user'></i> <span>Your Details</span><p class="option">Your Details</p></a></li>
                        <li><a class="navBtn" href="item.php"><i class='bx bx-box' ></i> <span>Total items</span> <p class="option">Total items</p></a></li>
                        <li><a class="navBtn" href="add_item.php"><i class='bx bx-add-to-queue'></i> <span>Add items</span> <p class="option">Add items</p></a></li>
                        <li><a class="navBtn" href="orders.php"><i class='bx bx-box'></i> <span>User orders</span> <p class="option">User orders</p></a></li>
                        <li><a class="navBtn" href="restaurant.php"><i class='bx bx-restaurant' ></i> <span>Restaurant</span> <p class="option">Restaurant</p></a></li>
                        <li><a class="navBtn active" href="update_item.php"><i class='bx bxs-box' ></i> <span>Update items</span> <p class="option">Update items</p></a></li>
                        <li><a class="navBtn" href="update_details.php"><i class='bx bxs-user-detail' ></i> <span>Update Details</span> <p class="option">Update Details</p></a></li>
                        <li><a class="navBtn " href="review.php"><i class='bx bx-star' ></i> <span>All reviews</span> <p class="option">All reviews</p></a></li>
                        <li><a class="navBtn" href="changepass.php"><i class='bx bx-lock-alt' ></i> <span>Change Password</span> <p class="option">Change Password</p></a></li>
                    </ul>
                    <a href="logout.php" class="logoutbtn"><i class='bx bx-log-out' ></i> <span>Logout</span> <p class="option">Logout</p></a>
                </div>

                <!-------------------------content div----------------------->

                <div class="divcontainer">
                    
                    <!---------------------------------------update item div------------------------->

                    <div class="updateitemdiv">

                        <?php
                            if(isset($_GET['update_id'])){
                                $f_id=$_GET['update_id'];
                                $emp_id=$_SESSION['e_id'];
                                $sql="SELECT * FROM fooditems WHERE f_id='".$f_id."' AND emp_id='".$emp_id."'";
                                $query=mysqli_query($conn,$sql);

                                if(mysqli_num_rows($query)==1){
                                    $row=mysqli_fetch_array($query);
                                    $f_id=$row['f_id'];
                                    $f_name=$row['f_name'];
                                    $f_type=$row['f_type'];
                                    $f_time=$row['f_time'];
                                    $f_cat=$row['f_cat'];
                                    $f_status=$row['f_status'];
                                    $f_price=$row['f_price'];
                                    $f_img1=$row['f_img1'];
                                    $f_img2=$row['f_img2'];
                                    $f_img3=$row['f_img3'];
                                    $f_img4=$row['f_img4'];

                                    echo"<div class='updatediv'>
                                    <form action='update_item.php' method='POST' enctype='multipart/form-data'>
                                    <input type='text' name='update_f_id' placeholder='Item id' style='display: none;' value='$f_id'>
                                        <input type='text' name='item_name' placeholder='Item name' required value='$f_name'>
                                        <input type='text' name='item_price' placeholder='Item price' required value='$f_price'>
                                        <select name='status' required>
                                            <optgroup>
                                                <option selected value='$f_status'>$f_status</option>
                                                <option disabled>Select status type</option>
                                                <option value='Available'>Available</option>
                                                <option value='Not available'>Not available</option>
                                                <option value='Coming soon'>Coming soon</option>
                                            </optgroup>
                                        </select>
                                        <select name='food_cat' required>
                                            <option selected value='$f_cat'>$f_cat</option>
                                            <option disabled>Select food category</option>
                                            <option value='Hambruger'>Hambruger</option>
                                            <option value='French fries'>French fries</option>
                                            <option value='KFC chicken'>KFC chicken</option>
                                            <option value='Pizza'>Pizza</option>
                                            <option value='Ice-cream'>Ice-cream</option>
                                            <option value='Cake'>Cake</option>
                                            <option value='Omelet'>Omelet</option>
                                            <option value='Juice'>Juice</option>
                                        </select>
                                        <select name='food_time' required>
                                            <option selected value='$f_time'>$f_time</option>
                                            <option disabled>Select food timing</option>
                                            <option value='Breakfast'>Breakfast</option>
                                            <option value='Lunch'>Lunch</option>
                                            <option value='Dinner'>Dinner</option>
                                        </select>
                                        <select name='food_type' required>
                                            <option selected value='$f_type'>$f_type</option>
                                            <option disabled>Select food type</option>
                                            <option value='Veg food'>Veg food</option>
                                             <option value='Non veg'>Non veg</option>
                                            <option value='Fast food'>Fast food</option>
                                        </select>
                                        <div class='img'>
                                            <p>Select 4 item images</p>
                                            <div class='oldimg'>
                                                <img src='/foodie/fooditemimages/$f_img1'>
                                                <img src='/foodie/fooditemimages/$f_img2'>
                                                <img src='/foodie/fooditemimages/$f_img3'>
                                                <img src='/foodie/fooditemimages/$f_img4'>
                                            </div>
                                            <div class='imgdiv'>
                                                <input type='file' name='img1' required>
                                                <input type='file' name='img2' required>
                                                <input type='file' name='img3' required>
                                                <input type='file' name='img4' required>
                                            </div>
                                        </div>
                                        <input type='submit' value='Update item' class='btn'>
                                    </form>
                                </div>";
                                }
                            }elseif(isset($_POST['search_item'])){
                                $search=$_POST['search_item'];
                                $emp_id=$_SESSION['e_id'];

                                $sql="SELECT * FROM fooditems WHERE f_time='".$search."' AND emp_id='".$emp_id."'";
                                $query=mysqli_query($conn,$sql);

                                if(mysqli_num_rows($query)>0){
                                    echo" <div class='searchitemdiv'>
                                    <form action='update_item.php' method='POST'>
                                        <input type='text' name='search_item' placeholder='Search item by time, e.g:- luch,breakfast,dinner'>
                                        <input type='submit' value='Search' class='btn'>
                                    </form>
                                </div>
                                    <div class='itemlist'>";
                                    while($row=mysqli_fetch_array($query)){
                                        $update_id=$row['f_id'];
                                        $f_name=$row['f_name'];
                                        $f_price=$row['f_price'];
                                        $f_status=$row['f_status'];
                                        $f_img1=$row['f_img1'];

                                        echo" <div class='itemdiv'>
                                        <img src='/foodie/fooditemimages/$f_img1'>
                                        <p>Name : $f_name</p>
                                        <p>Price : ₹ $f_price for one</p>
                                        <p>Status : $f_status</p>
                                        <a href='update_item.php?update_id=$update_id' class='btn'>Update item</a>
                                    </div>";
                                    }
                                    echo"</div>";
                                }else{
                                    echo"<div class='searchitemdiv'>
                                        <form action='update_item.php' method='POST'>
                                            <input type='text' name='search_item' placeholder='Search item by time, e.g:- luch,breakfast,dinner'>
                                            <input type='submit' value='Search' class='btn'>
                                        </form>
                                    </div>
                                    
                                        <div class='noitem'>
                                        <img src='images/alone.png'>
                                        <h1 style='color: #555;'>No food item founds.</h1>
                                    </div>";
                                }
                            }else{
                                echo"<div class='searchitemdiv'>
                                <form action='update_item.php' method='POST'>
                                    <input type='text' name='search_item' placeholder='Search item by time, e.g:- luch,breakfast,dinner'>
                                    <input type='submit' value='Search' class='btn'>
                                </form>
                            </div>";
                            }
                        ?>
                        
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
        
        document.getElementById("notificationDiv").onmousemove=function(){
            document.getElementById("notificationDiv").style.top="-20vh";
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