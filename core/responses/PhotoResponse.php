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
 * Description of PhotoResponse
 *
 * @author Daniele Ambrosino
 */
class PhotoResponse extends MultimediaResponse
{

  private $caption;

  public function __construct(Message &$message, string $fileId,
                              string $caption = NULL)
  {
    parent::__construct($message, $fileId);
    $this->caption = $caption;
  }

  public function getCaption()
  {
    return $this->caption;
  }

  public function setCaption($caption)
  {
    $this->caption = $caption;
  }

  public function toMessage(int $id, int $datetime)
  {
    $pooter = Factory::createUserDao()->getMe();
    return new Photo($id, $datetime, $pooter, $this->message->getChat(),
                     $this->fileId, 0, 'image/jpg', 0, 0, $this->caption);
  }

}
