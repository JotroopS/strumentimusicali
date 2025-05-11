<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "strumenti_musicali";

// Connessione al database
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}

$strumento = null;

if (isset($_GET['id'])) {
    $idStrumento = intval($_GET['id']);
    // Recupera i dettagli dello strumento
    $query = $conn->prepare("SELECT id, marca, modello, prezzo, immagine, descrizione, quantita, disponibilita FROM strumenti WHERE id = ?");
    $query->bind_param("i", $idStrumento);
    $query->execute();
    $result = $query->get_result();
    $strumento = $result->fetch_assoc();
    $query->close();
}

// Aggiungi al carrello
if (isset($_POST['aggiungi'])) {
    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
        $idProdotto = intval($_POST['idProdotto']);
        $idUtente = $_SESSION['id']; // Assicurati che l'ID utente sia salvato in sessione al login

        // Controllo quantità disponibile
        $check = $conn->prepare("SELECT quantita FROM strumenti WHERE id = ?");
        $check->bind_param("i", $idProdotto);
        $check->execute();
        $res = $check->get_result();
        $row = $res->fetch_assoc();
        $check->close();

        if ($row && $row['quantita'] > 0) {
            // Inserimento nella tabella carrello con id_utente
            $stmt = $conn->prepare("INSERT INTO carrello (id_utente, id_strumento, quantita) 
                                    VALUES (?, ?, 1)
                                    ON DUPLICATE KEY UPDATE quantita = quantita + 1");
            $stmt->bind_param("ii", $idUtente, $idProdotto);
            $stmt->execute();
            $stmt->close();

            // Decrementa la quantità dello strumento
            $update = $conn->prepare("UPDATE strumenti SET quantita = quantita - 1 WHERE id = ?");
            $update->bind_param("i", $idProdotto);
            $update->execute();
            $update->close();

            header("Location: carrello.php");
            exit;
        } else {
            echo "<script>alert('Prodotto non disponibile o esaurito.'); window.location.href='dettagli.php?id=" . $idProdotto . "';</script>";
            exit;
        }
    } else {
        header("Location: login.php");
        exit;
    }
}

?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Dettagli <?php echo htmlspecialchars($strumento['marca'] . ' ' . $strumento['modello']); ?> - AudioCore</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; margin: 0; background: #f9f9f9; }
        header {
            background: #222222;
            color: white;
            padding: 20px 0;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        header .logo { font-size: 1.5em; margin-left: 20px; }
        header nav {
            display: flex;
            justify-content: flex-end;
            gap: 20px;
            margin-right: 20px;
        }
        header nav a {
            color: white;
            text-decoration: none;
            font-size: 1.1em;
        }
        footer {
            background: #222222;
            color: white;
            padding: 15px 20px;
            text-align: center;
            position: fixed;
            bottom: 0;
            width: 100%;
            box-shadow: 0 -2px 5px rgba(0,0,0,0.1);
        }
        .container { padding: 20px; display: flex; justify-content: center; margin-top: 40px; }
        .detal {
            display: flex;
            max-width: 1200px;
            gap: 40px;
        }
        .detal img {
            width: 400px;
            height: 400px;
            object-fit: contain;
        }
        .detal .descrizione {
            max-width: 600px;
        }
        .detal .descrizione h2 {
            font-size: 1.8em;
            margin-bottom: 10px;
        }
        .detal .descrizione p {
            font-size: 1.2em;
            color: #555;
        }
        .back-btn {
            padding: 10px 20px;
            background-color: #1c87c9;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 1.1em;
        }
        .back-btn:hover {
            background-color: #155a8a;
        }
        .aggiungi-btn {
            padding: 10px 20px;
            background-color: #28a745;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 1.1em;
            border: none;
            cursor: pointer;
        }
        .aggiungi-btn:disabled {
            background-color: gray;
            cursor: not-allowed;
        }
        .bottoni {
            display: flex;
            gap: 20px;
            margin-top: 20px;
            align-items: center;
        }
    </style>
</head>
<body>
<header>
    <div style="display: flex; justify-content: space-between;">
        <div class="logo">AudioCore</div>
        <nav>
            <a href="home.php">Home</a>
            <a href="#" onclick="vaiAlCarrello(event)">Carrello</a>
            <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
                <a href="logout.php">Logout</a>
            <?php else: ?>
                <a href="login.php">Accedi</a>
            <?php endif; ?>
        </nav>
    </div>
</header>
<div class="container">
    <?php if ($strumento): ?>
        <div class="detal">
            <img src="<?php echo htmlspecialchars($strumento['immagine']); ?>" alt="<?php echo htmlspecialchars($strumento['marca']); ?>">
            <div class="descrizione">
                <h2><?php echo htmlspecialchars($strumento['marca']) . ' ' . htmlspecialchars($strumento['modello']); ?></h2>
                <p><strong>Prezzo:</strong> € <?php echo number_format($strumento['prezzo'], 2, ',', '.'); ?></p>
                <p><strong>Disponibilità:</strong> <?php echo $strumento['quantita'] > 0 ? $strumento['quantita'] . ' pezzi disponibili' : 'Non disponibile'; ?></p>
                <p><strong>Descrizione:</strong> <?php echo htmlspecialchars($strumento['descrizione']); ?></p>
                <div class="bottoni">
                    <form method="POST" action="dettagli.php?id=<?php echo $strumento['id']; ?>">
                        <input type="hidden" name="idProdotto" value="<?php echo $strumento['id']; ?>">
                        <button type="submit" name="aggiungi" class="aggiungi-btn" <?php echo ($strumento['quantita'] <= 0 || $strumento['disponibilita'] == 0) ? 'disabled' : ''; ?>>
                            <?php echo ($strumento['quantita'] <= 0 || $strumento['disponibilita'] == 0) ? 'Non disponibile' : 'Aggiungi al carrello'; ?>
                        </button>
                    </form>
                    <a href="javascript:history.back()" class="back-btn">Indietro</a>
                </div>
            </div>
        </div>
    <?php else: ?>
        <p>Strumento non trovato.</p>
    <?php endif; ?>
</div>
<footer>
    &copy; 2025 AudioCore. Tutti i diritti riservati.
</footer>
<script>
    function vaiAlCarrello(event) {
        event.preventDefault();
        const isLoggedIn = <?php echo isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true ? 'true' : 'false'; ?>;
        if (isLoggedIn) {
            window.location.href = 'carrello.php';
        } else {
            window.location.href = 'login.php';
        }
    }
</script>
</body>
</html>
