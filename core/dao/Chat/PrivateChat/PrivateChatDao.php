<?php

/*
 * This file is part of the PooterBot project.
 * 
 * (c) 2018 Daniele Ambrosino <mail@danieleambrosino.it>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file distributed with this source code.
 */
require_once realpath(__DIR__ . '/../../../../vendor/autoload.php');
/**
 * Description of PrivateChatDao
 *
 * @author Daniele Ambrosino
 */
abstract class PrivateChatDao extends ChatDao
{

  protected static $instance;
  
  public static function getInstance()
  {
    if ( empty(static::$instance) )
    {
      static::$instance = new static();
    }
    return static::$instance;
  }
  
  protected function constructObject(array $data): PrivateChat
  {
    $chat = &$data[0];
    return new PrivateChat($chat['chatId'], $chat['firstName'], $chat['lastName'],
                           $chat['username']);
  }

  public function get(int $id): PrivateChat
  {
    $query = "SELECT * FROM PrivateChats WHERE chatId = ?";
    $values = [$id];
    $data = $this->db->query($query, $values);
    if ( empty($data) )
    {
      throw new ResourceNotFoundException();
    }
    return $this->constructObject($data);
  }

  /**
   * 
   * @param PrivateChat $chat
   */
  public function store($chat)
  {
    $query = "INSERT INTO PrivateChats (chatId, firstName, lastName, userName) VALUES (?, ?, ?, ?)";
    $values = [$chat->getId(), $chat->getFirstName(), $chat->getLastName(), $chat->getUsername()];
    $this->db->query($query, $values);
  }

  /**
   * 
   * @param PrivateChat $chat
   */
  public function update($chat)
  {
    $query = "UPDATE PrivateChats SET firstName = ?, lastName = ?, username = ? WHERE chatId = ?";
    $values = [$chat->getFirstName(), $chat->getLastName(), $chat->getUsername(), $chat->getId()];
    $this->db->query($query, $values);
  }

}
