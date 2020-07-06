<?php

//model za oglas, ki vsebuje lasntosti, ki definirajo strukturo oglasa 
//in metode, ki vračajo podatke iz trajne hrambe ali jih tja zapisujejo
//v tem razredu so vse metode statične, lahko pa bi bile tudi običajne, pri čemer bi potrem bilo potrebno vsakič ustvarjat objekt


class Oglas {
  
  public $id;
  public $username;
  public $password;
  public $email;
  public $name;
  public $surname;
  public $address;
  public $mail;
  public $phone;
  public $gender;
  public $age;

  //konstruktor
  public function __construct($id, $username, $password,$email, $name, $surname, $address, $mail, $phone, $gender, $age) {
    $this->id      = $id;
    $this->username  = $username;
    $this->password = $password;
    $this->email = $email;
    $this->name = $name;
    $this->surname = $surname;
    $this->address = $address;
    $this->mail = $mail;
    $this->phone = $phone;
    $this->gender = $gender;
    $this->age = $age;
  }


    //metoda, ki iz baze vrne vse oglase
  public static function vsi() {
    $list = [];
      //dobimo objekt, ki predstavlja povezavo z bazo
    $db = Db::getInstance();
      //izvedemo query
    $result = mysqli_query($db,'SELECT * FROM user');

//v zanki ustvarjamo nove objekte in jih dajemo v seznam
    while($row = mysqli_fetch_assoc($result)){
      $list[] = new Oglas($row['id'], $row['username'], $row['password'], $row['email'], $row['name'], $row['surname'], $row['address'], $row['mail'], $row['phone'], $row['gender'], $row['age']);
    }
    
        //statična metoda vrača seznam objektov iz baze
    return $list;
  }

  //metoda, ki vrne en oglas z specifičnim id-jem iz baze
  public static function najdi($id) {

    $id = intval($id);
    
    $db = Db::getInstance();
    $result = mysqli_query($db,"SELECT * FROM user where id=$id");
    $row = mysqli_fetch_assoc($result);
    return new Oglas($row['id'], $row['username'], $row['password'],$row['email'], $row['name'], $row['surname'], $row['address'], $row['mail'], $row['phone'], $row['gender'], $row['age']);
  }
  

    //metoda, ki doda nov oglas v bazo

  public static function dodaj($username,$password,$email,$name,$surname,$address,$mail,$phone,$gender,$age) {
    
    $db = Db::getInstance();
    
	  //primer query-a s prepared statementom

      $password = sha1($password);
    if ($stmt = mysqli_prepare($db, "Insert into user (username,password,email,name,surname,address,mail,phone,gender,age) Values (?,?,?,?,?,?,?,?,?,?)")) {
			//dodamo parametre po vrsti namesto vprašajev
			//s string, i integer ,d double, b blob
     mysqli_stmt_bind_param($stmt, "ssssssssss",$username,$password, $email, $name, $surname, $address, $mail, $phone, $gender, $age);
     mysqli_stmt_execute($stmt);
     mysqli_stmt_close($stmt);
   }
   
   //dobimo nazaj informacijo o ID-ju, ki ga je generiral SQL strežnik
   $id=mysqli_insert_id($db);
   
    //z uporabo metode najdi, najdemo celoten, na novo ustvarjen oglas, in ga vrnemo kontrolerju
   return Oglas::najdi($id);
 }

    public static function brisi($id) {
      $id = intval($id);

      $db = Db::getInstance();
      $result = mysqli_query($db,"DELETE FROM objave where user_id=$id");
      $result = mysqli_query($db,"DELETE FROM user where id=$id");
      echo "<p>Oglas je bil uspešno odstranjen!</p>";
      //$row = mysqli_fetch_assoc($result);
      //return new Oglas($row['id'], $row['username'], $row['password'],$row['email']);
    }

    public static function uredi($id,$username,$password,$email,$name,$surname,$address,$mail,$phone,$gender,$age) {

        $db = Db::getInstance();

        //primer query-a s prepared statementom
        $password = sha1($password);
        if ($stmt = mysqli_prepare($db, "UPDATE user
                                                SET username = ?, password= ?, email = ?, name = ?, surname = ?, address = ?, mail = ?, phone = ?, gender = ?, age = ?
                                                WHERE id = '$id';")) {
            //dodamo parametre po vrsti namesto vprašajev
            //s string, i integer ,d double, b blob
            mysqli_stmt_bind_param($stmt, "ssssssssss",$username,$password, $email, $name, $surname, $address, $mail, $phone, $gender, $age);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            echo "Uporabnik je bil uspešno spremenjen!";
        }
    }
}
?>