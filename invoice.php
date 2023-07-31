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
       <div class="invoicediv">
           <?php
                if(isset($_GET['order_id'])){
                    $order_id=$_GET['order_id'];
                    $sql="SELECT * FROM user_orders WHERE order_id='".$order_id."'";
                    $query=mysqli_query($conn,$sql);

                    if(mysqli_num_rows($query)>0){
                        while($row=mysqli_fetch_array($query)){
                            $user_id=$_SESSION['id'];
                            $emp_id=$row['emp_id'];
                            $f_name=$row['f_name'];
                            $f_price=$row['f_price'];
                            $f_qty=$row['f_qty'];
                            $t_price=$row['t_price'];
                            $payment_status=$row['payment_status'];
                            $payment_type=$row['payment_type'];


                            $sql1="SELECT * FROM users WHERE uid='".$user_id."'";
                            $query1=mysqli_query($conn,$sql1);

                            $row1=mysqli_fetch_array($query1);

                            $u_name=$row1['f_name'];
                            $l_name=$row1['l_name'];
                            $mobile=$row1['mobile'];
                            $email=$row1['email'];
                            $address=$row1['address'];

                            $sql2="SELECT * FROM restaurant WHERE emp_id='".$emp_id."'";
                            $query2=mysqli_query($conn,$sql2);

                            $row2=mysqli_fetch_array($query2);

                            $r_name=$row2['r_name'];
                            $r_mobile=$row2['r_mobile'];
                            $r_email=$row2['r_email'];
                            $r_address=$row2['r_address'];


                            echo"<div class='billdiv'>
                            <div class='title'>
                                <div class='logo'>
                                <img src='images/logo.png'>
                                 <h1> Foodie</h1>
                                </div>
                                 <p>Invoice no : $order_id</p>
                            </div>
                            <div class='shipaddress'>
                                <h1>Shiping Details</h1>
                                <p>Name : $u_name $l_name</p>
                                <p>Mobile no : $mobile</p>
                                <p>Email : $email</p>
                                <p>Address : $address</p>
                            </div>
                            <div class='restaurant'>
                                <h1>Restaurant Details</h1>
                                <p>Name : $r_name</p>
                                <p>Mobile no : $r_mobile</p>
                                <p>Email : $r_email</p>
                                <p>Address : $r_address</p>
                            </div>
                            <div class='itemdiv'>
                                <table>
                                    <tr>
                                        <th>Name</th>
                                        <th>Quantity</th>
                                        <th>Price</th>
                                        <th>Payment type</th>
                                        <th>Payment status</th>
                                    </tr>
                                    <tr>
                                        <td>$f_name</td>
                                        <td>$f_qty</td>
                                        <td>₹ $f_price for one</td>
                                        <td>$payment_type</td>
                                        <td>$payment_status</td>
                                    </tr>
                                </table>
                            </div>
                            <div class='total_amount'>
                                <p>Total amount</p>
                                <p>₹ $t_price</p>
                            </div>
                        </div>";

                        }
                    }
                }
           ?>
       </div>
        
    </div>
    <script>
        $(document).ready(function () {
            window.print();
        });
    </script>
</body>
</html>