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
 * Description of MultimediaResponse
 *
 * @author Daniele Ambrosino
 */
abstract class MultimediaResponse extends Response
{

  protected $fileId;

  public function __construct(Message &$message, string $fileId)
  {
    parent::__construct($message);
    $this->fileId = $fileId;
  }

  public final function getFileId(): string
  {
    return $this->fileId;
  }

}
