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
 * Description of ChatTitleChangedEventDaoMysql
 *
 * @author Daniele Ambrosino
 */
class ChatTitleChangedEventDaoMysql extends ChatTitleChangedEventDao
{

  /**
   * 
   * @param ChatTitleChangedEvent $event
   */
  public function store($event)
  {
    $this->db->query('START TRANSACTION');
    $this->storeChatEventByType($event, 'chatTitleChanged');
    $query = "INSERT INTO ChatTitleChangedEvents (messageId, chatTitle) VALUES (?, ?)";
    $values = [$event->getId(), $event->getNewTitle()];
    $this->db->query($query, $values);
    $this->db->query('COMMIT');
  }

}
