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
 * Description of Group
 *
 * @author Daniele Ambrosino
 */
class Group extends Chat
{

  /**
   *
   * @var string
   */
  protected $title;

  /**
   * 
   * @param int $id
   * @param string $title
   */
  public function __construct(int $id, string $title)
  {
    parent::__construct($id);
    $this->title = $title;
  }

  public function getTitle(): string
  {
    return $this->title;
  }

  public function setTitle(string $title)
  {
    $this->title = $title;
  }

}
