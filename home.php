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
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AudioCore - Home</title>
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background-color: #f9f9f9;
            color: #333;
            display: flex;
            flex-direction: row;
            min-height: 100vh;
            overflow-x: hidden;
        }

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 60px;
            height: 100vh;
            background-color: #2c3e50;
            overflow-x: hidden;
            transition: width 0.3s ease;
            z-index: 100;
        }

        .sidebar:hover {
            width: 220px;
        }

        .cover {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(44, 62, 80, 0.95);
            display: flex;
            align-items: center;
            justify-content: center;
            pointer-events: none;
            transition: opacity 0.3s ease;
        }

        .sidebar:hover .cover {
            opacity: 0;
        }

        .cover-text {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: #ecf0f1;
            font-size: 1.2em;
            font-weight: bold;
            text-align: center;
            white-space: nowrap;
        }

        .sidebar ul {
            list-style: none;
            padding: 0;
            margin: 60px 0 0;
            display: flex;
            flex-direction: column;
            gap: 15px;
            visibility: hidden;
            opacity: 0;
            transition: visibility 0s, opacity 0.3s ease-in-out;
        }

        .sidebar:hover ul {
            visibility: visible;
            opacity: 1;
        }

        .sidebar li {
            padding: 10px 20px;
            color: #ecf0f1;
            white-space: nowrap;
            cursor: pointer;
            transition: background 0.2s;
            position: relative;
        }

        .sidebar li:hover {
            background-color: #34495e;
        }

        .sidebar .submenu {
            display: none;
            background-color: #34495e;
            margin-top: 5px;
            margin-left: 10px;
            padding-left: 10px;
            border-left: 2px solid #1abc9c;
        }

        .sidebar li.active .submenu {
            display: block;
        }

        .sidebar .submenu p {
            margin: 5px 0;
        }

        .sidebar .submenu p a {
            color: #ecf0f1;
            text-decoration: none;
        }

        .sidebar .submenu p a:hover {
            text-decoration: underline;
        }

        .main-content {
            margin-left: 60px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        header {
            background-color: #fff;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .logo {
            font-size: 1.8em;
            font-weight: bold;
            color: #111;
        }

        .nav-icons {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .nav-icons img {
            width: 24px;
            height: 24px;
            cursor: pointer;
        }

        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #fff;
            min-width: 160px;
            box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2);
            z-index: 1;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }

        .dropdown-content a, .dropdown-content p {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
            margin: 0;
        }

        .dropdown-content a:hover {
            background-color: #f1f1f1;
        }

        .search-bar {
            margin: 20px auto;
            max-width: 600px;
            display: flex;
            gap: 10px;
            padding: 0 20px;
        }

        .search-bar input {
            flex: 1;
            padding: 12px;
            font-size: 1em;
            border-radius: 30px;
            border: 1px solid #ccc;
        }

        .slider {
            position: relative;
            width: 100%;
            max-width: 600px;
            height: 400px;
            margin: auto;
            overflow: hidden;
        }

        .slider-images {
            display: flex;
            width: calc(600px * 6);
            transition: transform 0.8s ease-in-out;
        }

        .slider-images img {
            width: 600px;
            height: 400px;
            object-fit: contain;
            flex-shrink: 0;
        }

        .benefits {
            display: flex;
            justify-content: center;
            gap: 30px;
            padding: 30px 20px;
            background-color: #fff;
            text-align: center;
        }

        .benefit {
            max-width: 180px;
        }

        .benefit-icon {
            font-size: 2em;
            margin-bottom: 10px;
            color: #1c87c9;
        }

        footer {
            background-color: #222;
            color: #fff;
            text-align: center;
            padding: 15px;
            margin-top: auto;
        }

        .user-info {
            margin-left: 10px;
            font-size: 14px;
            color: #555;
        }

        .vertical-text {
            writing-mode: vertical-rl;
            transform: rotate(180deg);
            font-size: 1.2em;
            font-weight: bold;
            text-align: center;
            color: #ecf0f1;
            white-space: nowrap;
        }
    </style>
</head>
<body>

