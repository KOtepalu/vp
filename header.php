<?php require_once "fnc_user.php"; ?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<title> Karli veebiprogrammeerimine</title>
	<style>
		body{
			background-color: <?php echo $_SESSION["user_bg_color"]; ?>;
			color: <?php echo $_SESSION["user_txt_color"]; ?>;
		}
	</style>
	<?php
	$style_sheets = ["styles/gallery.css"];
		if(isset($style_sheets) and !empty($style_sheets)){
			for($i = 0;$i < count($style_sheets);$i++){
			//<link rel="stylesheet" href="styles/gallery.css">
				echo '<link rel="stylesheet" href="' .$style_sheets[$i] .'">' ."\n";
			}
		}
	?>
</head>

<body>
	<img src="pics/vp_banner_gs.png" alt="Veebiprogrammeerimine">
	<h1>Karl Otepalu, veebiprogrammeerimine</h1>
	<p>See leht on loodud õppetöö raames ja ei sisalda tõsist infot!</p>
  <p>Õppetöö toimus <a href="https://www.tlu.ee">Tallinna Ülikoolis<a/>.</p>
