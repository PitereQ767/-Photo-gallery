<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tenis stołowy</title>
    <?php include "../views/includes/head.inc.php"; ?>
</head>
<body>
    <header>
        <h1>Tenis stołowy</h1>
        <nav>
            <ul>
                <li><a href="index.php">Strona główna</a></li>
                <li><a href="gallery.php">Galeria zawaodników</a></li>
                <li><a href="technika.html">Technika</a>
                <ul class="submenu">
                    <li><a href="forehand">Forehand</a></li>
                    <li><a href="backhand">Backhand</a></li>
                </ul>
                </li>
                <li><a href="login.php">Logowanie</a></li>
                <li><a href="remembered_gallery.php">Zapamiętane zdjęcia</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section id="galeria">
            <h2>Logowanie</h2>
            <?php if(isset($model['error'])) echo "<p style = 'color:red;'>{$model['error']}</p>";?>
            <form action="/login.php" method="POST">
                <input type="text" name="username" placeholder="Login" required><br><br>
                <input type="password" name="password" placeholder="Hasło" required><br><br>
                <button type="submit">Zaloguj się</button><br><br>
            </form>
            <p>Nie masz konta? <a href="/register.php">Zarejestruj się</a></p>
        </section>
    </main>
</body>
</html>