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
 * Description of VoiceDaoMysql
 *
 * @author Daniele Ambrosino
 */
class VoiceDaoMysql extends VoiceDao
{

  /**
   * 
   * @param Voice $message
   */
  public function store($message)
  {
    $this->db->query('START TRANSACTION');
    $id = $this->storeMessageByType($message, 'voice');
    $this->fileDao->store($message->getFile());
    $query = "INSERT INTO Voices (messageId, duration, caption, fileId) VALUES (?, ?, ?, ?)";
    $values = [$id, $message->getDuration(), $message->getCaption(), $message->getFile()->getId()];
    $this->db->query($query, $values);
    $this->db->query('COMMIT');
  }

}
