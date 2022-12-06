<?php
  require_once "../../../config.php";

//registreerime peole
  if(isset($_POST["user_data_submit"]) and !empty($_POST["user_data_submit"])){
  		$notice = 0;
  		$conn = new mysqli($GLOBALS["server_host"], $GLOBALS["server_user_name"], $GLOBALS["server_password"], $GLOBALS["database"]);
  		$conn->set_charset("utf8");
      $stmt = $conn->prepare("INSERT INTO kasutaja_registreerimine (kood, eesnimi, perekonnanimi) VALUES(?,?,?)");
  		echo $conn->error;
      $stmt->bind_param("sss", $_POST["kood"], $_POST["first_name_input"], $_POST["last_name_input"]);
  		if($stmt->execute()){
  			$notice = "Oled registreeritud!";
      } else {
        $notice = "Registreerimine ebaõnnestus! :(";
      }
      echo $stmt->error;
  		$stmt->close();
  		$conn->close();

  }

//pärime palju on peole registreeritud
      $id_count = 0;
      $conn = new mysqli($GLOBALS["server_host"], $GLOBALS["server_user_name"], $GLOBALS["server_password"], $GLOBALS["database"]);
      $conn->set_charset("utf8");
      $stmt = $conn->prepare("SELECT COUNT(id) FROM kasutaja_registreerimine WHERE tuhistanud IS NULL");
      echo $conn->error;
      $stmt->bind_result($count_from_db);
      $stmt->execute();
      if($stmt->fetch()){
          $id_count = $count_from_db;
      }
      echo $stmt->error;
      $stmt->close();
      $conn->close();

      $maksnud_count = 0;
      $conn = new mysqli($GLOBALS["server_host"], $GLOBALS["server_user_name"], $GLOBALS["server_password"], $GLOBALS["database"]);
      $conn->set_charset("utf8");
      $stmt = $conn->prepare("SELECT COUNT(maksnud) FROM kasutaja_registreerimine WHERE tuhistanud IS NULL");
      echo $conn->error;
      $stmt->bind_result($maksnud_from_db);
      $stmt->execute();
      if($stmt->fetch()){
          $maksnud_count = $maksnud_from_db;
      }
      echo $stmt->error;
      $stmt->close();
      $conn->close();

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Registreerimine</title>
  </head>
  <body>
    <form method="POST">
      <label for="first_name_input">Eesnimi:</label><br>
      <input name="first_name_input" id="first_name_input" type="text"><br>
      <label for="last_name_input">Perekonnanimi:</label><br>
      <input name="last_name_input" id="last_name_input" type="text"><br>
      <label for="kood">Üliõpilaskood:</label><br>
      <input type="text" name="kood" id="kood"><br>
      <input type="submit" name="user_data_submit" value="Registreeri peole"><br>
    </form>
    <hr>
    <a href="tavakasutaja_kustutamine.php">Tühista osavõtt</a>

    <h2>Registreerinud on: <?php echo $id_count; ?></h2>
    <h2>Maksnud on: <?php echo $maksnud_count; ?></h2>

<?php
  if(isset($notice)){
    echo $notice;
  }
?>
  </body>
</html>
