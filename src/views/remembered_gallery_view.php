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
            <h2>Galeria zapamiętanych zdjęć</h2>
            <?php
            if (isset($model['error'])) {
                echo "<p style='color:red;'>{$model['error']}</p>";
            } elseif (!empty($model['remembered_images'])) {

                echo '<form method="POST" action="/remove_remembered.php">';
                echo '<div class="gallery">';
                foreach ($model['remembered_images'] as $image) {
                    $id = (string)$image['_id'];
                    $thumbnail = $image['thumbnail'];
                    $watermarked = $image['watermarked'];


                    echo "<div class='image-item'>
                            <a href='/static/img/{$watermarked}' target='_blank'>
                                <img src='/static/img/{$thumbnail}' alt='Miniatura'>
                            </a>
                            <br>
                            <label>
                                <input type= 'checkbox' name='remove_images[]' value='{$id}'> Usuń z zapamiętanych
                            </label>
                          </div>";
                }
                echo '</div>';
                echo '<button type="submit">Usuń zaznaczone z wybranych</button>';
                echo '</form>';
            } else {
                echo '<p>Brak zapamietanych zdjęć w galerii.</p>';
            }
            ?>
        </section>
    </main>
</body>
</html>