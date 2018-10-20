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
 * Description of Voice
 *
 * @author Daniele Ambrosino
 */
class Voice extends MultimediaMessage
{

  private $duration;
  private $caption;

  public function __construct(int $id, int $datetime, User $user, Chat $chat,
                              string $fileId, int $fileSize, string $mimeType,
                              int $duration, string $caption)
  {
    parent::__construct($id, $datetime, $user, $chat, $fileId, $fileSize,
                        $mimeType);
    $this->duration = $duration;
    $this->caption = $caption;
  }

  public function getDuration()
  {
    return $this->duration;
  }

  public function getCaption()
  {
    return $this->caption;
  }

}
