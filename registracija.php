<?php
	//include_once "baza.php";
	$conn = new mysqli('localhost', 'root', '', 'vaja2');
    $conn->set_charset("UTF8");
	session_start();

    function username_exists($username){
    	global $conn;
    	$username = mysqli_real_escape_string($conn, $username);
    	$query = "SELECT * FROM user WHERE username='$username'";
    	$res = $conn->query($query);
    	return mysqli_num_rows($res) > 0;
    }

    function register_user($username, $password, $email, $name, $surname, $address, $mail, $phone, $gender, $age){
    	global $conn;
    	$username = mysqli_real_escape_string($conn, $username);
    	$pass = sha1($password);
    	$email = mysqli_real_escape_string($conn, $email);
    	$name = mysqli_real_escape_string($conn, $name);
    	$surname = mysqli_real_escape_string($conn, $surname);
    	$address = mysqli_real_escape_string($conn, $address);
    	$mail = mysqli_real_escape_string($conn, $mail);
    	$phone = mysqli_real_escape_string($conn, $phone);
    	$gender = mysqli_real_escape_string($conn, $gender);
    	$age = mysqli_real_escape_string($conn, $age);

    	$query = "INSERT INTO user (username, password, email, name, surname, address, mail, phone, gender, age) VALUES ('$username', '$pass', '$email', '$name', '$surname', '$address', '$mail', '$phone', '$gender', '$age');";
    	if($conn->query($query)){
    		return true;
    	}
    	else{
    		echo mysqli_error($conn);
    		return false;
    	}
    }

    $error = "";
    if(isset($_POST["registracija"])){

    	if($_POST["password"] != $_POST["passwordConf"]){
    		$error = "Gesli se ne ujemata.";
    	}

    	if($_POST["username"] == "" || $_POST["password"] == "" || $_POST["passwordConf"] == "" || $_POST["email"] == "" || $_POST["name"] == "" || $_POST["surname"] == ""){
    	    $error = "Izpolniti je potrebno vsa obvezna polja.";
    	}

    	else if(username_exists($_POST["username"])){
    		$error = "Uporabniško ime je že zasedeno.";
    	}

    	else if(register_user($_POST["username"], $_POST["password"], $_POST["email"], $_POST["name"], $_POST["surname"], $_POST["address"], $_POST["mail"], $_POST["phone"], $_POST["gender"], $_POST["age"])){
    		header("Location: prijava.php");
    		die();
    	}

    	else{
    		$error = "Prišlo je do napake med registracijo.";
    	}
    }

?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>
<body>
	<form action="registracija.php" method="POST">
	    <h2>Obvezni podatki:</h2>
		Uporabiško ime*: <input type="text" name="username" /><br/>
		Geslo*: <input type="password" name="password" /> <br/>
		Ponovi geslo*: <input type="password" name="passwordConf" /> <br/>
		Email*: <input type="email" name="email"/> <br/>
		Ime*: <input type="text" name="name"/> <br/>
		Priimek*: <input type="text" name="surname"/> <br/>

        <h2>Neobvezni podatki:</h2>
		Naslov: <input type="text" name="address"/> <br/>
		Pošta: <input type="text" name="mail"/> <br/>
		Telefonska številka: <input type="tel" name="phone" pattern="[0-9]{3}-[0-9]{3}-[0-9]{3}"/> <br/>
		Spol:<input type="radio" id="male" name="gender" value="male">
            <label for="male">Moški</label>
            <input type="radio" id="female" name="gender" value="female">
            <label for="female">Ženska</label><br>
		Starost: <input type="number" name="age"/> <br/>
		<input type="submit" name="registracija" value="registriraj" /> <br/>
		<label><?php echo $error; ?></label>
	</form>
</body>
</html>
