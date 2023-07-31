
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php
if(isset($_POST['txt'])){
  $txt=$_POST['txt'];
  $txt=htmlspecialchars($txt);
  $txt=rawurlencode($txt);
  $audio=file_get_contents('https://translate.google.com/translate_tts?ie=UTF-8&client=gtx&q='.$txt.'&tl=en-IN');
  $speech="<audio controls='controls' autoplay><source src='data:audio/mpeg;base64,".base64_encode($audio)."'</audio>";
  echo "$speech";
}

?>
<form method="post" action="index.php">
<input id="txt" name="txt" type="textbox" />
<input name="submit" type="submit" value="Convert to Speech" />
</form>

</body>
</html>