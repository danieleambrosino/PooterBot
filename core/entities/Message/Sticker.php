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
 * Description of Sticker
 *
 * @author Daniele Ambrosino
 */
class Sticker extends MultimediaMessage
{

  private $width;
  private $height;
  private $emoji;
  private $setName;

  public function __construct(int $id, int $datetime, User $user, Chat $chat,
                              string $fileId, int $fileSize, string $mimeType,
                              int $width, int $height, string $emoji,
                              string $setName)
  {
    parent::__construct($id, $datetime, $user, $chat, $fileId, $fileSize,
                        $mimeType);
    $this->width = $width;
    $this->height = $height;
    $this->emoji = $emoji;
    $this->setName = $setName;
  }

  public function getWidth()
  {
    return $this->width;
  }

  public function getHeight()
  {
    return $this->height;
  }

  public function getEmoji()
  {
    return $this->emoji;
  }

  public function getSetName()
  {
    return $this->setName;
  }

}
