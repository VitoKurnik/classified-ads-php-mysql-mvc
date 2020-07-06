<?php
	//include_once "baza.php";

	$conn = new mysqli('localhost', 'root', '', 'vaja2');
    $conn->set_charset("UTF8");
	session_start();

	if(isset($_SESSION["USER"])){
        if((time() - $_SESSION['timeout']) > 1800){
    		header("location:odjava.php");
    	}
    	else{
    		$_SESSION['timeout'] = time();
    	}
    }

	function validate_login($username, $password){
        	global $conn;
        	$username = mysqli_real_escape_string($conn, $username);
        	$pass = sha1($password);
        	$query = "SELECT * FROM user WHERE username='$username' AND password='$pass'";
        	$res = $conn->query($query);
        	if($user_obj = $res->fetch_object()){
        		return $user_obj->id;
        	}
        	return -1;
        }

    function get_user(){
        global $conn;
        $id = validate_login($_POST["username"], $_POST["geslo"]);
        $query = "SELECT * FROM user WHERE id='$id';";
        $res = $conn->query($query);
        $oglasi = array();
        while($oglas = $res->fetch_object()){
            array_push($oglasi, $oglas);
    }
    return $oglasi;
}

	$error = "";
	if(isset($_POST["prijava"])){
        if(($user_id = validate_login($_POST["username"], $_POST["geslo"])) >= 0){
            $_SESSION["USER_ID"] = $user_id;
            $oglas = get_user();
        	$_SESSION["USER"] = $_POST["username"];
        	$_SESSION['timeout'] = time();
            $_SESSION["USER_NAME"] = $oglas[0]->name;
            $_SESSION["USER_SURNAME"] = $oglas[0]->surname;
            $_SESSION["ADMIN"] = $oglas[0]->admin;
        	header("Location: index.php");
        	die();
        } else{
        	$error = "Prijava ni uspela.";
        }
	}

?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>
<body>
	<form action="prijava.php" method="POST">
		Uporabiško ime: <input type="text" name="username" /><br/>
		Geslo: <input type="password" name="geslo" /> <br/>
		<input type="submit" name="prijava" value="prijava" /> <br/>
		<?php
			echo $error;
		?>
	</form>
</body>
</html>
