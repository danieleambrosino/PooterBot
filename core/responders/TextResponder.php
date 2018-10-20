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
 * Description of TextResponder
 *
 * @author Daniele Ambrosino
 */
class TextResponder extends Responder
{

  private $text;

  public function __construct(TextMessage $message)
  {
    parent::__construct();
    $this->message = $message;
    $this->text = $message->getText();
  }

  public function evaluateResponse()
  {
    if ( substr($this->text, 0, 1) === '/' )
    {
      $this->evaluateCommand();
    }
    else
    {
      $this->evaluatePhrase();
    }
    $this->genderizeResponses();
  }

  private function evaluateCommand()
  {
    $command = substr($this->text, 1);
    switch ($command)
    {
      case 'start':
        $this->responses[] = new TextResponse($chatId, $text);
        break;
      case 'foto':

        break;
      case 'audio':

        break;
      case 'proverbio':

        break;
      case 'barzelletta':

        break;

      default:
        break;
    }
  }

  private function evaluatePhrase()
  {
    
  }

  private function genderizeResponses()
  {
    $db = Factory::createDatabase();
    $query = "SELECT 1 FROM FemaleNames WHERE name = ?";
    $values = [$this->message->getUser()->getFirstName()];
    $result = $db->query($query, $values);
    if ( empty($result) )
    {
      return;
    }
    foreach ($this->responses as &$response)
    {
      $text = $response->getText();
      $text = preg_replace('/(car)o/i', '$1a', $text);
      $text = preg_replace('/(amic)o/i', '$1a', $text);
      $text = preg_replace('/(mi)o/i', '$1a', $text);
      $response->setText($text);
    }
  }

}
