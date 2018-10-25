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
 * Description of VoiceResponse
 *
 * @author Daniele Ambrosino
 */
class VoiceResponse extends Response
{

  /**
   *
   * @var string
   */
  private $fileId;

  /**
   *
   * @var string
   */
  private $caption;

  public function __construct(Message &$message, string $fileId, $caption = NULL)
  {
    parent::__construct($message);
    $this->fileId = $fileId;
    $this->caption = $caption;
  }

  public function getFileId(): string
  {
    return $this->fileId;
  }

  public function getCaption()
  {
    return $this->caption;
  }

  public function toMessage(int $id, int $datetime)
  {
    $pooter = Factory::createUserDao()->getMe();
    return new Voice($id, $datetime, $pooter, $this->message->getChat(),
                     $this->fileId, 0, 'audio/ogg', 0, $this->caption);
  }

}
