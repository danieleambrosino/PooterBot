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
 * Description of AudioDaoMysql
 *
 * @author Daniele Ambrosino
 */
class AudioDaoMysql extends AudioDao
{

  /**
   * 
   * @param Audio $message
   */
  public function store($message)
  {
    $this->db->query('START TRANSACTION');
    $this->storeMessageByType($message, 'audio');
    $this->fileDao->store($message->getFile());
    $query = "INSERT INTO Audios (messageId, duration, title, performer, caption, fileId) VALUES (?, ?, ?, ?, ?, ?)";
    $values = [$message->getId(), $message->getDuration(), $message->getTitle(), $message->getPerformer(), $message->getCaption(), $message->getFile()->getId()];
    $this->db->query($query, $values);
    $this->db->query('COMMIT');
  }

}
