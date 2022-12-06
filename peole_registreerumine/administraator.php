<?php
require_once "../../../config.php";

$id_count = 0;
$conn = new mysqli($GLOBALS["server_host"], $GLOBALS["server_user_name"], $GLOBALS["server_password"], $GLOBALS["database"]);
$conn->set_charset("utf8");
$stmt = $conn->prepare("SELECT id, kood FROM kasutaja_registreerimine WHERE maksnud is NULL and tuhistanud is NULL");
echo $conn->error;
$stmt->bind_result($id_from_db, $kood_from_db);
$stmt->execute();
$code_html = null;
while($stmt->fetch()){
  $code_html .= '<option value="' .$id_from_db .'">' .$kood_from_db ."</option> \n";
}
echo $stmt->error;
$stmt->close();
$conn->close();

if(isset($_POST["tasumine_submit"]) and !empty($_POST["tasumine_submit"])){
  $conn = new mysqli($GLOBALS["server_host"], $GLOBALS["server_user_name"], $GLOBALS["server_password"], $GLOBALS["database"]);
  $conn->set_charset("utf8");
  $stmt = $conn->prepare("SELECT kood FROM kasutaja_registreerimine WHERE id = ?");
  echo $conn->error;
  $stmt->bind_param("i", $id_from_db);
  $stmt->bind_result($kood_from_db);
  $stmt->execute();
  echo $stmt->error;
  //kontrollime kas muutja user id ja sessiooni user id on sama, siis võib kustutada
  if($stmt->fetch()){
    //$stmt->close();
    $stmt->prepare("UPDATE kasutaja_registreerimine SET maksnud = now() WHERE id = ?");
    $stmt->bind_param("i", $id_from_db);
    $stmt->execute();
    $stmt->close();
    $conn->close();
  }
}

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Administraator</title>
  </head>
  <body>
    <form method="POST">
      <label for="inimene_input"></label>
      <select name="inimene_input" id="inimene_input">
      <?php echo $code_html; ?>
      <input type="submit" name="tasumine_submit" value="makstud">
      </select>
    </form>
  </body>
</html>
