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
 * Description of ChatTitleChangedEventDao
 *
 * @author Daniele Ambrosino
 */
class ChatTitleChangedEventDao extends ChatEventDao
{

  protected function constructObject(array $data)
  {
    
  }

  public function get(int $id)
  {
    
  }

  /**
   * 
   * @param ChatTitleChangedEvent $event
   */
  public function store($event)
  {
    $this->storeChatEventByType($event, 'chatTitleChanged');
    $query = "INSERT INTO ChatTitleChangedEvents (messageId, chatTitle) VALUES (?, ?)";
    $values = [$event->getId(), $event->getNewTitle()];
    $this->db->query($query, $values);
  }

  public function update($object)
  {
    
  }

}
