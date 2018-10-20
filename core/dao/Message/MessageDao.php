<?php

/*
 * This file is part of the PooterBot project.
 * 
 * (c) 2018 Daniele Ambrosino <mail@danieleambrosino.it>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file distributed with this source code.
 */
require_once realpath(__DIR__ . '/../../../vendor/autoload.php');
/**
 * Description of MessageDao
 *
 * @author Daniele Ambrosino
 */
abstract class MessageDao extends Dao
{

  /**
   * 
   * @param Message $message
   */
  public function delete($message)
  {
    $query = "DELETE FROM Messages WHERE id = ?";
    $values = [$message->getId()];
    $this->db->query($query, $values);
  }
  
  protected function storeMessageByType(Message $message, string $type)
  {
    $query = "INSERT INTO Messages (id, datetime, type, userId, chatId) VALUES (?, ?, ?, ?, ?)";
    $values = [$message->getId(), $message->getDatetime(), $type, $message->getUser()->getId(), $message->getChat()->getId()];
    $this->db->query($query, $values);
  }

}
