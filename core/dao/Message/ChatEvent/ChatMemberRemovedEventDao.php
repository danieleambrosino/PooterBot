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
 * Description of LeftChatMemberEventDao
 *
 * @author Daniele Ambrosino
 */
class ChatMemberRemovedEventDao extends ChatEventDao
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
   * @param ChatMemberRemovedEvent $event
   */
  public function store($event)
  {
    $this->db->query('BEGIN TRANSACTION');
    $this->storeChatEventByType($event, 'chatMemberRemoved');
    $query = "DELETE FROM Members WHERE chatId = ? AND userId = ?";
    $values = [$event->getChat()->getId(), $event->getLeftMember()->getId()];
    $this->db->query($query, $values);
    $this->db->query('COMMIT');
  }

  public function update($object)
  {
    
  }

}
