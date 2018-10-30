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
 * Description of EditedTextMessageResponder
 *
 * @author Daniele Ambrosino
 */
class EditedTextMessageResponder extends Responder
{

  /**
   *
   * @var EditedTextMessage
   */
  private $editedMessage;

  public function __construct(EditedTextMessage &$editedMessage)
  {
    parent::__construct($editedMessage);
    $this->editedMessage = $editedMessage;
  }

  public function evaluateResponse()
  {
    $messageDao = Factory::createTextMessageDao();
    try
    {
      /* @var $oldMessage Message */
      $oldMessage = $messageDao->getMessage($this->editedMessage);
    }
    catch (ResourceNotFoundException $exc)
    {
      return;
    }
    $text = <<<TXT
Non fare il furbetto, amico mio, avevi scritto:
"{$oldMessage->getText()}"
TXT;
    $this->responses[] = new TextResponse($this->editedMessage, $text);
  }

}
