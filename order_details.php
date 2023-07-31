<?php
     ini_set('session.cookie_lifetime','2592000');

    session_start();
    include("db.php");
    date_default_timezone_set('Asia/Kolkata'); 
    if(!isset($_SESSION['id'])){
        header("location:index.php?error=First login to check food items details");
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
        <?php
            
        ?>
        <div class="userorderdetails">
            <div class="nav">
                <h1>Foodie</h1>
                <p>order details</p>
            </div>
                    <?php 
                        if(isset($_GET['order_id'])){
                            $order_id=$_GET['order_id'];
                            $sql="SELECT * FROM user_orders WHERE order_id='".$order_id."'";
                            $query1=mysqli_query($conn,$sql);
                        
                            $row1=mysqli_fetch_array($query1);
                            $order_time1=$row1['order_time'];
                            $payment_type=$row1['payment_type'];
                            $order_status=$row1['order_status'];

                            $time1=strtotime($order_time1);
                            $time=  date("h:i:s");
                            $time2=strtotime($time);
                            $final_time=round(($time2 - $time1)/60);

                            $width=abs(($final_time/20)*100); 
                            // echo"$order_time1<br><br>";
                            // echo"$time<br><br>";
                            // echo"$width";     
                            if($order_status=='pending'){
                                echo"<div class='trackdiv'>
                                <p class='title'>
                                    Order track status
                                </p>
                                    
                                <div class='sliderdiv'>
                                    <p>Packed</p>
                                    <div class='slider'>
                                        
                                        <div class='slidebar' style='width:$width%;'></div>
                                    </div>
                                    <p>Recieved</p>
                                </div>
                                
                            </div>";
                            }elseif($order_status=='recieved'){
                                echo"<div class='trackdiv'>
                                <p class='title'>
                                    Order track status
                                </p>
                                    
                                <div class='sliderdiv'>
                                    <p>Packed</p>
                                    <div class='slider'>
                                        
                                        <div class='slidebar' style='width:$width%;'></div>
                                    </div>
                                    <p>Recieved</p>
                                </div>
                                
                            </div>";
                            }
                            
                        }
                        
                    ?>
            
            <?php
                if(isset($_GET['order_id'])){
                    $order_id=$_GET['order_id'];
                    $sql="SELECT * FROM user_orders WHERE order_id='".$order_id."'";
                    $query=mysqli_query($conn,$sql);
                    if(mysqli_num_rows($query)>0){
                        while($row=mysqli_fetch_array($query)){
    
                            $f_name=$row['f_name'];
                            $f_price=$row['f_price'];
                            $f_qty=$row['f_qty'];
                            $order_date=$row['order_date'];
                            $order_time=$row['order_time'];
                            $order_status=$row['order_status'];
                            $payment_id=$row['payment_id'];
                            $payment_staus=$row['payment_status'];
                            $payment_type=$row['payment_type'];
                            $t_price=$row['t_price'];
                            $f_image=$row['f_image'];
    
                            echo"<div class='detailsdiv'/>
                            <div class='col'>
                                <img src='fooditemimages/$f_image'/>
                            </div>
                            <div class='col'>
                                <p>Item name : $f_name</p>
                                <p>Price : ₹ $f_price for one</p>
                                <p>Quantity : $f_qty</p>
                                <p>Order date : $order_date</p>
                                <p>Order time : $order_time</p>
                                <p>Order status : $order_status</p>
                                <p>Order Id : $order_id</p>
                                <p>Payment Id : $payment_id</p>
                                <p>Payment status : $payment_staus</p>
                                <p>Payment type : $payment_type</p>
                                <p>Total price : $t_price</p>
                            </div>
                        </div>";
                            
                        }
                    }
                } 
            ?>
            <?php
                if($width > 100){
                    $sql2="UPDATE user_orders SET payment_status='Done',order_status='recieved' WHERE order_id='".$order_id."'";
                    $query2=mysqli_query($conn,$sql2);

                    if($query2){
                        $sql="SELECT * FROM user_orders WHERE order_id='".$order_id."' AND final_email='pending'";
                        $query=mysqli_query($conn,$sql);
                        if(mysqli_num_rows($query)>0){
                            $final_amount=0;
                            while($row=mysqli_fetch_array($query)){
                                $order_date=$row['order_date'];
                                $emp_id=$row['emp_id'];
                                $bill_no=$row['bill_no'];
                                $order_id=$row['order_id'];
                                $t_price=$row['t_price'];
                                $price_array=array($t_price);
                                $price_sum=array_sum($price_array);
                                $final_amount+=$price_sum;
    
                            }
                            
                            $sql="SELECT * FROM restaurant WHERE emp_id='".$emp_id."'";
                            $query3=mysqli_query($conn,$sql);
    
                            $row3=mysqli_fetch_array($query3);
    
                            $r_address=preg_replace('/\s+/', '', $row3['r_address']);
    
                            $email=$_SESSION['email'];
                            $to_email = $email;
                            $subject = "Order recived";
                            $body = " Your order has been delivered suucessfully. 
Total amount : $final_amount, 
Order id : $order_id,
Order date : $order_date and  
Bill no is : $bill_no
Check the restaurant from you ordered the food here https://www.google.com/maps/search/$r_address Thank for ordering through Foodie ";
                            $headers = "From: foodie";
                    
                            
                            if (mail($to_email, $subject, $body, $headers)) {
                                $sql="UPDATE user_orders SET final_email='send' WHERE order_id='".$order_id."'";
                                $query=mysqli_query($conn,$sql);
                                if($query){
                                    echo "<br><br>";
                                }
                                else{
                                    echo"not sended";
                                }
                            }
                            
                        }
                    }

                   
                }

            ?>
            
          
        </div>
        
    </div>
</body>
</html>