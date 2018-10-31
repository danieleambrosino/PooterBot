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

  protected function genderizeResponses()
  {
    $db = Factory::createDatabase();
    $query = "SELECT 1 FROM FemaleNames WHERE name LIKE ?";
    $values = [strtolower($this->message->getUser()->getFirstName())];
    $result = $db->query($query, $values);
    if ( empty($result) )
    {
      return;
    }
    foreach ($this->responses as &$response)
    {
      if ( $response instanceof TextResponse )
      {
        $text = $response->getText();
        $text = preg_replace('/(car)o/i', '$1a', $text);
        $text = preg_replace('/(amic)o/i', '$1a', $text);
        $text = preg_replace('/(mi)o/i', '$1a', $text);
        $text = str_replace('il furbetto', 'la furbetta', $text);
        $text = str_replace('un grande', 'una grande', $text);
        $response->setText($text);
      }
      elseif ( $response instanceof PhotoResponse )
      {
        $caption = $response->getCaption();
        $caption = preg_replace('/(car)o/i', '$1a', $caption);
        $caption = preg_replace('/(amic)o/i', '$1a', $caption);
        $caption = preg_replace('/(mi)o/i', '$1a', $caption);
        $response->setCaption($caption);
      }
    }
  }

}
