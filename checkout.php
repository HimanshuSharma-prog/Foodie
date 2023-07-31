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
        <div class="cartcheckoutdiv">
            <div class="nav">
                <h1>Foodie</h1>
                <p>Cart Checkout</p>
            </div>
            <div class="cartdetailsdiv">
                <table>
                    <tr>
                        <th>Slno.</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Quantity</th>
                    </tr>
                    <?php
                        if(isset($_SESSION['id'])){
                            $user_id=$_SESSION['id'];
                            $sql="SELECT * FROM cart WHERE user_id='".$user_id."'";
                            $query=mysqli_query($conn,$sql);
                            if(mysqli_num_rows($query)>0){
                                $slno=0;
                                $final_amount=0;
                                while($row=mysqli_fetch_array($query)){
                                    $f_image=$row['f_image'];
                                    $f_name=$row['f_name'];
                                    $f_price=$row['f_price'];
                                    $f_qty=$row['f_qty'];
                                    $t_price=$row['t_price'];
                                    $price_array=array($t_price);
                                    $price_sum=array_sum($price_array);
                                    $final_amount+=$price_sum;
                                    $slno++;

                                    echo"<tr>
                                            <td>$slno</td>
                                            <td><img src='fooditemimages/$f_image'></td>
                                            <td>$f_name</td>
                                            <td>₹ $f_price for one</td>
                                            <td>$f_qty</td>
                                        </tr>";
                                    
                                }
                            }
                        }
                    ?>
                </table>
            </div>
            <?php
                if(isset($_SESSION['id'])){
                    $id=$_SESSION['id'];
                    $sql="SELECT * FROM users WHERE uid='".$id."'";
                    $query=mysqli_query($conn,$sql);

                    $row=mysqli_fetch_array($query);

                    $f_name=$row['f_name'];
                    $l_name=$row['l_name'];
                    $email=$row['email'];
                    $address=$row['address'];
                    $mobile=$row['mobile'];

                    echo"<div class='userdetails'>
                            <p>Name : $f_name $l_name </p>
                            <p>Email : $email</p>
                            <p>Phone no : $mobile</p>
                            <p>Address : $address</p>
                        </div>";
                }
            ?>
            
            <div class="paymentdiv">
                <div class="pricediv">
                <p>Total amount</p>
                <p>₹ <?php echo"$final_amount"; ?></p>
                </div>
               
                <div class="btndiv">
                    <a href="cod.php" class="btn">COD</a>
                    <a href="paytm.php" class="btn">Pay by Paytm</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>