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

$nome = '';
$cognome = '';
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true && isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];
    $sql = "SELECT nome, cognome FROM utenti WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $stmt->bind_result($nome, $cognome);
    $stmt->fetch();
    $stmt->close();
}

// Leggi categoria da GET
$categoriaId = isset($_GET['categoria']) ? intval($_GET['categoria']) : 0;
$strumenti = [];
$categoriaNome = '';

if ($categoriaId > 0) {
    // Prendi nome categoria
    $catQuery = $conn->prepare("SELECT nome FROM categorie WHERE id = ?");
    $catQuery->bind_param("i", $categoriaId);
    $catQuery->execute();
    $catQuery->bind_result($categoriaNome);
    $catQuery->fetch();
    $catQuery->close();

    // Prendi strumenti dal database
    $query = $conn->prepare("SELECT id, marca, modello, prezzo, immagine FROM strumenti WHERE id_categoria = ?");
    $query->bind_param("i", $categoriaId);
    $query->execute();
    $result = $query->get_result();
    while ($row = $result->fetch_assoc()) {
        $strumenti[] = $row;
    }
    $query->close();
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($categoriaNome); ?> - AudioCore</title>
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

        .container { padding: 20px; }
        .grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
        }

        .card {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            overflow: hidden;
            text-align: center;
            padding: 20px;
            height: 420px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            transition: transform 0.3s ease; /* Aggiunta la transizione per ingrandire */
        }

        .card:hover {
            transform: scale(1.05); /* Effetto di ingrandimento al passaggio del mouse */
        }

        .card img {
            width: 100%;
            height: 250px;
            object-fit: contain;
            margin-bottom: 15px;
        }

        .card h3 {
            margin: 10px 0;
            font-size: 1.2em;
        }

        .card p {
            color: #1c87c9;
            font-weight: bold;
            font-size: 1.1em;
        }

        .card form {
            margin-top: auto;
        }

        .card button {
            background-color: #1c87c9;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s;
        }

        .card button:hover {
            background-color: #155a8a;
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
    <h2><?php echo htmlspecialchars($categoriaNome); ?></h2>
    <div class="grid">
        <?php if (!empty($strumenti)): ?>
            <?php foreach ($strumenti as $strumento): ?>
                <div class="card">
    <a href="dettagli.php?id=<?php echo $strumento['id']; ?>" style="text-decoration: none; color: inherit;">
        <img src="<?php echo htmlspecialchars($strumento['immagine']); ?>" alt="<?php echo htmlspecialchars($strumento['marca']); ?>">
        <h3><?php echo htmlspecialchars($strumento['marca']) . ' ' . htmlspecialchars($strumento['modello']); ?></h3>
        <p>€ <?php echo number_format($strumento['prezzo'], 2, ',', '.'); ?></p>
    </a>
</div>

            <?php endforeach; ?>
        <?php else: ?>
            <p>Nessun prodotto trovato in questa categoria.</p>
        <?php endif; ?>
    </div>
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
