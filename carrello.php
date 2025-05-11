<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "strumenti_musicali";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}

// Se il carrello non esiste, lo inizializzo
if (!isset($_SESSION['carrello'])) {
    $_SESSION['carrello'] = [];
}

function calcolaTotale($carrello, $conn) {
    $totale = 0;
    foreach ($carrello as $id => $quantita) {
        $query = "SELECT prezzo FROM strumenti WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->bind_result($prezzo);
        $stmt->fetch();
        $totale += $prezzo * $quantita;
        $stmt->close();
    }
    return $totale;
}

// Rimuovere un prodotto dal carrello
if (isset($_GET['rimuovi'])) {
    $idProdotto = $_GET['rimuovi'];
    unset($_SESSION['carrello'][$idProdotto]);
    header("Location: carrello.php");
    exit;
}

// Calcola il totale
$totale = calcolaTotale($_SESSION['carrello'], $conn);
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Carrello - AudioCore</title>
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
        .carrello-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .carrello-table th, .carrello-table td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }

        .carrello-table th {
            background-color: #222222;
            color: white;
        }

        .carrello-table td img {
            width: 50px;
            height: 50px;
            object-fit: contain;
        }

        .carrello-footer {
            text-align: right;
            font-size: 1.2em;
            font-weight: bold;
            margin-top: 20px;
        }

        .btn {
            padding: 10px 20px;
            background-color: #1c87c9;
            color: white;
            border: none;
            cursor: pointer;
            text-decoration: none;
            font-size: 1.1em;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .btn:hover {
            background-color: #007b8f;
        }
    </style>
</head>
<body>

<header>
    <div style="display: flex; justify-content: space-between;">
        <div class="logo">AudioCore</div>
        <nav>
            <a href="home.php">Home</a>
            <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
                <a href="logout.php">Logout</a>
            <?php else: ?>
                <a href="login.php">Accedi</a>
            <?php endif; ?>
        </nav>
    </div>
</header>

<div class="container">
    <h2>Il tuo carrello</h2>

    <?php if (empty($_SESSION['carrello'])): ?>
        <p>Il carrello è vuoto.</p>
    <?php else: ?>
        <table class="carrello-table">
            <thead>
                <tr>
                    <th>Prodotto</th>
                    <th>Marca/Modello</th>
                    <th>Quantità</th>
                    <th>Prezzo</th>
                    <th>Totale</th>
                    <th>Rimuovi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($_SESSION['carrello'] as $id => $quantita) {
                    $query = "SELECT marca, modello, prezzo, immagine FROM strumenti WHERE id = ?";
                    $stmt = $conn->prepare($query);
                    $stmt->bind_param("i", $id);
                    $stmt->execute();
                    $stmt->bind_result($marca, $modello, $prezzo, $immagine);
                    $stmt->fetch();
                    $stmt->close();
                ?>
                <tr>
                    <td><img src="<?php echo htmlspecialchars($immagine); ?>" alt="<?php echo htmlspecialchars($marca); ?>"></td>
                    <td><?php echo htmlspecialchars($marca . ' ' . $modello); ?></td>
                    <td><?php echo $quantita; ?></td>
                    <td>€ <?php echo number_format($prezzo, 2, ',', '.'); ?></td>
                    <td>€ <?php echo number_format($prezzo * $quantita, 2, ',', '.'); ?></td>
                    <td><a href="carrello.php?rimuovi=<?php echo $id; ?>" class="btn">Rimuovi</a></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>

        <div class="carrello-footer">
            <div>
                <strong>Totale: € <?php echo number_format($totale, 2, ',', '.'); ?></strong>
            </div>
            <div style="margin-top: 20px;">
                <a href="checkout.php" class="btn">Procedi al Checkout</a>
            </div>
        </div>
    <?php endif; ?>
</div>

<footer>
    &copy; 2025 AudioCore. Tutti i diritti riservati.
</footer>

</body>
</html>
