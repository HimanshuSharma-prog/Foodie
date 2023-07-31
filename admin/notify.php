<?php
   if(isset($_POST['notify'])){
        echo"correct";
        echo"<script>
            window.location.replace('dashboard.php?success=<div class='notification' id='notificationDiv'><div class='error'><p>data correct</p></div></div></div>');
    </script>";
        // header("Location:dashboard.php?success= <div class='notification' id='notificationDiv'><div class='error'><p>data correct</p></div></div></div>");
    }else{
        echo"try again";
        header("Location:dashboard.php?error= <div class='notification' id='notificationDiv'><div class='error'><p>data not correct</p></div></div></div>");
    }         
?>

