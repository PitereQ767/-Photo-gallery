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
        <section id="home">
            <h2>Wprowadzenie do tenisa Stołowego</h2>
            <p>Tenis stołowy, znany również jako ping-pong, to dynamiczny sport rozgrywany na prostokątnym stole o wymiarach 2,74 m długości i 1,525 m szerokości. 
                W jego centrum znajduje się siatka o wysokości 15,25 cm. Gra polega na odbijaniu lekkiej plastikowej piłeczki za pomocą rakietek, a celem jest zdobycie 
                jak największej liczby punktów poprzez zagranie piłki w taki sposób, aby przeciwnik nie zdołał jej skutecznie odbić.</p>
        </section>

        <section id="galeria">
            <h2>Prześlij zdjęcie (PNG lub JPG, max 1MB)</h2>
            <form action="upload.php" method="POST" enctype="multipart/form-data">
                <label for="file">Wybierz plik: </label>
                <input type="file" name="file" id="file" ><br><br>
                
                <label for="title">Tytuł zdjęcia: </label>
                <input type="text" name="title" id="title"><br><br>

                <label for="author">Autor zdjęcia: </label>
                <?php
                if(isset($_SESSION['username'])){
                    echo "
                        <input type='text' name='author' id='author' value='{$_SESSION['username']}'><br><br>
                        <p>Widoczność:</p>
                        <label>
                            <input type='radio' name='visibility' value='public' checked> Publiczne<br>
                        </label>
                        <label>
                            <input type='radio' name='visibility' value='private'> Prywatne<br><br>
                        </label>
                    ";
                }else{
                    echo "
                        <input type='text' name='author' id='author'><br><br>
                    ";
                }
                ?>
                
                
                <label for="watemark">Znak wodny</label>
                <input type="text" name="watemark" id="watemark" ><br><br>
                
                <button type="submit" name="submit">Wyslij plik</button>
            </form>
        </section>

        <section class="ranking" id="ranking1">
            <h2>Ranking graczy</h2>
            <table>
                <tr>
                    <th>Gracz</th>
                    <th>Punkty</th>
                    <th>Narodowość</th>
                </tr>
                <tr>
                    <th>Wang Chuqin</th>
                    <th>7675</th>
                    <th>Chiny</th>
                </tr>
                <tr>
                    <th>Lin Shidong</th>
                    <th>5185</th>
                    <th>Chiny</th>
                </tr>
                <tr>
                    <th>Fan Zhendong</th>
                    <th>4998</th>
                    <th>Chiny</th>
                </tr>
                <tr>
                    <th>Liang Jingkun</th>
                    <th>4550</th>
                    <th>Chiny</th>
                </tr>
                <tr>
                    <th>Ma Long</th>
                    <th>4465</th>
                    <th>Chiny</th>
                </tr>
                <tr>
                    <th>Hugo Calderno</th>
                    <th>4020</th>
                    <th>Brazylia</th>
                </tr>
            </table>
        </section>
    </main>
</body>
</html>