<?php
    include('db.php');

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Foodie</title>
    <link rel="manifest" href="/foodie/mainfest.json">
   
    <link rel="stylesheet" href="css/style.css?<?php echo time();?>">
    <link rel="stylesheet" href="css/responsive.css">


    <link rel="shortcut icon" href="images/logo.png"><link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <link href='https://cdn.jsdelivr.net/npm/boxicons@2.0.5/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
</head>
<body>
    <div class="maindiv" id="maindiv">
        <div class="code">
        <?php
             if(isset($_POST['fname'])){

                $f_name=$_POST['fname'];
                $l_name=$_POST['lname'];
                $uname=$_POST['uname'];
                $email=$_POST['email'];
                $mobile=$_POST['mobile'];
                $password=md5($_POST['password']);
                $address=$_POST['address'];
        
                if(is_numeric($mobile)){
                    $sql="SELECT * FROM users WHERE email='$email'";
                    $query=mysqli_query($conn,$sql);
                    if(mysqli_num_rows($query) > 0){
        
                        $row=mysqli_fetch_assoc($query);
        
                        if($email==$row['email']){
                            echo(" <div class='notification' id='notificationDiv'>
                            <div class='error'>
                                <p>The email address is already existed. Please sign up with different email..</p>
                            </div>");
                        }
                    }else{
        
                        $image=rand(1,1000).'-'.$_FILES['uimage']['name'];
                        $file_loc=$_FILES['uimage']['tmp_name'];
                        $file_size=$_FILES['uimage']['size'];
                        $file_type=$_FILES['uimage']['type'];
                        $new_size=$file_size/1024;
                        $folder='userimage/';
                        $new_file_name=strtolower($image);
                        $final_file=str_replace(' ','-',$new_file_name);
                
                        move_uploaded_file($file_loc,$folder.$final_file);
                
                        $sql="INSERT INTO users(f_name,l_name,username,email,mobile,uimage,password,address) VALUES ('$f_name','$l_name','$uname','$email','$mobile','$final_file','$password','$address')";
                        $query=mysqli_query($conn,$sql);
                
                        if($query){
                            echo "
                                    <div class='notification' id='notificationDiv'>
                                            <div class='success'>
                                                <p>Sign up Successful..... <a href='index.php'>Login</a></p>
                                            </div>
                                    </div>";
                        }
                    }
        
               
                }else{
                    echo(" <div class='notification' id='notificationDiv'>
                    <div class='error'>
                    <p>Please enter only numbers for Mobile No.......</p>
                    </div>
                    </div>");
                }
            }
        ?>
        </div>
        
        <div class="signupformcontainer">
            <div class="nav">
                <a href="index.php" class="title">Foodie</a>
                <a href="index.php" class="btn">Login</a>
            </div>
            <div class="signupformdiv">
                <div class="formdiv">
                    <form action="signup.php" method="POST" enctype="multipart/form-data">
                        <div class="col">
                            <div class="fname div">
                                <i class='bx bx-user'></i>
                                <input type="text" name="fname" placeholder="First Name" required>
                            </div>
                            <div class="lname div">
                                <i class='bx bx-user'></i>
                                <input type="text" name="lname" placeholder="Last Name">
                            </div>
                            <div class="uname div">
                                <i class='bx bx-user'></i>
                                <input type="text" name="uname" placeholder="Username" required>
                            </div>
                            <div class="email div">
                                <i class="fa fa-envelope-o"></i>
                                <input type="email" name="email" placeholder="Email" required>
                            </div>
                            <div class="mobile div">
                                <i class='bx bx-phone' ></i>
                                <input type="text" name="mobile" placeholder="Mobile No." required maxlength="10">
                            </div>
                            <div class="img">
                                <p><i class='bx bx-image'></i> Select profile image</p>
                                <input type="file" name="uimage" required>
                            </div>
                        </div>
                        <div class="col">
                            <div class="password">
                                <i class='bx bx-lock' ></i>
                                <input type="password" name="password" id="passInput" placeholder="Password" required>
                                <i class='bx bx-show' id="showPass"></i><i class='bx bx-hide' id="hidePass"></i>
                            </div>
                            <div class="address">
                                <i class='bx bx-current-location' ></i>
                                <textarea name="address" cols="30" rows="11" placeholder="Address" required></textarea>
                            </div>
                            <div class="btndiv">
                                <input type="submit" value="Sign Up" class="btn" name="signup">
                            </div>
                            <div class="logindiv">
                                <p>Already Have an account <a href="index.php">Login</a></p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>

    <!-- <script>
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
    </script> -->
    <script>
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
    </script>
</body>
</html>