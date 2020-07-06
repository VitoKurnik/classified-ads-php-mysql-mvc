<?php

//enostaven primer kontrolerja, ki ne uporablja modela
//njegova naloga je, da vrača bolj ali manj statičen html
class strani_controller {
    //akcija domov, ki nastavi vrednosti dveh spremenljivk in jih pripravi (potisne) za pogled (view)
  public function domov() {
      $first_name = $_SESSION["USER_NAME"];
    $last_name  = $_SESSION["USER_SURNAME"];
      //vključimo view
    require_once('views/strani/domov.php');
  }

    //enostavna akcija za napako, ki vključi samo view
  public function napaka() {
    require_once('views/strani/napaka.php');
  }
}
?>
