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
 * Description of NewChatPhotoEvent
 *
 * @author Daniele Ambrosino
 */
class ChatPhotoChangedEvent extends ChatEvent
{

  /**
   *
   * @var File
   */
  private $newPhoto;

  public function __construct(int $id, int $datetime, User &$user, Chat &$chat,
                              File &$newPhoto)
  {
    parent::__construct($id, $datetime, $user, $chat);
    $this->newPhoto = $newPhoto;
  }

  public function getNewPhoto(): File
  {
    return $this->newPhoto;
  }

}
