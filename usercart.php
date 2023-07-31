<!-----------------------------------------------------------cart div-------------------------------------------------->

<div class="cartcontainer" id="cartContainer">

<div class="closediv">
    <p><i class='bx bx-cart-alt' ></i> Cart</p>
    <div class="cartclosebtn" id="cartCloseBtn">
        <i class='bx bx-exit' ></i>
    </div>
</div>

<div class="cartdivcontainer">

    <?php
        include("db.php");
        if(isset($_SESSION['id'])){
            $user_id=$_SESSION['id'];
            $sql="SELECT * FROM cart WHERE user_id='".$user_id."'";
            $query=mysqli_query($conn,$sql);

            if(mysqli_num_rows($query)>0){
                while($row=mysqli_fetch_array($query)){
                    $f_name=$row['f_name'];
                    $t_price=$row['t_price'];
                    $f_qty=$row['f_qty'];
                    $f_image=$row['f_image'];
                    $remove_id=$row['id'];
                    $f_id=$row['f_id'];

                    echo"<div class='cartdiv'>
                    <div class='itemimg'>
                        <img src='fooditemimages/$f_image'>
                    </div>
                    <div class='details'>
                        <div class='itemname'>
                            <div class='title'>
                                <p>$f_name</p>
                            </div>
                            <div class='price'>
                                <p><i class='fa fa-inr'></i> $t_price</p>
                            </div>
                        </div>
                        <div class='qtydiv'>
                            <div class='qty'>
                                <input type='number' name='qty' id='qty-$remove_id' class='qtyBtn' value='$f_qty' min='0' max='10' update_id='$remove_id' f_id='$f_id'>
                            </div>
                            <div class='remove'>
                                <a href='cart.php?remove_id=$remove_id'><i class='bx bxs-trash-alt'></i></a>
                            </div>
                        </div>
                    </div>
                   
                </div>";
                }
            }else{
                echo"<div class='noitemdiv'>
                    <img src='images/alone.png'>
                    <p>No food item is available in your cart.</p>
                </div>";
            }
        }
        if(isset($_POST['update_id'])){
            $update_id=$_POST['update_id'];
            $f_qty=$_POST['qty'];
            $sql="SELECT * FROM cart WHERE id='".$update_id."'";
            $query=mysqli_query($conn,$sql);
    
            if(mysqli_num_rows($query)==1){
                $row=mysqli_fetch_array($query);
                $f_price=$row['f_price'];
                $f_id=$row['f_id'];
                $t_price=$f_qty*$f_price;
    
                $sql="UPDATE cart SET f_qty='$f_qty',t_price='$t_price' WHERE id='$update_id'";
                $query=mysqli_query($conn,$sql);
    
                if($query){
                    $success="<div class='notification' id='notificationDiv'><div class='success'><p>cart updated successfully..</p></div> </div>";
                    header("refresh:2;url=index.php");
                }else{
                    $error="<div class='notification' id='notificationDiv'><div class='error'><p>Something went wrong</p></div> </div>";
                    header("Location:item.php?f_id=$f_id&error=$error");
                }
    
            }else{
                $error="<div class='notification' id='notificationDiv'><div class='error'><p>Something went wrong, try after soem time1.</p></div> </div>";
                header("Location:item.php?f_id=$f_id&error=$error");
            }
        }
    ?>

    <!-- <div class="cartdiv">
        <div class="itemimg">
            <img src="images/pizaa/p2.jpg">
        </div>
        <div class="details">
            <div class="itemname">
                <div class="title">
                    <p>Panner Pizza</p>
                </div>
                <div class="price">
                    <p><i class="fa fa-inr"></i> 120</p>
                </div>
            </div>
            <div class="qtydiv">
                <div class="qty">
                    <input type="number" name="qty" class="qtyBtn" value="1" min="0" max="10">
                </div>
                <div class="remove">
                    <a href="#"><i class='bx bxs-trash-alt'></i></a>
                </div>
            </div>
        </div>
       
    </div> -->


</div>
<?php
    if(isset($_SESSION['id'])){
        $user_id=$_SESSION['id'];
        $sql="SELECT * FROM cart WHERE user_id='".$user_id."'";
        $query=mysqli_query($conn,$sql);

        if(mysqli_num_rows($query)>0){
            $total_price=0;
            while($row=mysqli_fetch_array($query)){
                $t_price=$row['t_price'];
                $price_array=array($t_price);
                $price_sum=array_sum($price_array);
                $total_price+=$price_sum;
                
            }
            echo"<div class='checkoutdiv'>
                <p>Total</p>
                <div class='totalamt'>
                    <p><i class='fa fa-inr'></i></p>
                    <input type='text' name='totalamt' value='$total_price' disabled>
                </div>
                <a href='checkout.php' class='checkoutbtn'><i class='bx bx-check-double' ></i> Order Now</a>
            </div>";
        }
    }
?>


</div>
