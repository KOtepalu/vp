<?php
	require_once "../config.php";

	//loome andmebaasiühenduse
	$conn = new mysqli($server_host, $server_user_name, $server_password, $database);
	//määrame suhtlemisel kasutatava kooditabeli
	$conn->set_charset("utf8");
	//valmistame ette SQL keeles päringu
	$stmt = $conn->prepare("SELECT comment, grade, added FROM vp_daycomment");
	echo $conn->error;
	//seome loetavad andmed muutujatega
	$stmt->bind_result($comment_from_db, $grade_from_db, $added_from_db);
	//täidame käsu
	$stmt->execute();
	echo $stmt->error;
	//võtan andmed
	//kui on oodata vaid 1 võimalik kirje
	//if($stmt->fetch()){
			//kõik mida teha
	//}
	$comments_html = null;
	//kui on oodata mitut, aga teadmata arv
	while($stmt->fetch()){
		// <p>Kommentaar, hinne päevale: x, lisatud yyyy.</p>
		$comments_html .= "<p>" .$comment_from_db .", hinne päevale:" .$grade_from_db ."lisatud" .$added_from_db .".</p> \n";
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
	<?php echo $comments_html; ?>
</body>

</html>