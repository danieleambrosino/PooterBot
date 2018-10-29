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
 * Description of DocumentDaoSqlite
 *
 * @author Daniele Ambrosino
 */
class DocumentDaoSqlite extends DocumentDao
{

  /**
   * 
   * @param Document $message
   */
  public function store($message)
  {
    $this->db->query('BEGIN TRANSACTION');
    $this->storeMessageByType($message, 'document');
    $this->fileDao->store($message->getFile());
    $query = "INSERT INTO Documents (messageId, fileName, caption, fileId) VALUES (?, ?, ?, ?)";
    $values = [$message->getId(), $message->getFileName(), $message->getCaption(), $message->getFile()->getId()];
    $this->db->query($query, $values);
    $this->db->query('COMMIT');
  }

}
