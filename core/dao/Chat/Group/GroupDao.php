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
 * Description of GroupDao
 *
 * @author Daniele Ambrosino
 */
class GroupDao extends ChatDao
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

  protected function constructObject(array $data): Group
  {
    $group = &$data[0];
    return new Group($group['chatId'], $group['title']);
  }

  public function get($id): Group
  {
    $query = "SELECT * FROM Groups WHERE chatId = ?";
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
   * @param Group $chat
   */
  public function store($chat)
  {
    $query = "INSERT INTO Groups (chatId, title) VALUES (?, ?)";
    $values = [$chat->getId(), $chat->getTitle()];
    $this->db->query($query, $values);
  }

  /**
   * 
   * @param Group $chat
   */
  public function update($chat)
  {
    $query = "UPDATE Groups SET title = ? WHERE chatId = ?";
    $values = [$chat->getTitle(), $chat->getId()];
    $this->db->query($query, $values);
  }

}
