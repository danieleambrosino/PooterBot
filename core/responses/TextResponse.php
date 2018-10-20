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
 * Description of TextResponse
 *
 * @author Daniele Ambrosino
 */
class TextResponse extends Response
{

  private $text;

  public function __construct(int $chatId, string $text)
  {
    parent::__construct($chatId);
    $this->text = $text;
  }

  public function getText(): string
  {
    return $this->text;
  }

  public function setText($text)
  {
    $this->text = $text;
  }

}
