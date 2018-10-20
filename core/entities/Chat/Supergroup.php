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
 * Description of Supergroup
 *
 * @author Daniele Ambrosino
 */
class Supergroup extends Chat
{

  /**
   *
   * @var string
   */
  private $title;

  /**
   *
   * @var string
   */
  private $username;

  /**
   * 
   * @param int $id
   * @param string $title
   * @param string $username
   */
  public function __construct(int $id, string $title, $username)
  {
    parent::__construct($id);
    $this->title = $title;
    $this->username = $username;
  }

  public function getTitle(): string
  {
    return $this->title;
  }

  public function getUsername()
  {
    return $this->username;
  }

}
