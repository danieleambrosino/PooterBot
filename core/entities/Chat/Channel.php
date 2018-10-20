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
 * Description of Channel
 *
 * @author Daniele Ambrosino
 */
class Channel extends Chat
{
  private $title;
  private $username;
  
  public function __construct(int $id, string $title, string $username = NULL)
  {
    parent::__construct($id);
    $this->title = $title;
    $this->username = $username;
  }

}
