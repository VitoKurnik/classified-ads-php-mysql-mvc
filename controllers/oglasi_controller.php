<?php

//kontroler za delo z oglasi
class oglasi_controller {

    //akcija, ki uporabniku prikaže vse oglase
  public function index() {

      //s pomočjo statične metode modela, dobimo seznam vseh oglasov
      //$oglasi bodo na voljo v pogledu za vse oglase panel.php
    $oglasi = Oglas::vsi();

      //pogled bo oblikoval seznam vseh oglasov v html kodo
    require_once('views/oglasi/index.php');
  }


    //akcija, ki prikaže ene oglas
  public function prikazi() {
     //preverimo, če je uporabnik podal informacijo, o oglasu, ki ga želi pogledati
    if (!isset($_GET['id'])){
        return call('strani', 'napaka'); //če ne, kličemo akcijo napaka na kontrolerju stran
        //retun smo nastavil za to, da se izvajanje kode v tej akciji ne nadaljuje
      }
      //drugače najdemo oglas in ga prikažemo
      $oglas = Oglas::najdi($_GET['id']);
      require_once('views/oglasi/prikazi.php');
    }

  //akcija za dodajanje oglasov uporabniku prikaže le vmesnik za dodajanje novega oglasa.
    public function dodaj() {
      require_once('views/oglasi/dodaj.php');
    }

  //akcija shrani, pričakuje, da bo uporabnik poleg informacije o želeni akciji, preko POST metode, poslal tudi dva podatka - naslov in vsebino
    public function shrani() {

    //tukaj bi morali še preveriti vrednost uporabniškega vnosa glede varnosti in obstoja
      //podatki so bili običajno posali in pogleda dodaj.php, ki ga je naložila akcija dodaj.
        if(!isset($_POST["gender"]))
        {
            $_POST["gender"] = "";
        }
      $oglas=Oglas::dodaj($_POST["username"],$_POST["password"],$_POST["email"],$_POST["name"],$_POST["surname"],$_POST["address"],$_POST["mail"],$_POST["phone"],$_POST["gender"],$_POST["age"]);

    //ko je oglas dodan, imamo v $oglas podatke o tem novem oglasu
    //uporabniku lahko pokažemo pogled, ki ga bo obvestil o uspešnosti oddaje oglasa
      require_once('views/oglasi/uspesnoDodal.php');
    }

    public function brisi() {
        $oglas=Oglas::brisi($_GET['id']);

        //require_once('views/oglasi/uspesnoDodal.php');
    }

    public function uredi(){
        $oglas = Oglas::najdi($_GET['id']);
        require_once('views/oglasi/uredi.php');
    }
    public function uredi_shrani() {
      if(!isset($_POST["gender"]))
      {
          $_POST["gender"] = "";
      }
        $oglas=Oglas::uredi($_POST["ID"],$_POST["username"],$_POST["password"],$_POST["email"],$_POST["name"],$_POST["surname"],$_POST["address"],$_POST["mail"],$_POST["phone"],$_POST["gender"],$_POST["age"]);
    }
  }
  ?>