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
 * Description of Responder
 *
 * @author Daniele Ambrosino
 */
abstract class Responder
{

  /**
   *
   * @var Message
   */
  protected $message;
  /**
   *
   * @var array
   */
  protected $responses;
  /**
   *
   * @var Resources
   */
  protected $resources;
  
  public function __construct(Message &$message)
  {
    $this->responses = [];
    $this->resources = Factory::createResources();
    $this->message = $message;
  }

  public abstract function evaluateResponse();

  public final function getResponses(): array
  {
    return $this->responses;
  }

}
