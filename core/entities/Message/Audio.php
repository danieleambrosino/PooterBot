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
 * Description of Audio
 *
 * @author Daniele Ambrosino
 */
class Audio extends MultimediaMessage
{

  private $duration;
  private $title;
  private $performer;
  private $caption;

  public function __construct(int $id, int $datetime, User $user, Chat $chat,
                              string $fileId, int $fileSize, string $mimeType,
                              int $duration, string $title, string $performer,
                              string $caption)
  {
    parent::__construct($id, $datetime, $user, $chat, $fileId, $fileSize,
                        $mimeType);
    $this->duration = $duration;
    $this->title = $title;
    $this->performer = $performer;
    $this->caption = $caption;
  }

  public function getDuration()
  {
    return $this->duration;
  }

  public function getTitle()
  {
    return $this->title;
  }

  public function getPerformer()
  {
    return $this->performer;
  }

  public function getCaption()
  {
    return $this->caption;
  }

}
