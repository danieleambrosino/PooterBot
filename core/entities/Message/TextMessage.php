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
 * Description of TextMessage
 *
 * @author Daniele Ambrosino
 */
class TextMessage extends Message
{

  private $text;

  public function __construct(int $id, int $datetime, User &$user, Chat &$chat,
                              string $text)
  {
    parent::__construct($id, $datetime, $user, $chat);
    $this->text = $text;
  }

  public function getText()
  {
    return $this->text;
  }

}
