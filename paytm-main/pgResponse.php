<?php
header("Pragma: no-cache");
header("Cache-Control: no-cache");
header("Expires: 0");

include("../db.php");

// following files need to be included
require_once("./lib/config_paytm.php");
require_once("./lib/encdec_paytm.php");

$paytmChecksum = "";
$paramList = array();
$isValidChecksum = "FALSE";

$paramList = $_POST;
$paytmChecksum = isset($_POST["CHECKSUMHASH"]) ? $_POST["CHECKSUMHASH"] : ""; //Sent by Paytm pg

//Verify all parameters received from Paytm pg to your application. Like MID received from paytm pg is same as your application�s MID, TXN_AMOUNT and ORDER_ID are same as what was sent by you to Paytm PG for initiating transaction etc.
$isValidChecksum = verifychecksum_e($paramList, PAYTM_MERCHANT_KEY, $paytmChecksum); //will return TRUE or FALSE string.


if($isValidChecksum == "TRUE") {
	echo "<b>Checksum matched and following are the transaction details:</b>" . "<br/>";
	if ($_POST["STATUS"] == "TXN_SUCCESS") {
		echo "<b>Transaction status is success</b>" . "<br/>";
		//Process your transaction here as success transaction.
		//Verify amount & order id received from Payment gateway with your application's order id and amount.
	}
	else {
		echo "<b>Transaction status is failure</b>" . "<br/>";
	}

	if (isset($_POST) && count($_POST)>0 )
	{ 
		foreach($_POST as $paramName => $paramValue) {
				echo "<br/>" . $paramName . " = " . $paramValue;
		}
	}
	if(isset($_POST['ORDERID'])){
		$order_id=$_POST['ORDERID'];
		$sql="UPDATE user_orders SET payment_status='Done' WHERE order_id='".$order_id."'";
		$query=mysqli_query($conn,$sql);

		if($query){
			$sql="SELECT * FROM user_orders WHERE order_id='".$order_id."' AND payment_status='Done'";
                $query=mysqli_query($conn,$sql);
                if(mysqli_num_rows($query)>0){
                    $final_amount=0;
                    while($row=mysqli_fetch_array($query)){
                        $order_date=$row['order_date'];
                        $emp_id=$row['emp_id'];
                        $bill_no=$row['bill_no'];
                        $order_id=$row['order_id'];
                        $t_price=$row['t_price'];
						$user_id=$row['user_id'];
                        $price_array=array($t_price);
                        $price_sum=array_sum($price_array);
                        $final_amount+=$price_sum;

                    }

                    
                    $sql="SELECT * FROM restaurant WHERE emp_id='".$emp_id."'";
                    $query1=mysqli_query($conn,$sql);


                    $row1=mysqli_fetch_array($query1);

                    $r_address=preg_replace('/\s+/', '', $row1['r_address']);

					$sql="SELECT * FROM users WHERE uid='".$user_id."'";
					$query2=mysqli_query($conn,$sql);

					$row2=mysqli_fetch_array($query2);

					$email=$row2['email'];

                    $to_email = $email;
                    $subject = "Payment successful";
                    $body = "Online payment through paytm is successfully completed. Soon your order will be delivered.
Total amount : $final_amount, 
Order id : $order_id,
Order date : $order_date and  
Bill no is : $bill_no
Check the restaurant from you ordered the food here https://www.google.com/maps/search/$r_address
Thank for ordering through Foodie";
                    $headers = "From: foodie";
            
                    
                    if (mail($to_email, $subject, $body, $headers)) {
                        $sql="UPDATE user_orders SET email='send' WHERE user_id='".$user_id."'";
                        $query=mysqli_query($conn,$sql);
                        if($query){
							$success="<div class='notification' id='notificationDiv'><div class='success'><p>Item ordered successfully check your email for more details.</p></div> </div>";
                            header("Location:/foodie/loggedin.php?success=$success");
                        }
                    }
				}
		}
		
	}else{
		echo "wrong";
	}
	

}
else {
	echo "<b>Checksum mismatched.</b>";
	//Process transaction as suspicious.
}

?>