<?php

$errors = [];
$formSet = false;
$user = 'root';
$password = 'root';


$pdo = new PDO('mysql:host=localhost;dbname=blog', $user, $password, [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
]);

$user1 = 'd041e_gibucher';
$password1 = '54321_Db!!!';

$pdo1 = new PDO('mysql:host=10.20.18.122;dbname=d041e_gibucher', $user1, $password1, [
PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
]);


$name = htmlentities($_POST['name'] ?? '');
$titel = htmlentities($_POST['posttitel'] ?? '');
$text = htmlentities($_POST['textarea'] ?? '');
$date = $_POST['created_at'] ?? '';
$bildurl = htmlentities($_POST['bildurl'] ?? '');

 if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    
    if($name === '') {
        $errors[] = "Sie haben kein Name eingegeben";
    }
    if($titel === '') {
        $errors[] = "Sie haben kein Titel eingegeben";
    }
    if($text === '') {
        $errors[] = "Sie haben kein Text geschrieben";
    }
    if(count($errors) === 0) {
        $formSet = true;
    }
    if ($formSet === true) {
        $stmt = $pdo->prepare("INSERT INTO `posts` (created_by, post_title, post_text, post_url) VALUES (:by, :on, :text, :url) ");
        $stmt->execute([':by' => $name, ':on' => $titel, ':text' => $text, ':url' => $bildurl]);
        }
}
?>

<!DOCTYPE html>
<html lang="en">
<link rel = "stylesheet" href = "styles.css" >
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Blog</title>
    <link href="https://fonts.googleapis.com/css?family=Bree+Serif&display=swap" rel="stylesheet">
</head>
<body>
    <div id = "container">
<header class = "header">
<h1 class = "titel">Erstelle ein Blockbeitrag</h1>


</header>

<nav class = "navigation"> 
<ul>
    <h2>Blogs von Kollegen</h2>
            <?php
            $stmt = $pdo1->query('SELECT * FROM `ipadressen`');
            foreach($stmt->fetchAll() as $x) {
              echo "<li><a href='http://$x[Ip]' class='andereblogs'>$x[vorname]</a></li>";
            }
            ?>
        </ul>

</nav>    

<aside class = "sidebar">
<form action ="index.php" method="POST">
<h2>Post erstellen</h2>

<div id ="felder">
<div class = "benutzername">
    <label class="eingabe" for="name">Benutzername</label> 
    <input type="text" name="name" class = "nameneingabe"><br>
</div>
<div class = "eingabetitel">
    <label class="eingabe" for="posttitel">Titel</label>
    <input type="text" name="posttitel" class = "blogtitel"><br>
</div>
<div class = "eingabebild">
    <label class = "bildinput" for = "bildurl">Bild</label>
    <input type="text" name="bildurl" class ="bildadresse"><br> 
</div>
<div class = "eingabeblog">    
    <label for="textarea" class="eingabetext">Schreibe dein Post </label>
    <textarea name="textarea" id="posttext"  rows ="4" cols = "50"></textarea>
</div>
<div class = "button">
<input type="submit" name ="absenden" value="Absenden" >
</div>


<?php foreach ($errors as $error) : ?>
    <li><?=  $error ?></li>
    <?php endforeach; ?>
</div>

</aside>

    <main class = "inhalt">
    <h2>Veröffenlichte Posts</h2>
    <?php
      $sql = "SELECT created_at, created_by, post_title, post_text, post_url FROM posts";
      $sql = "SELECT * From posts ORDER BY created_at DESC LIMIT 10";
      foreach ($pdo->query($sql) as $row) {
          ?><div id = "posttitel">
              <?php
            echo $row['post_title']."<br />";
            ?>
            </div>
            <?php
            echo $row['created_at']."<br />";
            echo $row['created_by']."<br />";
            echo $row['post_text']."<br />";
            echo "<img class = 'foto' src = '{$row["post_url"]}'><br />";
        ?>
        
        <?php
        }
   ?>
</main>
</body>
</html>

