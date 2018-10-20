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
 * Description of Controller
 *
 * @author Daniele Ambrosino
 */
class Director
{

  private $user;
  private $chat;
  private $message;
  
  public function __construct(string $update)
  {
    /* @var $decodedArray array */
    $decodedArray = json_decode($update, TRUE);
    if ( $decodedArray === NULL )
    {
      throw new MalformedUpdateException();
    }
    
    
  }
  
  public function processRequest()
  {
    
  }

}
