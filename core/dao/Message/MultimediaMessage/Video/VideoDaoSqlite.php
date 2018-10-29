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
 * Description of VideoDaoSqlite
 *
 * @author Daniele Ambrosino
 */
class VideoDaoSqlite extends VideoDao
{

  /**
   * 
   * @param Video $message
   */
  public function store($message)
  {
    $this->db->query('BEGIN TRANSACTION');
    $this->storeMessageByType($message, 'video');
    $this->fileDao->store($message->getFile());
    $query = "INSERT INTO Videos (messageId, width, height, duration, caption, fileId) VALUES (?, ?, ?, ?, ?, ?)";
    $values = [$message->getId(), $message->getWidth(), $message->getHeight(), $message->getDuration(), $message->getCaption(), $message->getFile()->getId()];
    $this->db->query($query, $values);
    $this->db->query('COMMIT');
  }

}
