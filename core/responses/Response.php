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

  /**
   *
   * @var Message
   */
  protected $message;

  /**
   * 
   * @param Chat $chat
   */
  public function __construct(Message &$message)
  {
    $this->message = $message;
  }

  public final function getMessage(): Message
  {
    return $this->message;
  }

  public abstract function toMessage(int $id, int $datetime);
}
