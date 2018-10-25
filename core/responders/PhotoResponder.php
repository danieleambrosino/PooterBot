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
 * Description of PhotoResponder
 *
 * @author Daniele Ambrosino
 */
class PhotoResponder extends Responder
{

  /**
   * 
   * @param Photo $message
   */
  public function __construct(&$message)
  {
    parent::__construct($message);
  }

  public function evaluateResponse()
  {
    $comment = $this->resources->getRandomPhotoComment();
    $this->responses[] = new TextResponse($this->message, $comment);
  }

}
