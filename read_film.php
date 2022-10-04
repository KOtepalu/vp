<?php
require_once "../../config.php";
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
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<title>Karl Otepalu, veebiprogrammeerimine</title>
</head>

<body>
	<img src="pics/vp_banner_gs.png" alt="Veebiprogrammeerimine">
	<h1>Karl Otepalu, veebiprogrammeerimine</h1>
	<p>See leht on loodud õppetöö raames ja ei sisalda tõsist infot!</p>
	<p>Õppetöö toimus <a href="https://www.tlu.ee">Tallinna Ülikoolis<a />.</p>
    <?php echo $film_html; ?>
</body>

</html>
