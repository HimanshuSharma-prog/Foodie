<?php
     ini_set('session.cookie_lifetime','2592000');

    session_start();
    include("db.php");
    if(isset($_SESSION['e_id'])){
        echo"1";
        $id=$_SESSION['e_id'];
        if(isset($_GET['r_id'])){
            echo"2"; 
            $r_id=$_GET['r_id'];
            $sql="SELECT * FROM restaurant WHERE r_id='".$r_id."' AND emp_id='".$id."'";
            $query=mysqli_query($conn,$sql);
            if(mysqli_num_rows($query)==1){
                echo"3";
                $sql="UPDATE restaurant SET claimed='yes' WHERE r_id='$r_id' AND emp_id='$id'";
                $query=mysqli_query($conn,$sql);
                if($query){
                    $to_email = $_SESSION['e_email'];
                    $subject = "Thank you";
                    $body = "Thank you for partnership with Foodie. 

Now you can add your food item available in your restaurant.And recieve orders from Foodie users.
                    
Using the edashboard for managing food item you can manage your restaurant details, update food item, manage users orders.";
                    $headers = "From:Foodie";

        
                    if (mail($to_email, $subject, $body, $headers)) {

                        header("location:index.php?message=<div class='notification' id='notificationDiv'><div class='success'><p>Your restaurant is claimed. Now you can addfood item and recive orders from users.</p></div></div>");
                    }
                }else{
                    header("location:index.php?message=<div class='notification' id='notificationDiv'><div class='error'><p>Your are not allowed to claim others restaurant.</p></div></div>");
                }
            }else{
                header("location:index.php?message=<div class='notification' id='notificationDiv'><div class='error'><p>Your are not allowed to claim others restaurant</p></div></div>" );
            }
        }else{
            header("location:index.php?message=<div class='notification' id='notificationDiv'><div class='error'><p>Some thing went wrong.</p></div></div>");
        }
    }else{
        header("Location:index.php?message=<div class='notification' id='notificationDiv'><div class='error'><p>Some thing went wrong.</p></div></div>");
    }
?>