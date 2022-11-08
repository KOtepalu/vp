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
	require_once "header.php";

	echo "<p>Sisse loginud: " .$_SESSION["firstname"] ." " .$_SESSION["lastname"] .".</p> \n";
?>
<ul>
	<li>Logi <a href="?logout=1">välja</a></li>
	<li>Fotode galeriise <a href="gallery_photo_upload.php">lisamine</a></li>
	<br>
	<li><a href="film.php">Siit saad lisada uusi filme</a></li>
	<li><a href="read_film.php">Vaata lisatud filme</a></li>
	<li><a href="read_daycomments.php">Vaata lisatud päevakommentaare</a></li>
	<li><a href="gallery_public.php">Avalike fotode galerii</a></li>
	<li><a href="gallery_own.php">Minu fotode galerii</a></li>
</ul>
<?php require_once "footer.php"; ?>
