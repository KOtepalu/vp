<?php

	//loen sisse konfiguratsioonifaili
	require_once "../config.php";

	$author_name = "Karl Otepalu";
	//echo $author_name;
	$full_time_now = date("d.m.Y H:i:s");
	$weekday_names_et = ["esmaspäev", "teisipäev", "kolmapäev", "neljapäev", "reede", "laupäev", "pühapäev"];
	//echo $weekday_names_et[1];
	$weekday_now = date("N");
	$hour_now = date("H");
	$part_of_day = "suvaline hetk";
	// 	== on võrdne		!= pole võrdne	<	 >  <=  >=
	if($weekday_now < 5){
		if($hour_now < 7){
			$part_of_day = "uneaeg";
		}
	// 	and &		or |
		if($hour_now >= 8 and $hour_now < 18){
			$part_of_day = "koolipäev";
		}
		if($hour_now >= 18 and $hour_now < 19){
			$part_of_day = "trenn";
		}
		if($hour_now >= 19 and $hour_now < 20){
			$part_of_day = "õhtusöök";
		}
		if($hour_now >= 20 and $hour_now < 23){
			$part_of_day = "õhtused toimetused";
		}
		if($hour_now >= 23){
			$part_of_day = "uneaeg";
		}
	}

	if($weekday_now == 5){
		if($hour_now < 9){
			$part_of_day = "uneaeg";
		}
		if($hour_now >= 9 and $hour_now < 10){
			$part_of_day = "hommikusöök";
		}
		if($hour_now >= 10 and $hour_now < 12){
			$part_of_day = "koeraga jalutamine";
		}
		if($hour_now >=12 and $hour_now < 17){
			$part_of_day = "kodused toimetused";
		}
		if($hour_now >=17 and $hour_now < 18){
			$part_of_day = "kodutööd";
		}
		if($hour_now >=18 and $hour_now < 21){
			$part_of_day = "tühja panemine";
		}
		if($hour_now >=21 and $hour_now < 23){
			$part_of_day = "filmi vaatamine";
		}
		if($hour_now >= 23){
			$part_of_day = "uneaeg";
		}
	}

	if($weekday_now == 6){
		if($hour_now < 9){
			$part_of_day = "uneaeg";
		}
		if($hour_now >= 9 and $hour_now < 10){
			$part_of_day = "kommikusöök";
		}
		if($hour_now >= 10 and $hour_now < 12){
			$part_of_day = "koeraga jalutamine";
		}
		if($hour_now >=12 and $hour_now < 14){
			$part_of_day = "trenn";
		}
		if($hour_now >=14 and $hour_now < 15){
			$part_of_day = "puhkan";
		}
		if($hour_now >=15 and $hour_now < 19){
			$part_of_day = "perega aeg";
		}
		if($hour_now >=19 and $hour_now < 23){
			$part_of_day = "vaba aeg";
		}
		if($hour_now >= 23){
			$part_of_day = "uneaeg";
		}
	}

	//vaatame semestri pikkust ja kulgemist
	$semester_begin = new DateTime("2022-09-05");
	$semester_end = new DateTime("2022-12-18");
	$semester_duration = $semester_begin->diff($semester_end);
	$semester_duration_days = $semester_duration->format("%r%a");
	//echo $semester_duration_days;
	$from_semester_begin = $semester_begin->diff(new Datetime("now"));
	$from_semester_begin_days = $from_semester_begin->format("%r%a");

	$old_saying = ["Aeg küpsetab asju.", "Igaüks teab ise, mis ta teeb ja mis ta sööb.", "Keelatud vili on magus.", "Kes kassi kallistab, selle õue õnnistab.", "Mida varem, seda parem.", "Naine mehe nõu, kübar mehe au.", "Oma tuba, oma luba.", "Rahaahnus on kõige kurja juur."];
	//loendan massiivi (array) liikmeid
	//echo count($weekday_names_et);

	//juhuslik arv
	//echo mt_rand(1, 9);

	//juhuslik element massiivist
	//echo $weekday_names_et[mt_rand(0, count($weekday_names_et) - 1)];

	//loeme photos kataloogi sisu
	$photo_dir = "photos/";
	//$all_files = scandir($photo_dir);
	//uus_massiiv = array_slice(massiiv, mis kohast alates);
	$all_files = array_slice(scandir($photo_dir),2);
	//var_dump($all_files);

	// <img src="katalog/fail" alt="text">
	$photo_html = null;

	//tsükkel
	//muutuja väärtuse suurendamine: $muutuja = $muutuja + 5
	//$muutuja += 5
	//kui suureneb 1 võrra $muutuja ++
	//on ka -= --
	/*for ($i=0; $i < count($all_files); $i++) {
		echo $all_files[$i] . "\n";
	}*/
	/*foreach ($all_files as $file_name) {
		echo $file_name . " | ";
	}*/

	//loetlen lubatud failitüübid (nt jpg ja png)
	// MIME tüübid (nt "image/jpeg" ja "image/png")
	$allowed_photo_types = ["image/jpeg", "image/png"];
	$photo_files = [];
	foreach ($all_files as $file_name) {
			$file_info = getimagesize($photo_dir .$file_name);
			if(isset($file_info["mime"])) {
					if(in_array($file_info["mime"], $allowed_photo_types)) {
							array_push($photo_files, $file_name);
					}
			}
	}
	//var_dump($photo_files);
	$photo_number = mt_rand(0, count($photo_files) - 1);
	$photo_html = '<img src="' .$photo_dir .$photo_files[mt_rand(0, count($photo_files) - 1)] .'" alt="Tallinna pilt">';
	//echo $photo_html;

	//vormi info kasutamine
	// $_POST
	//var_dump($_POST);
	$adjective_html = null;
	if(isset($_POST["todays_adjective_input"]) and !empty($_POST["todays_adjective_input"])){
	$adjective_html = "<p>Tänase kohta on arvatud: " .$_POST["todays_adjective_input"] .".</p>";
}
	//teen fotode ripmenüü
	// <option value="0">tln_1.JPG</option>
	$select_html = '<option value="" selected disabled>Vali pilt</option>';
	for ($i=0; $i < count($photo_files); $i++) {
			$select_html .= '<option value="'  .$i . '">';
			$select_html .= $photo_files[$i];
			$select_html .= "</option> \n";
	}

	if(isset($_POST['photo_submit'])){
    if(!empty($_POST['photo_select'])) {
        $selected = $_POST['photo_select'];
					$select_html ='<option value="" selected disabled> '.$photo_files[$selected] .' </option>';
					for ($i=0; $i < count($photo_files); $i++) {
							$select_html .= '<option value="'  .$i . '">';
							$select_html .= $photo_files[$i];
							$select_html .= "</option> \n";
					}
  		}
	}

	if(isset($_POST["photo_select"]) and $_POST["photo_select"] >= 0){
		//kõik mida teha tahame
		$photo_html = '<img src="' .$photo_dir .$photo_files[$_POST["photo_select"]]. '" alt="Tallinna pilt">';
	}

	$comment_error = null;
	$grade = 7;
	//tegeleme päevale antud hinde ja kommentaariga
	if(isset($_POST["comment_submit"])){
		if(isset($_POST["comment_input"]) and !empty($_POST["comment_input"])){
			$comment = $_POST["comment_input"];
		} else {
			$comment_error = "Kommentaar jäi lisamata!";
		}
		$grade = $_POST["grade_input"];

	if(empty($comment_error)){
		//loome andmebaasiühenduse
		$conn = new mysqli($server_host, $server_user_name, $server_password, $database);
		//määrame suhtlemisel kasutatava kooditabeli
		$conn->set_charset("utf8");
		//valmistame ette SQL keeles päringu
		$stmt = $conn->prepare("INSERT INTO vp_daycomment (comment, grade) VALUES(?,?)");
		echo $conn->error;
		//seome SQL päringu päris andmetega
		//määrata andmetüübid i - integer(täisarv), d - decimel(murdarv), s - string(tekst)
		$stmt->bind_param("si", $comment, $grade);
		if($stmt->execute()){
			$grade = 7;
		}
		echo $stmt->error;
		//sulgeme käsu/päringu
		$stmt->close();
		//sulgeme andmebaasiühenduse
		$conn->close();
		}
	}
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<title><?php echo $author_name; ?>, veebiprogrammeerimine</title>
</head>

