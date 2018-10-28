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
 * Description of AnimationDaoMysql
 *
 * @author Daniele Ambrosino
 */
class AnimationDaoMysql extends AnimationDao
{

  /**
   * 
   * @param Animation $message
   */
  public function store($message)
  {
    $this->db->query('START TRANSACTION');
    $this->storeMessageByType($message, 'animation');
    $this->fileDao->store($message->getFile());
    $query = "INSERT INTO Animations (messageId, width, height, duration, fileName, fileId) VALUES (?, ?, ?, ?, ?, ?)";
    $values = [$message->getId(), $message->getWidth(), $message->getHeight(), $message->getDuration(), $message->getFileName(), $message->getFile()->getId()];
    $this->db->query($query, $values);
    $this->db->query('COMMIT');
  }

}
