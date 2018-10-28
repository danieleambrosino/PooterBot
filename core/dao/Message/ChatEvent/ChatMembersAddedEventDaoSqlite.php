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
 * Description of ChatMembersAddedEventDaoSqlite
 *
 * @author Daniele Ambrosino
 */
class ChatMembersAddedEventDaoSqlite extends ChatMembersAddedEventDao
{

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

  protected function constructObject(array $data)
  {
    
  }

  public function get($id)
  {
    
  }

  public function update($object)
  {
    
  }

}
