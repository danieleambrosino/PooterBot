<?php

/*
 * This file is part of the PooterBot project.
 * 
 * (c) 2018 Daniele Ambrosino <mail@danieleambrosino.it>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file distributed with this source code.
 */
require_once realpath(__DIR__ . '/../../../../vendor/autoload.php');
/**
 * Description of MultimediaMessage
 *
 * @author Daniele Ambrosino
 */
abstract class MultimediaMessage extends Message
{

  /**
   *
   * @var File
   */
  protected $file;

  public function __construct(int $id, int $datetime, User &$user, Chat &$chat,
                              string $fileId, $fileSize, $mimeType)
  {
    parent::__construct($id, $datetime, $user, $chat);
    $this->file = new File($fileId, $fileSize, $mimeType);
  }

  public function getFile()
  {
    return $this->file;
  }

}
