<?php

// connection au fichier connect (User,mdp,server)
require_once 'connec.php';
// connection a la base de donnée
$pdo = new PDO(DSN, USER, PASS);
//init $error
$errors = [];

//Sortir les espaces
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
// array = fonction sur tableau
    $name = array_map('trim', $_POST);

// verif first et last name ecrit
    if (empty($name['firstname'])) {
        $errors[] = 'Le prénom est obligatoire';
    }

    if (empty($name['lastname'])) {
        $errors[] = 'Le nom de famille est obligatoire';
    }
//si pas error insert to bdd
    if (empty($errors)) {

        $query = 'INSERT INTO friend (firstname, lastname) VALUES (:firstname, :lastname)';
        $statement = $pdo->prepare($query);

        $statement->bindValue(':firstname', $name['firstname'], \PDO::PARAM_STR);
        $statement->bindValue(':lastname', $name['lastname'], \PDO::PARAM_STR);

        $statement->execute();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quete PDO</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
<h1>Add character of Friends !</h1>

<ul>
    <?php foreach ($errors as $error) : ?>
        <li><?= $error ?></li>
    <?php endforeach; ?>
</ul>
<form method="POST" novalidate>
    <label for="firstname">Firstname</label>
    <input type="text" id="firstname" name="firstname" required value="<?= isset($friend['firstname']) ? $name['firstname'] : '' ?>">

    <label for="lastname">Lastname</label>
    <input type="text" id="lastname" name="lastname" value="<?= isset($friend['lastname']) ? $name['lastname'] : '' ?>">

    <button>Add</button>
</form>
</body>
</html>