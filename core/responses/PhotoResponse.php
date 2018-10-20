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
 * Description of PhotoResponse
 *
 * @author Daniele Ambrosino
 */
class PhotoResponse extends Response
{

  private $photo;
  private $caption;

  public function __construct(int $chatId, string $photo, string $caption = NULL)
  {
    parent::__construct($chatId);
    $this->photo = $photo;
    $this->caption = $caption;
  }

  public function getPhoto(): string
  {
    return $this->photo;
  }

  public function getCaption()
  {
    return $this->caption;
  }

}
