<?php
  require_once "../../config.php";
  require_once "fnc_user.php";

	session_start();
	if(!isset($_SESSION["user_id"])){
		//jõuga viiakse page.php lehele
		header("Location: page.php");
		exit();
	}

	//logime välja
	if(isset($_GET["logout"])){
		session_destroy();
		header("Location: page.php");
		exit();
	}

  if(isset($_POST["color_submit"]) and !empty(isset($_POST["color_submit"]))){
    $description = $_POST["user_description"];
    $bgcolor = $_POST["bg_color_input"];
    $txtcolor = $_POST["txt_color_input"];
    echo profile_colors($description, $bgcolor, $txtcolor);
  }

  require_once "header.php";

	echo "<p>Sisse loginud: " .$_SESSION["firstname"] ." " .$_SESSION["lastname"] .".</p> \n";
  ?>
  <ul>
  	<li><a href="?logout=1">Logi välja</a></li>
  	<li><a href="home.php">Avalehele</a></li>
  </ul>
  <form method="POST">
    <input type="hidden" name="profile_input" id="profile_input" value="<?php echo $_SESSION["user_id"];?>">
    <label for="user_description">Muuda profiili</label>
    <br>
    <p>Vali tausta värv:</p>
    <input type="color" name="bg_color_input" id="bg_color_input">
    <br>
    <p>Vali teksti värv:</p>
    <input type="color" name="txt_color_input" id="txt_color_input">
    <br>
    <br>
    <textarea name="user_description" id="user_description" rows="5" cols="51" placeholder="Minu lühikirjeldus"></textarea>
    <br>
    <input type="submit" id="color_submit" name="color_submit" value="Salvesta">
  </form>
  <br>
  <?php require_once "footer.php"; ?>
