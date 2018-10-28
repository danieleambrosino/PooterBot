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
 * Description of ChatPhotoChangedEventDaoSqlite
 *
 * @author Daniele Ambrosino
 */
class ChatPhotoChangedEventDaoSqlite extends ChatPhotoChangedEventDao
{

  /**
   * 
   * @param ChatPhotoChangedEvent $event
   */
  public function store($event)
  {
    $this->db->query('BEGIN TRANSACTION');
    $this->storeChatEventByType($event, 'chatPhotoChanged');
    $this->fileDao->store($event->getNewPhoto());
    $query = "INSERT INTO ChatPhotoChangedEvents (messageId, photoId) VALUES (?, ?)";
    $values = [$event->getId(), $event->getNewPhoto()->getId()];
    $this->db->query($query, $values);
    $this->db->query('COMMIT');
  }

}
