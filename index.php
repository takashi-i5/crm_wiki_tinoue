<?php

session_start();

require_once(__DIR__ . '/config.php');
require_once(__DIR__ . '/functions.php');
require_once(__DIR__ . '/Word.php');

// get words
$wordApp = new \MyApp\Word();
$words = $wordApp->getAll();

// var_dump($words);
// exit;

?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>CRM用語wiki</title>
  <link rel="stylesheet" href="styles.css">
</head>


<body>
  <h2>CRM用語wiki</h2>

  <form action="" id="new_word_form">
    <input type="text" id="new_word" placeholder="単語入力">
    <input type="text" id="new_meaning" placeholder="意味入力">
    <input type="submit" value="送信する">
  </form>

  <ul id="words">
  <?php foreach ($words as $word) : ?>
  
    <h3>・<?= ($word->word); ?></h3>
    <li id="word_<?= h($word->id); ?>" data-id="<?= h($word->id); ?>">
        <?= h($word->meaning); ?>
        <!-- 削除 -->
        <div class="delete_word">delete</div>
        <!-- 修正 -->
        <form action="" id="update_word_form">
          <input type="text" id="update_meaning" placeholder="修正">
          <input type="submit" value="修正する">
        </form>
    </li>
  <?php endforeach; ?>
  </ul>

  <li id="word_template" data-id="">
      <span class="word_title"></span>
      <span class="meaning_title"></span>
      <span class="update_title"></span>
      <div class="delete_word">delete</div>
  </li>

  <input type="hidden" id="token" value="<?= h($_SESSION['token']); ?>">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
  <script src="word.js"></script>
</body>


</html>