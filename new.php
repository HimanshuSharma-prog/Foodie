<?php

    // include("db.php");
    // $sql="SELECT count(id) AS id FROM user_orders WHERE user_id='8' AND payment_status='Done'";
    // $query=mysqli_query($conn,$sql);
    // $values=mysqli_fetch_array($query);
    // $num_rows=$values['id'];
    // echo"$num_rows";
    date_default_timezone_set('Asia/Kolkata'); 
    $time=date("h:i:s");
    echo "$time";
?>
<?php

// $text = "Bonjour, comment allez vous ?";
// // Yes French is a beautiful language.
// $lang = "fr";

// // MP3 filename generated using MD5 hash
// // Added things to prevent bug if you want same sentence in two different languages
// $file = md5($lang."?".urlencode($text));

// // Save MP3 file in folder with .mp3 extension 
// $file = "audio/" . $file . ".mp3";


// // Check folder exists, if not create it, else verify CHMOD
// if (!is_dir("audio/"))
//     mkdir("audio/");
// else
//     if (substr(sprintf('%o', fileperms('audio/')), -4) != "0777")
//         chmod("audio/", 0777);


// // If MP3 file exists do not create new request
// if (!file_exists($file))
// {
//     // Download content
//     $mp3 = file_get_contents(
//     'http://translate.google.com/translate_tts?ie=UTF-8&q='. urlencode($text) .'&tl='. $lang .'&total=1&idx=0&textlen=5&prev=input');
//     file_put_contents($file, $mp3);
// }

?>