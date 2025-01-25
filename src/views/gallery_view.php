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
            <h2>Galeria zdjęć</h2>
            <?php
            if (isset($model['error'])) {
                echo "<p style='color:red;'>{$model['error']}</p>";
            } elseif (!empty($model['images'])) {

                echo '<form method="POST" action="/remember_selected.php">';
                echo '<div class="gallery">';
                foreach ($model['images'] as $image) {
                    $id = (string)$image['_id'];
                    $title = $image['title'] ?? '';
                    $author = $image['author'] ?? '';
                    $watermarked = $image['watermarked'] ?? '';
                    $thumbnail = $image['thumbnail'] ?? '';
                    $visibility = $image['visibility'];

                    $checked = isset($_SESSION['remembered']) && in_array($id, $_SESSION['remembered']) ? 'checked' : '';

                    echo "<div class='image-item'>
                            <a href='/static/img/{$watermarked}' target='_blank'>
                                <img src='/static/img/{$thumbnail}' alt='Miniatura'>
                            </a>";
                    if($visibility === 'private'){
                        echo "<p>Widoczność: <strong>Prywatne</strong></p>";
                    }
                    echo "
                            <p>Tytuł: <strong>{$title}</strong></p>
                            <p>Autor: <strong>{$author}</strong></p>
                            <label>
                                <input type= 'checkbox' name='selected_images[]' value='{$id}' {$checked}> Zapamiętaj
                            </label>
                          </div>";
                }
                echo '</div>';
                echo '<button type="submit">Zapamiętaj wybrane</button>';
                echo '</form>';
            } else {
                echo '<p>Brak zdjęć w galerii.</p>';
            }
            ?>
        </section>
    </main>
</body>
</html>