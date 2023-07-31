<?php
     ini_set('session.cookie_lifetime','2592000');

    session_start();
    include("db.php");
    date_default_timezone_set('Asia/Kolkata'); 
    if(!isset($_SESSION['id'])){
        header("location:index.php?error=First login to check food items details");
    }
    if(isset($_POST['cancel_id'])){
        $cancel_id=$_POST['cancel_id'];
        $reason=$_POST['reason'];
        $cancel_date=date("y/m/d");
        $sql="UPDATE user_orders SET order_status='canceled',payment_status='Order canceled',reason='$reason',cancel_date='$cancel_date' WHERE id='".$cancel_id."'";
        $query=mysqli_query($conn,$sql);

        if($query){
            $sql1="SELECT * FROM user_orders WHERE id='".$cancel_id."'";
            $query1=mysqli_query($conn,$sql1);

            $row1=mysqli_fetch_array($query1);

            $final_amount=$row1['t_price'];
            $order_id=$row1['order_id'];
            $order_date=$row1['order_date'];
            $cancel_date=$row1['cancel_date'];
            $emp_id=$row1['emp_id'];

            $sql2="SELECT * FROM restaurant WHERE emp_id='".$emp_id."'";
            $query2=mysqli_query($conn,$sql2);

            $row2=mysqli_fetch_array($query2);

            $r_address=preg_replace('/\s+/', '', $row2['r_address']);

            $email=$_SESSION['email'];
            $to_email = $email;
            $subject = "Order canceled";
            $body = " Your order from foodie is successfully delted. Check your order details down
Total amount : $final_amount, 
Order id : $order_id,
Order date : $order_date and  
Order cancel date is : $cancel_date
Check the restaurant from you ordered the food here https://www.google.com/maps/search/$r_address
Thank for ordering through Foodie ";
                
            $headers = "From: foodie";
            
                    
            if (mail($to_email, $subject, $body, $headers)) {
                $success="<div class='notification' id='notificationDiv'><div class='success'><p>Your order is successfully canceled.</p></div> </div>";
                header("Location:orders.php?success=$success");
            }
        }
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
        <div class="cancelorder">
            <div class="nav">
                <h1>Foodie</h1>
                <p>order details</p>
            </div>
            <?php
                if($_GET['order_id']){
                    $order_id=$_GET['order_id'];
                    $sql="SELECT * FROM user_orders WHERE order_id='".$order_id."'";
                    $query=mysqli_query($conn,$sql);

                    if(mysqli_num_rows($query)>0){
                        while($row=mysqli_fetch_array($query)){
                            $f_image=$row['f_image'];
                            $f_name=$row['f_name'];
                            $f_qty=$row['f_qty'];
                            $f_price=$row['f_price'];
                            $t_price=$row['t_price'];
                            $order_date=$row['order_date'];
                            $payment_status=$row['payment_status'];
                            $payment_type=$row['payment_type'];
                            $cancel_id=$row['id'];
                            
                            $order_time=$row['order_time'];

                            $time1=strtotime($order_time);
                            $time=  date("h:i:s");
                            $time2=strtotime($time);
                            $final_time=round(($time2 - $time1)/60);
                            
                            if(abs($final_time) < 5){
                                $error="<div class='notification' id='notificationDiv'><div class='error'><p>You can't cancel a order before 5 minutes of your order.</p></div> </div>";
                                header("location:orders.php?error=$error");
                            }elseif(abs($final_time) > 15){
                                $error="<div class='notification' id='notificationDiv'><div class='error'><p>You can't cancel a order after 15 minutes of your order.</p></div> </div>";
                                header("location:orders.php?error=$error");
                            }else{
                                echo"<div class='orderdiv'>
                                <div class='detailsdiv'>
                                    <table>
                                        <tr>
                                            <th>Image</th>
                                            <th>Name</th>
                                            <th>Quantity</th>
                                            <th>Price</th>
                                            <th>Total price</th>
                                            <th>Order date</th>
                                            <th>Payment status</th>
                                            <th>Payment type</th>
                                        </tr>
                                        <tr>
                                            <td><img src='fooditemimages/$f_image'></td>
                                            <td>$f_name</td>
                                            <td>$f_qty</td>
                                            <td>₹ $f_price for one</td>
                                            <td>₹ $t_price</td>
                                            <td>$order_date</td>
                                            <td>$payment_status</td>
                                            <td>$payment_type</td>
                                        </tr>
                                    </table>
                                </div>
                                <div class='formdiv'>
                                    <form action='cancel_order.php' method='POST'>
                                        <textarea name='reason'cols='30' rows='5' placeholder='Enter your reason' required></textarea>
                                        <input type='text' name='cancel_id' class='hidden' value='$cancel_id'>
                                        <input type='submit' value='Cancel Order'>
                                    </form>
                                </div>
                            </div>";
                            }
                        }
                    }

                }
            ?>
            
        </div>
        
    </div>
</body>
</html>