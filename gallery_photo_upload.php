<?php
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

	require_once "fnc_photo_upload.php";

//kontrollin pildi valikut
$file_type = null;
$photo_error = null;
$photo_file_size_limit = 1.5 * 1024 * 1024;
$photo_name_prefix = "vp_";
$file_name = null;
$normal_photo_max_w = 800;
$normal_photo_max_h = 450;

	//kontrollin pildi valikut
if($_SERVER["REQUEST_METHOD"] == "POST"){
	if(isset($_POST["photo_submit"])){
		//var_dump($_FILES["photo_input"]);
		//kas on pildifail ja mis tüüpi
		if(isset($_FILES["photo_input"]["tmp_name"]) and !empty($_FILES["photo_input"]["tmp_name"])){
			$file_type = check_file_type($_FILES["photo_input"]["tmp_name"]);
			if ($file_type == 0){
				$photo_error = "Valitud fail pole sobivat tüüpi!";
			}
		} else {
			$photo_error = "Pildifail on valimata!";
		}

		//faili suurus
		if(empty($photo_error)){
			if($_FILES["photo_input"]["size"] > $photo_file_size_limit){
				$photo_error = "Valitud fail on liiga suur!";
			}
		}

		if(empty($photo_error)){

			//loon uue failinime
			$file_name = create_filename($photo_name_prefix, $file_type);

			//teen normaalmõõdus pildi
			//loome pikslikogumi ehk image objekti
			$temp_photo = create_image($_FILES["photo_input"]["tmp_name"], $file_type);
			//teeme väiksemaks
			$normal_photo = resize_photo($temp_photo, $normal_photo_max_w, $normal_photo_max_h);
			//salvestame väiksemaks tehtud pildi
			save_photo($normal_photo, "photo_upload_normal/" .$file_name, $file_type);

			//tõstan ajutise pildifaili oma soovitud kohta
			//move_uploaded_file($_FILES["photo_input"]["tmp_name"], "photo_upload_original/" .$_FILES["photo_input"]["name"]);
			move_uploaded_file($_FILES["photo_input"]["tmp_name"], "photo_upload_original/" .$file_name);
		}//if empty error
	}//if photo_submit
} //if POST

	require_once "header.php";

	echo "<p>Sisse loginud: " .$_SESSION["firstname"] ." " .$_SESSION["lastname"] .".</p> \n";
?>

	<ul>
		<li><a href="?logout=1">Logi välja</a></li>
		<li><a href="home.php">Tagasi avalehele</a></li>
	</ul>

	<hr>
	<h2>Fotode galeriise laadimine</h2>

	<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data">
		<label for="photo_input">Vali pildifail: </label>
		<input type="file" name="photo_input" id="photo_input">
		<br>
		<label for="alt_input">Alternatiivtekst (alt): </label>
		<input type="text" name="alt_input" id="alt_input" placeholder="Alternatiivtekst...">
		<br>
		<input type="radio" name="privacy_input_1" id="privacy_input_1" value="1">
		<label for="privacy_input">Privaatine (ainult ise näen)</label>
		<br>
		<input type="radio" name="privacy_input_2" id="privacy_input_2" value="2">
		<label for="privacy_input">Sisselogitud kasutajatele</label>
		<br>
		<input type="radio" name="privacy_input_3" id="privacy_input_3" value="3">
		<label for="privacy_input">Avalik (kõik näevad)</label>
		<input type="submit" name="photo_submit" id="photo_submit" value="Lae üles">
		<span><?php echo $photo_error; ?></span>
	</form>

<?php require_once "footer.php"; ?>
