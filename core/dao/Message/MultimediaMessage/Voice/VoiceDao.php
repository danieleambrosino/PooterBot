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
 * Description of VoiceDao
 *
 * @author Daniele Ambrosino
 */
abstract class VoiceDao extends MultimediaMessageDao
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

  protected function constructObject(array $data)
  {
    
  }

  public function get($id)
  {
    
  }

  /**
   * 
   * @param Voice $message
   */
  public function store($message)
  {
    $this->storeMessageByType($message, 'voice');
    $this->fileDao->store($message->getFile());
    $query = "INSERT INTO Voices (messageId, duration, caption, fileId) VALUES (?, ?, ?, ?)";
    $values = [$message->getId(), $message->getDuration(), $message->getCaption(), $message->getFile()->getId()];
    $this->db->query($query, $values);
  }

  public function update($object)
  {
    
  }

}
