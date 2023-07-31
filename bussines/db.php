<?php
  $dbhost = "localhost";
  $dbuser = "u247778544_root";
  $dbpass = "N5l[*juS";
  $db = "u247778544_foodie";
  $conn = mysqli_connect($dbhost, $dbuser, $dbpass,$db);

//   if(!$conn){
//       echo "connecton faild";
//   }else{
//       echo "connection succesful";
//   }
?>
 <script src="js/jquery.js"></script>
 <script>
   if ('serviceWorker' in navigator) {
            navigator.serviceWorker.register('/sw.js', {
                scope: '.' // <--- THIS BIT IS REQUIRED
            }).then(function(registration) {
                // Registration was successful
                console.log('ServiceWorker registration successful with scope: ', registration.scope);
            }, function(err) {
                // registration failed :(
                console.log('ServiceWorker registration failed: ', err);
            });
        }
 </script>