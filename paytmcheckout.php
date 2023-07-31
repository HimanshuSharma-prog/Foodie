<?php
     ini_set('session.cookie_lifetime','2592000');

    session_start();
    include("db.php");
    date_default_timezone_set('Asia/Kolkata'); 
    if(isset($_SESSION['id'])){

        $ORDER_ID = $_POST["ORDER_ID"];
        $CUST_ID = $_POST["CUST_ID"];
        $INDUSTRY_TYPE_ID = $_POST["INDUSTRY_TYPE_ID"];
        $CHANNEL_ID = $_POST["CHANNEL_ID"];
        $TXN_AMOUNT = $_POST["TXN_AMOUNT"];

        $user_id=$_SESSION['id'];

        $sql="SELECT * FROM cart WHERE user_id='".$user_id."'";
        $query=mysqli_query($conn,$sql);
            while($row=mysqli_fetch_array($query)){
                $emp_id=$row['emp_id'];
                $f_id=$row['f_id'];
                $f_name=$row['f_name'];
                $f_qty=$row['f_qty'];
                $f_price=$row['f_price'];
                $t_price=$row['t_price'];
                $f_image=$row['f_image'];
                $bill_no='Foodie-'.$ORDER_ID;
                $order_date=date("y/m/d");
                $order_time=date("h:i:s");

                $sql="INSERT INTO user_orders(user_id,emp_id,f_id,order_id,payment_id,f_name,f_image,f_price,f_qty,t_price,payment_status,payment_type,order_status,bill_no,order_date,order_time,email,final_email,notify)VALUES('$user_id','$emp_id','$f_id','$ORDER_ID','$ORDER_ID','$f_name','$f_image','$f_price','$f_qty','$t_price','pending','paytm','pending','$bill_no','$order_date','$order_time','pending','pending','send')";
                $query1=mysqli_query($conn,$sql);

            }
            // if($query1){
            //     $success="<div class='notification' id='notificationDiv'><div class='success'><p>Item ordered successfully check your email for more details.</p></div> </div>";
            //     header("Location:loggedin.php?success=$success");
            // }else{
            //     $error="<div class='notification' id='notificationDiv'><div class='error'><p>Something went wrong, try after soem time.</p></div> </div>";
            //     header("Location:loggedin.php?error=$error");
            // }
            $sql="DELETE FROM cart WHERE user_id='".$user_id."'";
            $query2=mysqli_query($conn,$sql);

            if($query2){
                $user_id=$_SESSION['id'];
                $sql="SELECT * FROM user_orders WHERE user_id='".$user_id."' AND email='pending'";
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
                    $query1=mysqli_query($conn,$sql);

                    $row1=mysqli_fetch_array($query1);

                    $r_address=preg_replace('/\s+/', '', $row1['r_address']);

                    $email=$_SESSION['email'];
                    $to_email = $email;
                    $subject = "Order successful";
                    $body = "Your order from foodie is successful. Your order will be packed soon. You have selected online patym gateway option for your order. Still your payment is in pending after completing the payment order will be sended.
Total amount : $final_amount, 
Order id : $ORDER_ID,
Order date : $order_date and  
Bill no is : $bill_no
Check the restaurant from you ordered the food here https://www.google.com/maps/search/$r_address
Thank for ordering through Foodie";
                    $headers = "From: foodie";
            
                    
                    if (mail($to_email, $subject, $body, $headers)) {
                        $sql="UPDATE user_orders SET email='send' WHERE user_id='".$user_id."'";
                        $query=mysqli_query($conn,$sql);
                        if($query){
                            header("Location:paytm-main/pgRedirect.php?ORDER_ID=$ORDER_ID&CUST_ID=$CUST_ID&INDUSTRY_TYPE_ID=$INDUSTRY_TYPE_ID&CHANNEL_ID=$CHANNEL_ID&TXN_AMOUNT=$TXN_AMOUNT");
                        }
                    }
                    
                }
                
            }else{
                $error="<div class='notification' id='notificationDiv'><div class='error'><p>Something went wrong, try after soem time1.</p></div> </div>";
                header("Location:loggedin.php?error=$error");
            }

    }else{
        $error="<div class='notification' id='notificationDiv'><div class='error'><p>Something went wrong, try after soem time2.</p></div> </div>";
        header("Location:loggedin.php?error=$error");
    }

?>