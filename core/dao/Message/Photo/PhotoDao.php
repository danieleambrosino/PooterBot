<?php

/*
 * This file is part of the PooterBot project.
 * 
 * (c) 2018 Daniele Ambrosino <mail@danieleambrosino.it>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file distributed with this source code.
 */
require_once realpath(__DIR__ . '/../../../../vendor/autoload.php');
/**
 * Description of PhotoDao
 *
 * @author Daniele Ambrosino
 */
abstract class PhotoDao extends MultimediaMessageDao
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

  public function get(int $id)
  {
    $query = <<<SQL
SELECT *
FROM Messages M
  JOIN Photos P ON M.id = P.messageId
WHERE M.id = ?
SQL;
    $values = [$id];
    $this->db->query($query, $values);
  }

  /**
   * 
   * @param Photo $message
   */
  public function store($message)
  {
    $this->storeMessageByType($message, 'photo');
    $this->storeFile($message->getFileId(), $message->getFile(),
                     $message->getFileSize(), $message->getMimeType());
    $query = "INSERT INTO Photos (messageId, width, height, caption, fileId) VALUES (?, ?, ?, ?, ?)";
    $values = [$message->getId(), $message->getWidth(), $message->getHeight(), $message->getCaption(), $message->getFileId()];
    $this->db->query($query, $values);
  }

  public function update($object)
  {
    
  }

  protected function constructObject(array $data)
  {
    
  }

}
