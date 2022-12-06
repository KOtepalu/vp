<?php
require_once "../../../config.php";

if(isset($_POST["user_delete"]) and !empty($_POST["user_delete"])){
    $notice = 0;
    $conn = new mysqli($GLOBALS["server_host"], $GLOBALS["server_user_name"], $GLOBALS["server_password"], $GLOBALS["database"]);
    $conn->set_charset("utf8");
    $stmt = $conn->prepare("SELECT id FROM kasutaja_registreerimine WHERE kood = ?");
    echo $conn->error;
    $stmt->bind_param("s", $_POST["user_code"]);
    $stmt->bind_result($id_from_db);
    $stmt->execute();
    echo $stmt->error;
    //kontrollime kas muutja user id ja sessiooni user id on sama, siis võib kustutada
    if($stmt->fetch()){
        $stmt->prepare("UPDATE kasutaja_registreerimine SET tuhistanud = now() WHERE id = ?");
        $stmt->bind_param("i", $id_from_db);
        $stmt->execute();
        $stmt->close();
        $conn->close();
        $notice = "Olete nimekirjast kustutatud!";
    } else {
      $notice = "Kustutamine ebaõnnestus!";
    }
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Kasutaja kustutamine</title>
  </head>
  <body>
<form method="POST">
<input type="hidden" name="user_edit_input">
<input type="text" name="user_code" placeholder="Õpilaskood">
<input type="submit" name="user_delete" value="Kustuta">
</form>

<?php
  if(isset($notice)){
    echo $notice;
  }
?>
  </body>
</html>
