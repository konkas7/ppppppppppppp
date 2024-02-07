<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $servername = "localhost";  
    $username = $_POST["username"];
    $password = $_POST["password"];
    $database = "formula_one_db";

    $conn = new mysqli($servername, $username, $password, $database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    echo "<head>";
    echo "<style>";
    echo "table {";
    echo "    width: 100%;";
    echo "    border-collapse: collapse;";
    echo "}";
    echo "th, td {";
    echo "    border: 1px solid #dddddd;";
    echo "    text-align: center;";
    echo "    padding: 8px;";
    echo "}";
    echo "</style>";
    echo "</head>";



    




    function displayTable($conn, $query, $tableHeading)
    {
    $result = $conn->query($query);

    if ($result) { 
        if ($result->num_rows > 0) {
            echo "<h2>$tableHeading</h2>";
            echo "<table border='1'>";
            $row = $result->fetch_assoc();
            echo "<tr>";
            foreach ($row as $key => $value) {
                echo "<th>$key</th>";
            }
            echo "</tr>";

            do {
                echo "<tr>";
                foreach ($row as $value) {
                    echo "<td>$value</td>";
                }
                echo "</tr>";
            } while ($row = $result->fetch_assoc());

            echo "</table>";

            echo "<!DOCTYPE html>";
            echo "<html lang='en'>";
            echo "<head>";
            echo "<style>";
            echo "table {";
            echo "    width: 100%;";
            echo "    border-collapse: collapse;";
            echo "}";
            echo "th, td {";
            echo "    border: 1px solid #dddddd;";
            echo "    text-align: center;";
            echo "    padding: 8px;";
            echo "}";
            echo "</style>";
            echo "</head>";
            echo '<input type="text" id="primacolonna" placeholder="Filtra">';
            echo '<input type="text" id="secondacolonna" placeholder="Filtra">';
            echo '<input type="text" id="terzacolonna" placeholder="Filtra">';
            echo '<button onclick="applyFilters()">Applica Filtri</button>';

            echo '<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>';
            echo '<script src="mioScript.js"></script>';
                echo '<script>';
            echo '    $(document).ready(function() {';
            echo '        applyFilters();';
            echo '    });';
            echo '</script>';

            
            echo "</html>";





        } else {
            echo "<p>No data found</p>";
        }
    } else {
        echo "<p>Error executing query: " . $conn->error . "</p>";
    }
}

    /*
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $filterNames = isset($_POST["filterNames"]) ? $_POST["filterNames"] : null;
        $filterLastNames = isset($_POST["filterLastNames"]) ? $_POST["filterLastNames"] : null;
        $filterPoints = isset($_POST["filterPoints"]) ? $_POST["filterPoints"] : null;
    
        $query = "SELECT nome, cognome, nazionalita, data_nascita, punti_totali FROM piloti WHERE 1 = 1";

        if ($filterNames !== null) {
            $query .= " AND nome = '$filterNames'";
        }

        if ($filterLastNames !== null) {
            $query .= " AND cognome = '$filterLastNames'";
        }

        if ($filterPoints !== null) {
            $query .= " AND punti_totali = $filterPoints";
        }



    
    
        displayTable($conn, $query, "Piloti");
    
    }

    */
    displayTable($conn, "SELECT nome, cognome, nazionalita, data_nascita, punti_totali FROM piloti", "Piloti");
    displayTable($conn, "SELECT nome_team, sede, anno_fondazione FROM team", "Team");
    displayTable($conn, "SELECT gare_vinte.nome_gara, gare_vinte.data_gara, piloti.cognome AS vincitore_cognome " .
    "FROM gare_vinte " .
    "LEFT JOIN piloti ON gare_vinte.vincitore_id = piloti.pilota_id", "Gare Vinte");
    displayTable($conn, "SELECT piloti.cognome, team.nome_team, piloti_team.anno_ingresso " .
    "FROM piloti_team " .
    "JOIN piloti ON piloti_team.pilota_id = piloti.pilota_id " .
    "JOIN team ON piloti_team.team_id = team.team_id", "Piloti Team");

    $conn->close();
} else {
    header("Location: main.html");
    exit();
}
?>









