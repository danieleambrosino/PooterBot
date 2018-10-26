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
 * Description of VideoDao
 *
 * @author Daniele Ambrosino
 */
abstract class VideoDao extends MultimediaMessageDao
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

  public function get(int $id)
  {
    
  }

  /**
   * 
   * @param Video $message
   */
  public function store($message)
  {
    $this->storeMessageByType($message, 'video');
    $this->storeFile($message->getFileId(), $message->getFile(),
                     $message->getFileSize(), $message->getMimeType());
    $query = "INSERT INTO Videos (messageId, width, height, duration, caption, fileId) VALUES (?, ?, ?, ?, ?, ?)";
    $values = [$message->getId(), $message->getWidth(), $message->getHeight(), $message->getDuration(), $message->getCaption(), $message->getFileId()];
    $this->db->query($query, $values);
  }

  public function update($object)
  {
    
  }

}
