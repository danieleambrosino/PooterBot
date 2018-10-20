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
 * Description of Animation
 *
 * @author Daniele Ambrosino
 */
class Animation extends MultimediaMessage
{

  private $width;
  private $height;
  private $duration;
  private $fileName;

  public function __construct(int $id, int $datetime, User $user, Chat $chat,
                              string $fileId, int $fileSize, string $mimeType,
                              int $width, int $height, int $duration,
                              string $fileName)
  {
    parent::__construct($id, $datetime, $user, $chat, $fileId, $fileSize,
                        $mimeType);
    $this->width = $width;
    $this->height = $height;
    $this->duration = $duration;
    $this->fileName = $fileName;
  }

}
