<?php

/*
 * This file is part of the PooterBot project.
 * 
 * (c) 2018 Daniele Ambrosino <mail@danieleambrosino.it>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file distributed with this source code.
 */

/**
 * Description of NewChatMembersEventDao
 *
 * @author Daniele Ambrosino
 */
class ChatMembersAddedEventDao extends ChatEventDao
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

  protected function constructObject(array $data)
  {
    
  }

  public function get($id)
  {
    
  }

  /**
   * 
   * @param ChatMembersAddedEvent $event
   */
  public function store($event)
  {
    $this->db->query('BEGIN TRANSACTION');
    $this->storeChatEventByType($event, 'chatMembersAdded');
    $query = "INSERT OR IGNORE INTO Members (chatId, userId) VALUES ";
    $values = [];
    $newMembers = $event->getNewMembers();
    /* @var $newMember User */
    foreach ($newMembers as $newMember)
    {
      $query .= "(?, ?), ";
      $values[] = $event->getChat()->getId();
      $values[] = $newMember->getId();
    }
    $query = substr($query, 0, -2);
    $this->db->query($query, $values);
    $this->db->query('COMMIT');
  }

  public function update($object)
  {
    
  }

}
