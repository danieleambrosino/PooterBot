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
 * Description of VideoNote
 *
 * @author Daniele Ambrosino
 */
class VideoNote extends MultimediaMessage
{

  private $length;
  private $duration;

  public function __construct(int $id, int $datetime, User $user, Chat $chat,
                              string $fileId, int $fileSize, string $mimeType,
                              int $length, int $duration)
  {
    parent::__construct($id, $datetime, $user, $chat, $fileId, $fileSize,
                        $mimeType);
    $this->length = $length;
    $this->duration = $duration;
  }

  public function getLength()
  {
    return $this->length;
  }

  public function getDuration()
  {
    return $this->duration;
  }

}
