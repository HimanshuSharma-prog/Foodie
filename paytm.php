<?php
     ini_set('session.cookie_lifetime','2592000');

    session_start();
    include("db.php");
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
        <div class="paytmdiv">
            <div class="nav">
                <h1>Foodie</h1>
                <p>Paytm Checkout</p>
            </div>
            <form action="paytmcheckout.php" method="POST">
                <?php
                    if(isset($_SESSION['id'])){
                        $user_id=$_SESSION['id'];
                        $sql="SELECT * FROM cart WHERE user_id='".$user_id."'";
                        $query=mysqli_query($conn,$sql);
                        $order_id="ORDS".rand(10000,99999999);

                        if(mysqli_num_rows($query)>0){
                            $total_amount=0;
                            while($row=mysqli_fetch_array($query)){
                                $cust_id="Foodie-".$user_id;
                                $t_price=$row['t_price'];
                                $price_array=array($t_price);
                                $price_sum=array_sum($price_array);
                                $total_amount+=$price_sum;
                            }
                        }
                    }
                ?>
                <p>Order ID : <?php echo "$order_id"; ?></p>
                <p>Customer ID : <?php echo "$cust_id" ?></p>
                <p>Total amount :₹ <?php echo"$total_amount"?></p>
                <input class="hidden" id="ORDER_ID" tabindex="1" maxlength="20" size="20" name="ORDER_ID" autocomplete="off" value="<?php echo "$order_id";?>">
                <input class="hidden" id="CUST_ID" tabindex="2" maxlength="12" size="12" name="CUST_ID" autocomplete="off" value="<?php echo "$cust_id"; ?>">
                <input class="hidden" id="INDUSTRY_TYPE_ID" tabindex="4" maxlength="12" size="12" name="INDUSTRY_TYPE_ID" autocomplete="off" value="Retail">
                <input class="hidden" id="CHANNEL_ID" tabindex="4" maxlength="12" size="12" name="CHANNEL_ID" autocomplete="off" value="WEB">
                <input class="hidden" class="form-control" title="TXN_AMOUNT" tabindex="10" type="text" name="TXN_AMOUNT" value="<?php echo"$total_amount"; ?>">

                <input type="submit" value="Pay now" class="btn">
            </form>
        </div>
        
    </div>
</body>
</html>