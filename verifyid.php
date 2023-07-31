<?php
    include("db.php");
    if(isset($_GET['id'])){
        $id=$_GET['id'];
        $sql="SELECT * FROM users WHERE uid='".$id."' limit 1";
        $query=mysqli_query($conn,$sql);

        if(mysqli_num_rows($query)==1){
            header('location:updateforgotpassword.php');
        }else{
            $err="The email that you want to change the password is not exist";
            header("location:index.php?error=$err");
        }
    }
?>