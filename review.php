<?php
 ini_set('session.cookie_lifetime','2592000');

    session_start();
include("db.php");
    if(isset($_POST['f_id'])){
        $rating=$_POST['rating'];
        $review=$_POST['review'];
        $user_id=$_SESSION['id'];

        $f_id=$_POST['f_id'];

        $sql="SELECT * FROM fooditems WHERE f_id='".$f_id."'";
        $query=mysqli_query($conn,$sql);

        $row=mysqli_fetch_array($query);

        $emp_id=$row['emp_id'];

        $image=rand(1,10000).'-'.$_FILES['reviewimg']['name'];
        $file_loc=$_FILES['reviewimg']['tmp_name'];
        $file_size=$_FILES['reviewimg']['size'];
        $file_type=$_FILES['reviewimg']['type'];
        $new_size=$file_size/1024;
        $folder='reviewimages/';
        $new_file_name=strtolower($image);
        $final_file=str_replace(' ','-',$new_file_name);

        if(move_uploaded_file($file_loc,$folder.$final_file)){
            $sql1="INSERT INTO user_review(user_id,emp_id,f_id,rating,review,review_image) VALUES ('$user_id','$emp_id','$f_id','$rating','$review','$final_file')";
            $query1=mysqli_query($conn,$sql1);

            if($query1){
                $success="<div class='notification' id='notificationDiv'><div class='success'><p>Your review has suucessfully added.</p></div> </div>";
                header("Location:item.php?f_id=$f_id&success=$success");
            }else{
                $error="<div class='notification' id='notificationDiv'><div class='error'><p>Something went wrong, try after soem time1.</p></div> </div>";
                header("Location:item.php?f_id=$f_id&error=$error");
            }
        }

        

        
    }            

?>