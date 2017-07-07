<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Error</title>
  </head>
  <body>
      <h1>Трапилась помилка</h1>
      <p><b>Код помилки : </b><?= $errno?></p>
      <p><b>Текст помилки : </b><?= $errstr?></p>
      <p><b>Файл, в якому сталась помилка : </b><?= $errfile?></p>
      <p><b>Рядок, в якому трапилась помилка : </b><?= $errline?></p>
  </body>
</html>
