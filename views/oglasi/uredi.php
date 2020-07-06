<p>Dodaj novega uporabnika</p>
<!-- pogled za dodajanje novega oglasa.-->
<!-- Gre za enostavno formo, ki podatke pošilja na kotroler oglasi, z akcijo shrani-->
<form action="?controller=oglasi&action=uredi_shrani" method="post">
<div class="form-group">
    <label for="ID">ID:</label>
    <input type="text" class="form-control" id="ID" name="ID" value="<?php echo $oglas->id; ?>" readonly/>
    <label for="username">Username*:</label>
    <input type="text" class="form-control" name="username" placeholder="Username" value="<?php echo $oglas->username; ?>"/>
    <label for="password">Password*:</label>
    <input type="password" name="password" class="form-control" placeholder="password" value="<?php echo $oglas->password; ?>"/>
    <label for="email">Email*:</label>
    <input type="email" name="email" class="form-control" placeholder="email" value="<?php echo $oglas->email; ?>"/>
    <label for="name">Name*:</label>
    <input type="text" name="name" class="form-control" placeholder="name" value="<?php echo $oglas->name; ?>"/>
    <label for="surname">Surname*:</label>
    <input type="text" name="surname" class="form-control" placeholder="surname" value="<?php echo $oglas->surname; ?>"/>
    <label for="address">Address:</label>
    <input type="text" name="address" class="form-control" placeholder="address" value="<?php echo $oglas->address; ?>"/>
    <label for="mail">Mail:</label>
    <input type="text" name="mail" class="form-control" placeholder="mail" value="<?php echo $oglas->mail; ?>"/>
    <label for="phone">Phone:</label>
    <input type="tel" name="phone" class="form-control" placeholder="phone" pattern="[0-9]{3}-[0-9]{3}-[0-9]{3}" value="<?php echo $oglas->phone; ?>"/>
    Gender:
        <input type="radio" id="male" name="gender" value="male">
        <label for="male">Moški</label>
        <input type="radio" id="female" name="gender" value="female">
        <label for="female">Ženska</label><br>
    <label for="age">Age:</label>
    <input type="text" name="age" class="form-control" placeholder="age" value="<?php echo $oglas->age; ?>"/>
<input class="btn btn-primary" type="submit" name="Spremeni" value="Spremeni"/>
</div>
</form>