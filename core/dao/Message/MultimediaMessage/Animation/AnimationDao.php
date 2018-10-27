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
 * Description of AnimationDao
 *
 * @author Daniele Ambrosino
 */
abstract class AnimationDao extends MultimediaMessageDao
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

  //put your code here
  protected function constructObject(array $data)
  {
    
  }

  public function get($id)
  {
    
  }

  /**
   * 
   * @param Animation $message
   */
  public function store($message)
  {
    $this->db->query('BEGIN TRANSACTION');
    $this->storeMessageByType($message, 'animation');
    $this->fileDao->store($message->getFile());
    $query = "INSERT INTO Animations (messageId, width, height, duration, fileName, fileId) VALUES (?, ?, ?, ?, ?, ?)";
    $values = [$message->getId(), $message->getWidth(), $message->getHeight(), $message->getDuration(), $message->getFileName(), $message->getFile()->getId()];
    $this->db->query($query, $values);
    $this->db->query('COMMIT');
  }

  public function update($object)
  {
    
  }

}