<body>
	<img src="pics/vp_banner_gs.png" alt="Veebiprogrammeerimine">
	<h1><?php echo $author_name; ?>, veebiprogrammeerimine</h1>
	<p>See leht on loodud õppetöö raames ja ei sisalda tõsist infot!</p>
	<p>Õppetöö toimus <a href="https://www.tlu.ee">Tallinna Ülikoolis<a/>.</p>
	<p>Lehe avamnise hetk: <?php echo $weekday_names_et[$weekday_now - 1] .", " .$full_time_now; ?>.</p>
	<p>Praegu on <?php echo $part_of_day; ?></p>

	<!--päeva kommentaaride lisamise vorm-->
	<form method="POST">
		<label for="comment_input">Kommentaar tänase päeva kohta:</label>
		<br>
		<textarea id="comment_input" name="comment_input" rows="2" cols="70" placeholder="kommentaar"></textarea>
		<br>
		<label for="grade_input">Hinne tänasele päevale (0 ... 10):</label>
		<input type="number" id="grade_input" name="grade_input" min="0" max="10" step="1" value="<?php echo $grade; ?>">
		<br>
		<input type="submit" id="comment_submit" name="comment_submit" value="Salvesta">
		<span><?php echo $comment_error; ?></span>
	</form>

	<p>Väike tarkusetera: <?php echo $old_saying[mt_rand(0, count($old_saying) - 1)] ?></p>
	<!--Siin on väike omadussõnade vorm-->
	<form method="POST">
		<input type="text" id="todays_adjective_input" name="todays_adjective_input" placeholder="omadussõna tänase kohta">
		<input type="submit" id="todays_adjective_submit" name="todays_adjective_submit" value="Saada omadusõna">
	</form>
	<?php echo $adjective_html; ?>
	<hr>
	<form method="POST">
		<select id="photo_select" name="photo_select">
				<?php echo $select_html; ?>
		</select>
		<input type="submit" id="photo_submit" name="photo_submit" value="OK">
	</form>
	<?php echo $photo_html; ?>
	<hr>
	<p>Semester edeneb: <?php echo $from_semester_begin_days ."/" . $semester_duration_days; ?></p>
	<a href="https://www.tlu.ee">
		<img src="pics/tlu_35.jpg" alt="Tallinna Ülikooli Astra õppehoone">
	</a>
	<p>Olen tegelenud mustkunstiga 7 aastat.</p>
</body>

</html>
