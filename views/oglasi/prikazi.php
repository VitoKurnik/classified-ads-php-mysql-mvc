<!--enostaven pogled za prikaz enega oglasa -->
<!-- ta se nahaja v spremenljivki $oglas, ki smo jo pripravili v kontrolerju -->

<form action="?controller=oglasi&action=uredi_shrani" method="post">
    <div class="form-group">
        <label for="username">Username:</label>
        <input type="text" class="form-control" name="username" placeholder="Username" value="<?php echo $oglas->username; ?>" readonly/>
        <label for="email">Email:</label>
        <input type="email" name="email" class="form-control" placeholder="email" value="<?php echo $oglas->email; ?>" readonly/>
        <label for="name">Name:</label>
        <input type="text" name="name" class="form-control" placeholder="name" value="<?php echo $oglas->name; ?>" readonly/>
        <label for="surname">Surname:</label>
        <input type="text" name="surname" class="form-control" placeholder="surname" value="<?php echo $oglas->surname; ?>" readonly/>
        <label for="address">Address:</label>
        <input type="text" name="address" class="form-control" placeholder="/" value="<?php echo $oglas->address; ?>" readonly/>
        <label for="mail">Mail:</label>
        <input type="text" name="mail" class="form-control" placeholder="/" value="<?php echo $oglas->mail; ?>" readonly/>
        <label for="phone">Phone:</label>
        <input type="text" name="phone" class="form-control" placeholder="/" value="<?php echo $oglas->phone; ?>" readonly/>
        <label for="gender">Gender:</label>
        <input type="text" name="gender" class="form-control" placeholder="/" value="<?php echo $oglas->gender; ?>" readonly/>
        <label for="age">Age:</label>
        <input type="text" name="age" class="form-control" placeholder="/" value="<?php echo $oglas->age; ?>" readonly/>
    </div>
</form>
