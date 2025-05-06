<?php
session_start();

// Connessione al database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "strumenti_musicali";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}

// Inizializza variabili
$nome = $cognome = $email = $indirizzo = $citta = $telefono = $data_nascita = $data_registrazione = "";
$modifica_successo = false;

// Verifica se l'utente è loggato e ha un ID valido
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true && isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];

    // Se è stato inviato il modulo per modificare i dati
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['modifica'])) {
        $nuovo_indirizzo = $_POST['indirizzo'];
        $nuova_citta = $_POST['citta'];
        $nuovo_telefono = $_POST['telefono'];

        $update_sql = "UPDATE utenti SET indirizzo = ?, citta = ?, telefono = ? WHERE id = ?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("sssi", $nuovo_indirizzo, $nuova_citta, $nuovo_telefono, $userId);
        if ($update_stmt->execute()) {
            $modifica_successo = true;
        }
    }

    // Recupera i dati aggiornati
    $sql = "SELECT nome, cognome, email, indirizzo, citta, telefono, data_nascita, data_registrazione FROM utenti WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows === 1) {
        $row = $result->fetch_assoc();
        $nome = $row['nome'];
        $cognome = $row['cognome'];
        $email = $row['email'];
        $indirizzo = $row['indirizzo'];
        $citta = $row['citta'];
        $telefono = $row['telefono'];
        $data_nascita = date("d/m/Y", strtotime($row['data_nascita']));
        $data_registrazione = date("d/m/Y", strtotime($row['data_registrazione']));
    } else {
        echo "Utente non trovato.";
        exit;
    }
} else {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Profilo</title>
    <?php if ($modifica_successo): ?>
        <script>
            window.onload = function() {
                alert("Le modifiche sono state salvate correttamente.");
            };
        </script>
    <?php endif; ?>
</head>
<body>
    <h1>Profilo di <?php echo htmlspecialchars($nome . " " . $cognome); ?></h1>
    <p><strong>Email:</strong> <?php echo htmlspecialchars($email); ?></p>
    <p><strong>Data di nascita:</strong> <?php echo htmlspecialchars($data_nascita); ?></p>
    <p><strong>Data di registrazione:</strong> <?php echo htmlspecialchars($data_registrazione); ?></p>

    <h2>Modifica dati</h2>
    <form method="post" action="">
        <label>Indirizzo:</label><br>
        <input type="text" name="indirizzo" value="<?php echo htmlspecialchars($indirizzo); ?>" required><br><br>

        <label>Città:</label><br>
        <input type="text" name="citta" value="<?php echo htmlspecialchars($citta); ?>" required><br><br>

        <label>Telefono:</label><br>
        <input type="text" name="telefono" value="<?php echo htmlspecialchars($telefono); ?>" required><br><br>

        <button type="submit" name="modifica">Salva modifiche</button>
    </form>

    <br>
    <form action="home.php" method="get">
        <button type="submit">Torna alla Home</button>
    </form>
</body>
</html>
