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
 * Description of Photo
 *
 * @author Daniele Ambrosino
 */
class Photo extends MultimediaMessage
{

  private $width;
  private $height;
  private $caption;

  public function __construct(int $id, int $datetime, User &$user, Chat &$chat,
                              string $fileId, $fileSize, string $mimeType,
                              int $width, int $height, $caption = NULL)
  {
    parent::__construct($id, $datetime, $user, $chat, $fileId, $fileSize, $mimeType);
    $this->width = $width;
    $this->height = $height;
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

  public function getCaption()
  {
    return $this->caption;
  }

}
