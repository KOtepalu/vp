<?php
	//session_start();
	require_once "classes/SessionManager.class.php";
	SessionManager::sessionStart("vp", 0, "~otepkarl/vp", "greeny.cs.tlu.ee");
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

	$last_visitor = "pole teada";

	if(isset($_COOKIE["lastvisitor"]) and !empty($_COOKIE["lastvisitor"])){
		$last_visitor = $_COOKIE["lastvisitor"];
	}

	//salvestan küpsise
	//nimi, väärtus, aegumistähtaeg, veebikataloog, domeen, https kasutamine,
	//https		isset($_SERVER["HTTPS"])
	setcookie("lastvisitor", $_SESSION["firstname"] ." " .$_SESSION["lastname"], time() + (60 * 60 * 24 * 8), "~otepkarl/vp/", "greeny.cs.tlu.ee", true, true);
	//küpsise kustutamine: expire ehk aegumistähtaeg pannakse minevikus:  time() - 3000

	require_once "header.php";
	require_once "fnc_photo_upload.php";

	echo "<p>Sisse loginud: " .$_SESSION["firstname"] ." " .$_SESSION["lastname"] .".</p> \n";

	if($last_visitor != $_SESSION["firstname"] ." " .$_SESSION["lastname"]){
		echo "<p>Viimati oli sisseloginud: " .$last_visitor ."<p> \n";
	}
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
	<li><a href="user_profile.php">Minu profiil</a></li>
</ul>
<?php echo read_pfp(); ?>
<?php require_once "footer.php"; ?>
