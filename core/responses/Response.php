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
 * Description of Response
 *
 * @author Daniele Ambrosino
 */
abstract class Response
{

  private $chatId;

  /**
   * 
   * @param int $chatId
   */
  public function __construct(int $chatId)
  {
    $this->chatId = $chatId;
  }

  public function getChatId(): int
  {
    return $this->chatId;
  }

}
