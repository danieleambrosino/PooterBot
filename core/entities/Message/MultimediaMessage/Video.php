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
 * Description of Video
 *
 * @author Daniele Ambrosino
 */
class Video extends MultimediaMessage
{

  private $width;
  private $height;
  private $duration;
  private $caption;

  public function __construct(int $id, int $datetime, User &$user, Chat &$chat,
                              string $fileId, $fileSize, $mimeType, int $width,
                              int $height, int $duration, $caption)
  {
    parent::__construct($id, $datetime, $user, $chat, $fileId, $fileSize,
                        $mimeType);
    $this->width = $width;
    $this->height = $height;
    $this->duration = $duration;
    $this->caption = $caption;
  }

  public function getWidth()
  {
    return $this->width;
  }

  public function getHeight()
  {
    return $this->height;
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
