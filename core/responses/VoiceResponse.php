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

  private $voice;

  public function __construct(int $chatId, string $voice)
  {
    parent::__construct($chatId);
    $this->voice = $voice;
  }

}