<div class="sidebar">
    <div class="cover">
        <div class="cover-text">
            <span class="vertical-text">Categorie</span>
        </div>
    </div>
    <ul>
        <li class="category">
            Strumenti a corda
            <div class="submenu">
                <p><a href="strumenti.php?categoria=1">Chitarra</a></p>
                <p><a href="strumenti.php?categoria=2">Violino</a></p>
                <p><a href="strumenti.php?categoria=3">Arpa</a></p>
            </div>
        </li>
        <li class="category">
            Strumenti a fiato
            <div class="submenu">
                <p><a href="strumenti.php?categoria=4">Flauto</a></p>
                <p><a href="strumenti.php?categoria=5">Sax</a></p>
                <p><a href="strumenti.php?categoria=6">Clarinetto</a></p>
            </div>
        </li>
        <li class="category">
            Strumenti a percussione
            <div class="submenu">
                <p><a href="strumenti.php?categoria=7">Batteria</a></p>
                <p><a href="strumenti.php?categoria=8">Congas</a></p>
                <p><a href="strumenti.php?categoria=9">Tamburi</a></p>
            </div>
        </li>
        <li class="category">
            Tastiere
            <div class="submenu">
                <p><a href="strumenti.php?categoria=10">Pianoforte</a></p>
                <p><a href="strumenti.php?categoria=11">Organo</a></p>
                <p><a href="strumenti.php?categoria=12">Synthesizer</a></p>
            </div>
        </li>
        <li class="category">
            Microfoni
            <div class="submenu">
                <p><a href="strumenti.php?categoria=13">Microfono dinamico</a></p>
                <p><a href="strumenti.php?categoria=14">Microfono a condensatore</a></p>
                <p><a href="strumenti.php?categoria=15">Microfono USB</a></p>
            </div>
        </li>
        <li class="category">
            Accessori
            <div class="submenu">
                <p><a href="strumenti.php?categoria=16">Cavi</a></p>
                <p><a href="strumenti.php?categoria=17">Supporti</a></p>
                <p><a href="strumenti.php?categoria=18">Custodie</a></p>
            </div>
        </li>
    </ul>
</div>

<div class="main-content">
    <header>
        <div class="logo">AudioCore</div>
        <div class="nav-icons">
            <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
                <div class="dropdown">
                    <img src="https://img.icons8.com/ios-filled/50/user.png" alt="User">
                    <div class="dropdown-content">
                        <p class="user-info"><?php echo htmlspecialchars($nome) . ' ' . htmlspecialchars($cognome); ?></p>
                        <a href="profilo.php">Profilo</a>
                        <a href="#" onclick="confermaLogout(event)">Logout</a>
                    </div>
                </div>
            <?php else: ?>
                <a href="login.php">
                    <img src="https://img.icons8.com/ios-filled/50/user.png" alt="User">
                </a>
            <?php endif; ?>
            <a href="#" onclick="vaiAlCarrello(event)">
    <img src="https://img.icons8.com/ios-filled/50/shopping-cart.png" alt="Carrello">
</a>


        </div>
    </header>

    <div class="search-bar">
        <input type="text" placeholder="Cerca strumenti musicali...">
    </div>

    <div class="slider">
        <div class="slider-images" id="slider-images">
            <img src="chitarra.jpg" alt="Chitarra">
            <img src="batteria.jpg" alt="Batteria">
            <img src="basso.jpg" alt="Basso">
            <img src="chitarra1.jpg" alt="Chitarra1">
            <img src="microfono.jpg" alt="Microfono">
            <img src="pianoforte.jpg" alt="Pianoforte">
        </div>
    </div>

    <section class="benefits">
        <div class="benefit">
            <div class="benefit-icon">🔁</div>
            <h4>30 giorni di prova</h4>
            <p>Garanzia soddisfatti o rimborsati</p>
        </div>
        <div class="benefit">
            <div class="benefit-icon">🛡️</div>
            <h4>3 anni di garanzia</h4>
            <p>Su tutti i nostri prodotti</p>
        </div>
        <div class="benefit">
            <div class="benefit-icon">📦</div>
            <h4>Spedizione gratuita</h4>
            <p>Per ordini sopra 99€</p>
        </div>
    </section>

    <footer>
        &copy; 2025 AudioCore. Tutti i diritti riservati.
    </footer>
</div>

<script>
    let currentIndex = 0;
    const images = document.querySelectorAll('.slider-images img');
    const totalImages = images.length;
    const sliderImages = document.getElementById('slider-images');

    setInterval(() => {
        currentIndex = (currentIndex + 1) % totalImages;
        sliderImages.style.transform = `translateX(-${currentIndex * 600}px)`;
    }, 3000);

    function confermaLogout(event) {
        event.preventDefault();
        if (confirm("Sei sicuro di voler uscire?")) {
            window.location.href = "logout.php";
        }
    }

    const categories = document.querySelectorAll('.category');
    categories.forEach(category => {
        category.addEventListener('click', () => {
            category.classList.toggle('active');
        });
    });
</script>
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
