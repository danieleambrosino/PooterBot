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
 * Description of Document
 *
 * @author Daniele Ambrosino
 */
class Document extends MultimediaMessage
{

  private $fileName;
  private $caption;

  public function __construct(int $id, int $datetime, User &$user, Chat &$chat,
                              string $fileId, $fileSize, $mimeType, $fileName,
                              $caption)
  {
    parent::__construct($id, $datetime, $user, $chat, $fileId, $fileSize,
                        $mimeType);
    $this->fileName = $fileName;
    $this->caption = $caption;
  }

  public function getFileName()
  {
    return $this->fileName;
  }

  public function getCaption()
  {
    return $this->caption;
  }

}
