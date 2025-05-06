<?php
session_start();

// Connessione al DB
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "strumenti_musicali";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}

function pulisci($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = pulisci($_POST["nome"]);
    $cognome = pulisci($_POST["cognome"]);
    $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
    $password = $_POST["password"];
    $conferma_password = $_POST["conferma_password"];
    $indirizzo = pulisci($_POST["indirizzo"]);
    $citta = pulisci($_POST["citta"]);
    $telefono = pulisci($_POST["telefono"]);
    $data_nascita = $_POST["data_nascita"]; // Nuovo campo aggiunto

    // Verifica se la password e la conferma password coincidono
    if ($password !== $conferma_password) {
        $error = "Le password non coincidono.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Email non valida.";
    } elseif (strlen($password) < 6) {
        $error = "La password deve contenere almeno 6 caratteri.";
    } else {
        $stmt = $conn->prepare("SELECT email FROM utenti WHERE email = ? LIMIT 1");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $error = "Email già registrata.";
        } else {
            $hashed = password_hash($password, PASSWORD_DEFAULT);
            $data_registrazione = date("Y-m-d H:i:s"); // Impostazione data di registrazione

            // Query di inserimento nel database
            $stmt = $conn->prepare("INSERT INTO utenti (nome, cognome, email, password, indirizzo, citta, telefono, data_nascita, data_registrazione) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssssss", $nome, $cognome, $email, $hashed, $indirizzo, $citta, $telefono, $data_nascita, $data_registrazione);

            if ($stmt->execute()) {
                header("Location: login.php");
                exit();
            } else {
                $error = "Errore nella registrazione.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Registrazione - AudioCore</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f3f3f3;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .register-box {
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            width: 320px;
        }

        .register-box h2 {
            margin-bottom: 20px;
            text-align: center;
        }

        .register-box input {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            border: 1px solid #ccc;
            border-radius: 6px;
        }

        .register-box button {
            width: 100%;
            padding: 10px;
            background: #28a745;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }

        .register-box .error {
            color: red;
            font-size: 0.9em;
            text-align: center;
            margin-bottom: 10px;
        }

        .register-box .success {
            color: green;
            font-size: 0.9em;
            text-align: center;
            margin-bottom: 10px;
        }

        .label {
            font-size: 0.9em;
            margin-bottom: 5px;
            display: block;
            color: #333;
        }
    </style>
</head>
<body>
<div class="register-box">
    <h2>Registrazione</h2>
    <?php if (isset($error)): ?>
        <div class="error"><?= $error ?></div>
    <?php elseif (isset($success)): ?>
        <div class="success"><?= $success ?></div>
    <?php endif; ?>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label class="label" for="nome">Nome</label>
        <input type="text" name="nome" id="nome" placeholder="Nome" required>

        <label class="label" for="cognome">Cognome</label>
        <input type="text" name="cognome" id="cognome" placeholder="Cognome" required>

        <label class="label" for="email">Email</label>
        <input type="email" name="email" id="email" placeholder="Email" required>

        <label class="label" for="password">Password</label>
        <input type="password" name="password" id="password" placeholder="Password (min 6 caratteri)" required>

        <label class="label" for="conferma_password">Conferma Password</label>
        <input type="password" name="conferma_password" id="conferma_password" placeholder="Conferma Password" required>

        <label class="label" for="indirizzo">Indirizzo</label>
        <input type="text" name="indirizzo" id="indirizzo" placeholder="Indirizzo" required>

        <label class="label" for="citta">Città</label>
        <input type="text" name="citta" id="citta" placeholder="Città" required>

        <label class="label" for="telefono">Telefono</label>
        <input type="text" name="telefono" id="telefono" placeholder="Telefono" required>

        <label class="label" for="data_nascita">Data di Nascita</label>
        <input type="date" name="data_nascita" id="data_nascita" placeholder="Data di Nascita" required>

        <button type="submit">Registrati</button>
        <a href="home.php">
            <button type="button" style="margin-top: 10px; background-color: #dc3545;">Indietro</button>
        </a>
    </form>
</div>
</body>
</html>
