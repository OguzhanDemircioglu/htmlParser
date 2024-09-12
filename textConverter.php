<!DOCTYPE html>
<html>
<head>
  <title>PHP Input Örneği</title>
</head>
<body>

<form method="post" action="">
  <label for="user_input">Bir değer girin:</label>
  <input type="text" id="user_input" name="user_input">
  <input type="submit" value="Gönder">
</form>

<?php
include('rapor.php');
include('newParserHtml.php');

if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "POST") {
  $inputValue = htmlspecialchars($_POST['user_input']);
  if (!empty($inputValue)) {
    $worker = new newParserHtml();
    echo $worker->getRapor($studies);
  } else {
    echo "Lütfen bir değer girin.";
  }
}
?>

</body>
</html>
