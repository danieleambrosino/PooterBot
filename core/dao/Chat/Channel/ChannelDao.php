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
 * Description of ChannelDao
 *
 * @author Daniele Ambrosino
 */
class ChannelDao extends ChatDao
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

  protected function constructObject(array $data): Channel
  {
    $chat = &$data[0];
    return new Channel($chat['chatId'], $chat['title'], $chat['username']);
  }

  public function get($id): Channel
  {
    $query = "SELECT * FROM Channels WHERE chatId = ?";
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
   * @param Channel $chat
   */
  public function store($chat)
  {
    $query = "INSERT INTO Channels (chatId, title, username) VALUES (?, ?, ?)";
    $values = [$chat->getId(), $chat->getTitle(), $chat->getUsername()];
    $this->db->query($query, $values);
  }

  /**
   * 
   * @param Channel $chat
   */
  public function update($chat)
  {
    $query = "UPDATE Channels SET title = ?, username = ? WHERE chatId = ?";
    $values = [$chat->getTitle(), $chat->getUsername(), $chat->getId()];
    $this->db->query($query, $values);
  }

}
