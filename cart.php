<?php
 ini_set('session.cookie_lifetime','2592000');

    session_start();
include("db.php");
    if(isset($_GET['f_id'])){
        $f_id=$_GET['f_id'];
        $user_id=$_SESSION['id'];
        $sql="SELECT * From cart WHERE f_id='".$f_id."' AND user_id='".$user_id."'";
        $query=mysqli_query($conn,$sql);

        if(mysqli_num_rows($query)==1){
            $err="<div class='notification' id='notificationDiv'><div class='error'><p>The food item is already added into cart.</p></div> </div>";
            header("Location:item.php?f_id=$f_id&error=$err");
        }else{
            $sql="SELECT * FROM fooditems WHERE f_id='".$f_id."'";
            $query=mysqli_query($conn,$sql);
            $row=mysqli_fetch_array($query);
            $f_name=$row['f_name'];
            $emp_id=$row['emp_id'];
            $f_image=$row['f_img1'];
            $f_price=$row['f_price'];
            $f_qty=1;
            $t_price=$f_qty*$f_price;

            $sql="INSERT INTO cart(user_id,f_id,emp_id,f_name,f_image,f_qty,f_price,t_price) VALUES ('$user_id','$f_id','$emp_id','$f_name','$f_image','$f_qty','$f_price','$t_price')";
            $query=mysqli_query($conn,$sql);

            if($query){
                $success="<div class='notification' id='notificationDiv'><div class='success'><p>'$f_name' is successfully added in your cart.</p></div> </div>";
                header("Location:item.php?f_id=$f_id&success=$success");
            }else{
                $error="<div class='notification' id='notificationDiv'><div class='error'><p>Something went wrong, try after soem time.</p></div> </div>";
                header("Location:item.php?f_id=$f_id&error=$error");
            }
        }
    }
    if(isset($_GET['remove_id'])){
        $remove_id=$_GET['remove_id'];
        $sql="SELECT * FROM cart WHERE id='$remove_id'";
        $query=mysqli_query($conn,$sql);

        if(mysqli_num_rows($query)==1){
            $row=mysqli_fetch_array($query);

            $f_name=$row['f_name'];
            $f_id=$row['f_id'];

            $sql="DELETE FROM cart WHERE id='$remove_id'";
            $query=mysqli_query($conn,$sql);

            if($query){
                $success="<div class='notification' id='notificationDiv'><div class='success'><p>'$f_name' is successfully removed from your cart.</p></div> </div>";
                header("Location:item.php?f_id=$f_id&success=$success");
            }else{
                $error="<div class='notification' id='notificationDiv'><div class='error'><p>Something went wrong, try after soem time.</p></div> </div>";
                header("Location:item.php?f_id=$f_id&error=$error");
            }
        }
        
    }
?>