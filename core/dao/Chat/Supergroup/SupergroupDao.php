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
 * Description of SupergroupDao
 *
 * @author Daniele Ambrosino
 */
class SupergroupDao extends ChatDao
{

  protected function constructObject(array $data): Supergroup
  {
    $chat = &$data[0];
    return new Supergroup($chat['id'], $chat['title'], $chat['username']);
  }

  public function get(int $id): Supergroup
  {
    $query = "SELECT * FROM Supergroups WHERE chatId = ?";
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
   * @param Supergroup $chat
   */
  public function store($chat)
  {
    $query = "INSERT INTO Supergroups (chatId, title, username) VALUES (?, ?, ?)";
    $values = [$chat->getId(), $chat->getTitle(), $chat->getUsername()];
    $this->db->query($query, $values);
  }

  /**
   * 
   * @param Supergroup $chat
   */
  public function update($chat)
  {
    $query = "UPDATE Supergroups SET title = ?, username = ? WHERE chatId = ?";
    $values = [$chat->getTitle(), $chat->getUsername(), $chat->getId()];
    $this->db->query($query, $values);
  }

}
