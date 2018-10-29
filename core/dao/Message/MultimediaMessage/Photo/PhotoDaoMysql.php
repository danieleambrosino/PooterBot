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
 * Description of PhotoDaoMysql
 *
 * @author Daniele Ambrosino
 */
class PhotoDaoMysql extends PhotoDao
{

  /**
   * 
   * @param Photo $message
   */
  public function store($message)
  {
    $this->db->query('START TRANSACTION');
    $this->storeMessageByType($message, 'photo');
    $this->fileDao->store($message->getFile());
    $query = "INSERT INTO Photos (messageId, width, height, caption, fileId) VALUES (?, ?, ?, ?, ?)";
    $values = [$message->getId(), $message->getWidth(), $message->getHeight(), $message->getCaption(), $message->getFile()->getId()];
    $this->db->query($query, $values);
    $this->db->query('COMMIT');
  }

}
