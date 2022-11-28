<?php
require_once "../../config.php";

//session_start();
	//loen sisse konfiguratsioonifailid
require_once "classes/SessionManager.class.php";
SessionManager::sessionStart("vp", 0, "~otepkarl/vp", "greeny.cs.tlu.ee");
	require_once "fnc_user.php";
	if(!isset($_SESSION["user_id"])){
		//jõuga viiakse page.php
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

//loome andmebaasiühenduse
$conn = new mysqli($server_host, $server_user_name, $server_password, $database);
//määrame suhtlemisel kasutatava kooditabeli
$conn->set_charset("utf8");
//valmistame ette SQL keeles päringu
$stmt = $conn->prepare("SELECT pealkiri, aasta, kestus, zanr, tootja, lavastaja FROM film");
echo $conn->error;
//seome loetavad andmed muutujatega
$stmt->bind_result($pealkiri_film, $aasta_film, $kestus_film, $zanr_film, $tootja_film, $lavastaja_film);
//täidame käsu
$stmt->execute();
echo $stmt->error;

$film_html = null;
//kui on oodata mitut, aga teadmata arv
while($stmt->fetch()){
  // <p>Kommentaar, hinne päevale: x, lisatud yyyy.</p>
  $film_html .= "<h3>" .$pealkiri_film ."</h3>"
  ."<ul>"
  ."<li>Valmimisaasta: " .$aasta_film ."</li>"
	."<li>Kestus: " .$kestus_film ."</li>"
  ."<li>Žanr: " .$zanr_film ."</li>"
	."<li>Tootja: " .$tootja_film ."</li>"
	."<li>Lavastaja: " .$lavastaja_film ."</li>"
  ."</ul>";
}
//sulgeme käsu/päringu
$stmt->close();
//sulgeme andmebaasiühenduse
$conn->close();
?>

    <?php echo $film_html; ?>
</body>

</html>
