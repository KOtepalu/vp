<?php
require_once "../../config.php";

$file_html = null;

$conn = new mysqli($GLOBALS["server_host"], $GLOBALS["server_user_name"], $GLOBALS["server_password"], $GLOBALS["database"]);
$conn->set_charset("utf8");
$stmt = $conn->prepare("SELECT filename, alttext FROM vp_photos WHERE privacy >= ? AND deleted IS NULL");
$stmt->bind_param("i", $privacy);
$stmt->bind_result($filename_from_db, $alttext_from_db);
$stmt->execute();

while($stmt->fetch()){
    $file_html .= '<img src="' ."photo_photo_upload_original/" .$filename_from_db .'"alt="';
  if(empty($alttext_from_db)){
    $file_html .= "Üleslaetud foto";
  } else {
    $file_html .= $alttext_from_db;
  }
  $file_html .= '">' ."\n";
  $file_html .= "<p>Ülesse laadis: " .$firstname_from_db ." " .$lastname_from_db ."</p> \n";
}

echo $conn->error;
echo $stmt->error;
$stmt->close();
$conn->close();

require_once "header.php";
?>

<ul>
  <li><a href="?logout=1">Logi välja</a></li>
  <li><a href="home.php">Tagasi avalehele</a></li>
</ul>
<?php echo $file_html; ?>
<?php require_once "footer.php"; ?>
