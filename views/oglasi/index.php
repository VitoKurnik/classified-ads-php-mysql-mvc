<p>Seznam vseh uporabnikov</p>
<!-- pogled za pregeld vseh oglasov-->
<!-- na vrhu damu uporabniku gumb, s katerim proži akcijo dodaj, da lahko dodaja nove uporabnike -->
<a href="?controller=oglasi&action=dodaj" class="btn btn-primary">Dodaj <i class="fas fa-plus"></i></a>
<table class="table table-hover">
    <thead>
      <tr>
        <th>Username</th>
        <th>Password</th>
        <th>Email</th>
      </tr>
    </thead>
    <tbody>
 
 <!-- tukaj se sprehodimo čez array oglasov in izpisujemo vrstico posameznega oglasa-->
 <?php
    function stObjav($id)
    {
        $stevec=0;
        $list = [];
        $db = Db::getInstance();
        //izvedemo query
        $result = 'SELECT * FROM objave';
        $res = $db->query($result);
        $objave = array();
        while($objava = $res->fetch_object()){
            array_push($objave, $objava);
        }
        foreach($objave as $objava)
        {
            if($objava->user_id == $id)
            {
                $stevec = $stevec+1;
            }
        }
        return $stevec;
    }
 ?>

<?php foreach($oglasi as $oglas) { ?>
  <tr>
  <td><?php echo $oglas->username; ?><br><span class="badge badge-pill badge-secondary"><?php echo stObjav($oglas->id); ?></span></td>
  
  <td>
    <!-- pri vsakem oglasu dodamo povezavo na akcijo prikaži, z idjem oglasa. Uporabnik lahko tako proži novo akcijo s pritiskom na gumb.-->
    <!--<a href='?controller=oglasi&action=prikazi&id=<?php echo $oglas->id; ?>'>Poglej vsebino</a>-->
      <?php echo $oglas->password; ?>
	</td>
	<td><?php echo $oglas->email; ?></td>
      <td><a href='?controller=oglasi&action=brisi&id=<?php echo $oglas->id; ?>' class="btn btn-danger">Brisi <i class="fas fa-minus"></i></a></td>
      <td><a href='?controller=oglasi&action=uredi&id=<?php echo $oglas->id; ?>' class="btn btn-warning">Uredi <i class="fas fa-pencil-alt"></i></a></td>
      <td><a href='?controller=oglasi&action=prikazi&id=<?php echo $oglas->id; ?>' class="btn btn-success">Preglej <i class="fas fa-address-card"></i></a></td>
 </tr>
<?php } ?>

    
       
      
    </tbody>
  </table>