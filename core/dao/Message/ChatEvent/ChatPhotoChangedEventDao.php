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
