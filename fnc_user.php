<?php
  require_once "../../config.php";

  function sign_in($email, $password){
		$login_error = null;
		//globaalseid muutujaid hoitakse massiivis $GLOBALS
		$conn = new mysqli($GLOBALS["server_host"], $GLOBALS["server_user_name"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$conn->set_charset("utf8");
		$stmt = $conn->prepare("SELECT password FROM vp_users WHERE email = ?");
        echo $conn->error;
        $stmt->bind_param("s", $email);
        $stmt->bind_result($password_from_db);
        $stmt->execute();
        if($stmt->fetch()){
            //kasutaja on olemas, parool tuli ...
            if(password_verify($password, $password_from_db)){
				$stmt->close();
				$stmt = $conn->prepare("SELECT id, firstname, lastname FROM vp_users WHERE email = ?");
				$stmt->bind_param("s", $email);
				$stmt->bind_result($id_from_db, $firstname_from_db, $lastname_from_db);
				$stmt->execute();
				if($stmt->fetch()){
					//parool õige, oleme sees!
					//määran sessioonimuutujad
					$_SESSION["user_id"] = $id_from_db;
					$_SESSION["firstname"] = $firstname_from_db;
					$_SESSION["lastname"] = $lastname_from_db;

          //määrame värvid
          $_SESSION["user_bg_color"] = "#DDDDDD";
          $_SESSION["user_txt_color"] = "#000099";
          //värvide profiilist lugemine, kui on, tulevad uued väärtused. kui pole, jäävad need, mis otse kirjas.
          $stmt->close();
          $stmt = $conn->prepare("SELECT id FROM vp_userprofiles WHERE userid = ?");
          echo $conn->error;
          $stmt->bind_param("s", $_SESSION["user_id"]);
          $stmt->execute();
          if($stmt->fetch()){
            $stmt->close();
            $stmt = $conn->prepare("SELECT bgcolor, txtcolor FROM vp_userprofiles WHERE userid = ?");
            echo $conn->error;
            $stmt->bind_param("s", $_SESSION["user_id"]);
            $stmt->bind_result($userbgc, $usertxtc);
            $stmt->execute();
            if($stmt->fetch()){
              $_SESSION["user_bg_color"] = $userbgc;
              $_SESSION["user_txt_color"] = $usertxtc;
            }
            echo $stmt->error;
          }

          $stmt->close();
					$conn->close();
					header("Location: home.php");
					exit();
				} else {
					$login_error = "Sisselogimisel tekkis tõrge!";
				}
            } else {
                $login_error = "Kasutajatunnus või salasõna oli vale!";
            }
        } else {
            $login_error = "Kasutajatunnus või salasõna oli vale!";
        }

        $stmt->close();
        $conn->close();

		return $login_error;
	}

	function sign_up($first_name, $last_name, $birth_date, $gender, $email, $password){
		$notice = 0;
		$conn = new mysqli($GLOBALS["server_host"], $GLOBALS["server_user_name"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$conn->set_charset("utf8");
		$stmt = $conn->prepare("SELECT id FROM vp_users WHERE email = ?");
		echo $conn->error;
		$stmt->bind_param("s", $email);
		$stmt->bind_result($id_from_db);
		$stmt->execute();
		if($stmt->fetch()){
			$notice = 2;
		} else {
			$stmt->close();
			$stmt = $conn->prepare("INSERT INTO vp_users (firstname, lastname, birthdate, gender, email, password) VALUES(?,?,?,?,?,?)");
			echo $conn->error;
			//krüpteerime salasõna
			$pwd_hash = password_hash($password, PASSWORD_DEFAULT);
			$stmt->bind_param("sssiss", $first_name, $last_name, $birth_date, $gender, $email, $pwd_hash);
			if($stmt->execute()){
				$notice = 1;
			} else {
				$notice = 3;
			}
		}
		//echo $stmt->error;
		$stmt->close();
		$conn->close();
		return $notice;
	}

  function profile_colors($description, $bgcolor, $txtcolor){
    $conn = new mysqli($GLOBALS["server_host"], $GLOBALS["server_user_name"], $GLOBALS["server_password"], $GLOBALS["database"]);
    $conn->set_charset("utf8");
    $stmt = $conn->prepare("SELECT id FROM vp_userprofiles WHERE userid = ?");
    echo $conn->error;
    $stmt->bind_param("s", $_SESSION["user_id"]);
    $stmt->bind_result($id_from_db);
    $stmt->execute();
    if($stmt->fetch()){
      $stmt->close();
      $stmt = $conn->prepare("UPDATE vp_userprofiles SET description = ?, bgcolor = ?, txtcolor = ? WHERE userid = ?");
      echo $conn->error;
      $stmt->bind_param("sssi", $description, $bgcolor, $txtcolor, $_SESSION["user_id"]);
      $stmt->execute();
      echo $stmt->error;
    } else {
      $stmt->close();
      $stmt = $conn->prepare("INSERT INTO vp_userprofiles (userid, description, bgcolor, txtcolor) VALUES(?,?,?,?)");
      echo $conn->error;
      $stmt->bind_param("isss", $_SESSION["user_id"], $description, $bgcolor, $txtcolor);
      $stmt->execute();

    echo $stmt->error;
    $stmt->close();
    $conn->close();
    }
  }

 /*function read_colors($userid, $bgcolor, $txtcolor){
    $conn = new mysqli($GLOBALS["server_host"], $GLOBALS["server_user_name"], $GLOBALS["server_password"], $GLOBALS["database"]);
    $conn->set_charset("utf8");
    $stmt = $conn->prepare("SELECT id FROM vp_userprofiles WHERE userid = ?");
    echo $conn->error;
    $stmt->bind_param("s", $_SESSION["user_id"]);
    $stmt->execute();
    if($stmt->fetch()){
      $stmt->close();
      $stmt = $conn->prepare("SELECT bgcolor, txtcolor FROM vp_userprofiles WHERE userid = ?");
      echo $conn->error;
      $stmt->bind_param("s", $_SESSION["user_id"]);
      $stmt->bind_result($_SESSION["user_bg_color"], $_SESSION["user_txt_color"]);
      $stmt->execute();
      echo $stmt->error;
      $stmt->close();
      $conn->close();
    }
  }
*/
