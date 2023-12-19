<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mise à jour d'une ligne - Processus</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <h1>Mise à jour d'une ligne - Processus</h1>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['table']) && isset($_POST['selectedID'])) {
                // details connexion
        $mysqli = new mysqli("localhost", "root2", "pass", "tp2_sio1_commande");

            // verif la co
        if ($mysqli->connect_error) {
            die("Erreur de connexion à la base de données: " . $mysqli->connect_error);
        }

        // Récupérer le nom de la table et le numéro de ligne depuis le formulaire POST
        $tableName = $_POST['table'];
        $selectedID = $_POST['selectedID'];

        // Vérifier si la colonne 'id' existe dans la table
        $result = $mysqli->query("SHOW COLUMNS FROM `$tableName` LIKE 'id'");

        if ($result->num_rows > 0) {
            // Si la colonne 'id' existe, utiliser la clause WHERE
            $result = $mysqli->query("SELECT * FROM `$tableName` WHERE id = $selectedID");
        } else {
            // Sinon, utiliser LIMIT pour récupérer la ligne spécifique
            $result = $mysqli->query("SELECT * FROM `$tableName` LIMIT $selectedID, 1");
        }

        if ($result->num_rows > 0) {
            // Afficher le formulaire de mise à jour
            $row = $result->fetch_assoc();
            echo "<form action='update_confirm.php' method='post'>";
            echo "<input type='hidden' name='table' value='$tableName'>";
            echo "<input type='hidden' name='selectedID' value='$selectedID'>";

            foreach ($row as $col => $value) {
                echo "<label for='$col'>$col :</label>";
                echo "<input type='text' name='$col' value='$value'>";
            }

            echo "<button type='submit'>Mettre à jour</button>";
            echo "</form>";
        } else {
            echo "<p>Aucune donnée trouvée pour l'ID $selectedID dans la table $tableName.</p>";
        }

        $result->close();
        $mysqli->close();
    }
    ?>

</body>

</html>