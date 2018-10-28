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
 * Description of ChatMemberRemoveEventDaoSqlite
 *
 * @author Daniele Ambrosino
 */
class ChatMemberRemovedEventDaoSqlite extends ChatMemberRemovedEventDao
{

  public function store($event)
  {
    $this->db->query('BEGIN TRANSACTION');
    $this->storeChatEventByType($event, 'chatMemberRemoved');
    $query = "DELETE FROM Members WHERE chatId = ? AND userId = ?";
    $values = [$event->getChat()->getId(), $event->getLeftMember()->getId()];
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
