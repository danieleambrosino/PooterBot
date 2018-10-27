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
 * Description of DocumentDao
 *
 * @author Daniele Ambrosino
 */
abstract class DocumentDao extends MultimediaMessageDao
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
   * @param Document $message
   */
  public function store($message)
  {
    $this->storeMessageByType($message, 'document');
    $this->fileDao->store($message->getFile());
    $query = "INSERT INTO Documents (messageId, fileName, caption, fileId) VALUES (?, ?, ?, ?)";
    $values = [$message->getId(), $message->getFileName(), $message->getCaption(), $message->getFile()->getId()];
    $this->db->query($query, $values);
  }

  public function update($object)
  {
    
  }

}
