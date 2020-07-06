<p>Dodaj novega uporabnika</p>
<!-- pogled za dodajanje novega oglasa.-->
<!-- Gre za enostavno formo, ki podatke pošilja na kotroler oglasi, z akcijo shrani-->
<form action="?controller=oglasi&action=shrani" method="post">
<div class="form-group">
    <label for="username">Username:</label>
    <input type="text" class="form-control" name="username" placeholder="Username" />
    <label for="password">Password:</label>
    <input type="password" name="password" class="form-control" placeholder="password"/>
    <label for="email">Email:</label>
    <input type="email" name="email" class="form-control" placeholder="email"/>
<input class="btn btn-primary" type="submit" name="Dodaj" value="Dodaj"/>
<!-- po pritisku submit gumba, se bo klicala akcija shrani, torej moremo v telesu metode shrani, v našem kontrolerju, ustrezno prebrati podatke ($_POST)-->
</div>
</form>