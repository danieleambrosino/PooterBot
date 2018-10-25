<?php
/*
 * This file is part of the PooterBot project.
 * 
 * (c) 2018 Daniele Ambrosino <mail@danieleambrosino.it>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file distributed with this source code.
 */
require_once realpath(__DIR__ . '/../vendor/autoload.php');

if ( !isset($_GET['chatId']) )
{
  exit;
}

$chatId = filter_var(filter_input(INPUT_GET, 'chatId',
                                  FILTER_SANITIZE_NUMBER_INT),
                                  FILTER_VALIDATE_INT);

$db = Factory::createDatabase();

$title = ChatDao::getChatTitle($chatId);
$chatType = ChatDao::getChatType($chatId);
$messages = MessageDao::getAllMessages($chatId);

require_once './templates/head.php';
?>
<title>Chat <?= $chatId ?></title>
<div class="container">
  <h1><?= $title ?> (<?= $chatType ?>)</h1>
  <table>
    <thead>
      <tr>
        <th>Data</th>
        <th>Nome</th>
        <th>Cognome</th>
        <th>Username</th>
        <th>Tipo messaggio</th>
        <th>Contenuto</th>
      </tr>
    </thead>
    <tbody>
      <?php
      foreach ($messages as $row)
      {
        ?>
        <tr>
          <td><?= $row['datetime'] ?></td>
          <td><?= $row['firstName'] ?></td>
          <td><?= $row['lastName'] ?></td>
          <td><?= $row['username'] ?></td>
          <td><?= $row['type'] ?></td>
          <td>
            <?php
            if ( $row['type'] !== 'text' )
            {
              ?>
              <a href="viewFile.php?fileId=<?= $row['content'] ?>" target="_target">
                <?php
              }
              ?>
              <?= $row['content'] ?>
              <?php
              if ( $row['type'] !== 'text' )
              {
                ?>
              </a>
              <?php
            }
            ?>
            </a>
          </td>
        <tr>
          <?php
        }
        ?>
    </tbody>
  </table>
</div>
<script>
  $('table').DataTable();
</script>