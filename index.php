<?php

$errors = [];
$formSet = false;
$user = 'root';
$password = 'root';


$pdo = new PDO('mysql:host=localhost;dbname=blog', $user, $password, [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
]);
//if ($_SERVER['REQUEST_METHOD'] === 'POST'){
$name = $_POST['name'] ?? '';
$titel = $_POST['posttitel'] ?? '';
$text = $_POST['textarea'] ?? '';
$date = $_POST['created_at'] ?? '';
//}
$stmt = $pdo->prepare("INSERT INTO `posts` (created_by, post_title, post_text) VALUES (:by, :on, :text) ");
$stmt->execute([':by' => $name, ':on' => $titel, ':text' => $text]);

if ($name === '') {
    $errors[] = 'Bitte geben Sie einen Namen ein.';
}
if (count($errors) === 0) {
    $formSent = true;
}


?>
<!DOCTYPE html>
<html lang="en">
<link rel = "stylesheet" href = "styles.css" >
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body id = "container">
<header class = "header">
<h1>Erstelle ein Blockbeitrag</h1>


</header>


<main class = "inhalt">
    <form action ="index.php" method="POST">
<h2>Blog erstellen</h2>
<div id ="felder">
<div class = "benutzername">
    <label class="eingabe" for="name">Benutzername</label> 
    <input type="text" name="name" class = "nameneingabe"><br>
</div>
<div class = "eingabetitel">
    <label class="eingabe" for="posttitel">Titel deines Posts</label>
    <input type="text" name="posttitel" class = "blogtitel"><br>
</div>
<div class = "eingabeblog">    
    <label for="textarea" class="eingabetext">Schreibe dein Post </label>
    <textarea name="textarea" id="posttext"  rows ="4" cols = "50"></textarea>
</div>
<div>
<input type="submit" name ="absenden" value="Absenden" >
</div>
</div>
<div>
    <h2>Veröffenlichte Posts</h2>
   <?php
      $sql = "SELECT created_at, created_by, post_title, post_text FROM posts";
      foreach ($pdo->query($sql) as $row) {
          echo $row['post_title']."<br />";
          echo $row['created_at']."<br />";
          echo $row['created_by']."<br />";
          echo $row['post_text']."<br />";
      }
   ?>
</main>
<aside class = "sidebar"> 
<h4>Weitere Blogs:</h4>
<ul>
<li>Erin Bachmann:</li>
<li>Davide Trinkler:</li>
<li>Joshua Odermatt:</li>
<li>Alessio Vangelisti:</li>
<li>Darvin Windlin:</li>
<li>Nicola Fioretti:</li>
<li>Marvin Putschert:</li>
<li>Luca Aeberhard:</li>
</aside>    

</body>
</html>

