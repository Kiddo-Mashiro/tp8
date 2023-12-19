<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $table = $_POST["table"];

    // details connexion
    $mysqli = new mysqli("localhost", "root2", "pass", "tp2_sio1_commande");

    // verif la co
    if ($mysqli->connect_error) {
        die("Erreur de connexion à la base de données: " . $mysqli->connect_error);
    }

    // noms
    $columns = [];
    $result = $mysqli->query("SHOW COLUMNS FROM `$table`");

    while ($row = $result->fetch_assoc()) {
        $columns[] = $row['Field'];
    }

    $result->close();

    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Insérer une ligne</title>
        <link rel="stylesheet" href="styles.css">
    </head>
    <body>
        <h1>Insérer une ligne</h1>

        <form action="insert.php" method="post">
            <?php

            foreach ($columns as $column) {
                echo "<label for='$column'>$column :</label>";
                echo "<input type='text' name='$column' id='$column' required>";
            }
            ?>

            <button type="submit">Insérer</button>
        </form>
        
        <a href="index.html"><button>Retour à l'accueil</button></a>
    </body>
    </html>
    <?php

    $mysqli->close();
} else {

    ?>
    <!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Insérer une ligne</title>
        <link rel="stylesheet" href="styles.css">
    </head>
    <body>
        <h1>Insérer une ligne</h1>

        <form action="insert.php" method="post">
            <label for="table">Choisir une table :</label>
            <select name="table" id="table">
                <option value="client">Client</option>
                <option value="produit">Produit</option>
                <option value="commande">Commande</option>
                <option value="lignecom">Lignecom</option>
            </select>

            <button type="submit">Afficher les champs</button>
        </form>
        <a href='index.html'><button>Retour à l'accueil</button>
    </body>
    </html>
    <?php
}
?>