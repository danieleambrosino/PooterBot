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
                              string $fileId, int $fileSize, string $mimeType)
  {
    parent::__construct($id, $datetime, $user, $chat);
    $this->fileId = $fileId;
    $this->fileSize = $fileSize;
    $this->mimeType = $mimeType;
  }

  public function getFile()
  {
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

  protected function downloadFile()
  {
    // TODO implement
  }

  protected function retrieveFileFromDatabase()
  {
    // TODO implement
  }

}
