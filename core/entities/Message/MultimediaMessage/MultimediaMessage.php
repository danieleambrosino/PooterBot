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
 * Description of MultimediaMessage
 *
 * @author Daniele Ambrosino
 */
abstract class MultimediaMessage extends Message
{

  protected $file;
  protected $fileId;
  protected $fileSize;
  protected $mimeType;

  public function __construct(int $id, int $datetime, User &$user, Chat &$chat,
                              string $fileId, $fileSize, $mimeType)
  {
    parent::__construct($id, $datetime, $user, $chat);
    $this->fileId = $fileId;
    $this->fileSize = $fileSize;
    $this->mimeType = $mimeType;
  }

  public function getFile()
  {
    if ( NULL === $this->file )
    {
      $this->loadFile();
    }
    return $this->file;
  }

  public function getFileId()
  {
    return $this->fileId;
  }

  public function getFileSize()
  {
    return $this->fileSize;
  }

  public function getMimeType()
  {
    return $this->mimeType;
  }

  protected final function loadFile()
  {
    $query = "SELECT content FROM Files WHERE id = ?";
    $values = [$this->fileId];
    $db = Factory::createDatabase();
    $data = $db->query($query, $values);
    if ( empty($data) )
    {
      $this->file = FileDownloader::downloadFile($this->fileId);
    }
    else
    {
      $this->file = $data[0]['content'];
    }
  }

}
