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
 * Description of ChatPhotoChangedEventDao
 *
 * @author Daniele Ambrosino
 */
class ChatPhotoChangedEventDao extends ChatEventDao
{

  protected function constructObject(array $data)
  {
    
  }

  public function get(int $id)
  {
    
  }

  /**
   * 
   * @param ChatPhotoChangedEvent $event
   */
  public function store($event)
  {
    $this->storeChatEventByType($event, 'chatPhotoChanged');
    $query = "INSERT INTO ChatPhotoChangedEvents (messageId, photoId) VALUES (?, ?)";
    $values = [$event->getId(), $event->getNewPhoto()->getId()];
    $this->db->query($query, $values);
  }

  public function update($object)
  {
    
  }

}
