<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mise à jour d'une ligne</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <h1>Mise à jour d'une ligne</h1>

    <form action="update.php" method="post">
        <label for="table">Choisir une table :</label>
        <select name="table" id="table">
            <option value="client">Client</option>
            <option value="produit">Produit</option>
            <option value="commande">Commande</option>
            <option value="lignecom">Lignecom</option>
        </select>
        <button type="submit">Afficher le tableau</button>
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['table'])) {
            // details connexion
        $mysqli = new mysqli("localhost", "root2", "pass", "tp2_sio1_commande");

            // verif la co
        if ($mysqli->connect_error) {
            die("Erreur de connexion à la base de données: " . $mysqli->connect_error);
        }

        // Récupérer le nom de la table depuis le formulaire POST
        $tableName = $_POST['table'];

        // Numéro de ligne
        $result = $mysqli->query("SELECT * FROM `$tableName`");
        if ($result->num_rows > 0) {
            echo "<table border='1'>";
            echo "<tr><th>Numéro</th>";

            // Noms des colonnes
            $columns = $result->fetch_assoc();
            foreach ($columns as $col => $value) {
                echo "<th>$col</th>";
            }

            echo "</tr>";

            // Données + numéro de ligne
            $rowCount = 0;
            $result->data_seek(0); // Réinitialiser la position du résultat
            while ($row = $result->fetch_assoc()) {
                echo "<tr><td>$rowCount</td>";

                foreach ($row as $value) {
                    echo "<td>$value</td>";
                }

                echo "</tr>";
                $rowCount++;
            }

            echo "</table>";

            // Formulaire pour choisir le numéro de la ligne
            echo "<form action='update_process.php' method='post'>";
            echo "<input type='hidden' name='table' value='$tableName'>";
            echo "<label for='selectedID'>Choisir le numéro de la ligne :</label>";
            echo "<input type='text' name='selectedID' required>";
            echo "<button type='submit'>Afficher les champs de mise à jour</button>";
            echo "</form>";
        } else {
            echo "<p>Aucune donnée trouvée dans la table $tableName.</p>";
        }

        $result->close();
        $mysqli->close();
    }
    ?>

</body>

</html>
