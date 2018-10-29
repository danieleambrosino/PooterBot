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
 * Description of VideoNoteDaoMysql
 *
 * @author Daniele Ambrosino
 */
class VideoNoteDaoMysql extends VideoNoteDao
{

  /**
   * 
   * @param VideoNote $message
   */
  public function store($message)
  {
    $this->db->query('START TRANSACTION');
    $this->storeMessageByType($message, 'videoNote');
    $this->fileDao->store($message->getFile());
    $query = "INSERT INTO VideoNotes (messageId, length, duration, fileId) VALUES (?, ?, ?, ?)";
    $values = [$message->getId(), $message->getLength(), $message->getDuration(), $message->getFile()->getId()];
    $this->db->query($query, $values);
    $this->db->query('COMMIT');
  }

}
