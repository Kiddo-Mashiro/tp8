<?php
    // details connexion
$mysqli = new mysqli("localhost", "root2", "pass", "tp2_sio1_commande");

    // verif la co
if ($mysqli->connect_error) {
    die("Erreur de connexion à la base de données: " . $mysqli->connect_error);
}

// recup + affichage
function displayTable($mysqli, $tableName)
{
    $result = $mysqli->query("SELECT * FROM `$tableName`");

    // tableau
    if ($result->num_rows > 0) {
        echo "<h2>$tableName</h2>";
        echo "<table border='1'>";
        // entete
        echo "<tr>";
        while ($field = $result->fetch_field()) {
            echo "<th>{$field->name}</th>";
        }
        echo "</tr>";
        // ligne de donnees
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            foreach ($row as $value) {
                echo "<td>$value</td>";
            }
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p>Aucune donnée dans la table $tableName.</p>";
    }

    $result->close();
}

// tables a afficher
$tablesToDisplay = ['client', 'produit', 'lignecom', 'commande'];

// verif formu
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verif table sélectionnee
    if (isset($_POST['tables'])) {
        $selectedTables = $_POST['tables'];

        // les affiches
        foreach ($selectedTables as $selectedTable) {
            if (in_array($selectedTable, $tablesToDisplay)) {
                displayTable($mysqli, $selectedTable);
            }
        }
    }

    echo "<a href='index.html'><button>Retour à l'accueil</button></a>";
} else {
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Afficher les Tables</title>
        <link rel="stylesheet" href="styles.css">
    </head>
    <body>
        <h1>Afficher les Tables</h1>

        <form action="display.php" method="post">
            <h2>Choisir les tables à afficher :</h2>
            <?php
            // tt les checkbox
            foreach ($tablesToDisplay as $table) {
                echo "<label><input type='checkbox' name='tables[]' value='$table'> $table</label>";
            }
            ?>

            <button type="submit">Afficher</button>
        </form>
    </body>
    </html>
    <?php
}

$mysqli->close();
?>