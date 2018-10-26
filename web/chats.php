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

$db = Factory::createDatabase();
$query = "SELECT * FROM Chats";
$chats = $db->query($query);

require_once './templates/head.php';
?>
<div class="container">
  <h1>Chats</h1>
  <table>
    <thead>
      <tr>
        <th>ID</th>
        <th>Tipo</th>
      </tr>
    </thead>
    <tbody>
      <?php
      foreach ($chats as $chat)
      {
        ?>
        <tr>
          <td><a href="viewChat.php?chatId=<?= $chat['id'] ?>"><?= $chat['id'] ?></a></td>
          <td><?= $chat['type'] ?></td>
        </tr>
        <?php
      }
      ?>
    </tbody>
  </table>
</div>