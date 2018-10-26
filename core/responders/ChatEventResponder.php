<?php

/*
 * This file is part of the PooterBot project.
 * 
 * (c) 2018 Daniele Ambrosino <mail@danieleambrosino.it>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file distributed with this source code.
 */
require_once realpath(__DIR__ . '/../../vendor/autoload.php');

/**
 * Description of GroupEventResponder
 *
 * @author Daniele Ambrosino
 */
class ChatEventResponder extends Responder
{

  /**
   *
   * @var ChatEvent
   */
  private $groupEvent;

  public function __construct(ChatEvent &$groupEvent)
  {
    parent::__construct($groupEvent);
    $this->groupEvent = $groupEvent;
  }

  public function evaluateResponse()
  {
    if ( $this->groupEvent instanceof ChatCreatedEvent )
    {
      $text = "Questo gruppo è incredibile, e solo il mio grande amico {$this->groupEvent->getUser()->getFirstName()} poteva crearlo";
      $this->responses[] = new TextResponse($this->groupEvent, $text);
    }
    elseif ( $this->groupEvent instanceof NewChatMembersEvent )
    {
      $newMembers = $this->groupEvent->getNewMembers();
      $newMembersIds = [];
      foreach ($newMembers as $member)
      {
        $newMembersIds[] = $member->getId();
      }
      if ( in_array(TELEGRAM_BOT_ID, $newMembersIds) )
      {
        $text = "{$this->groupEvent->getUser()->getFirstName()}, grande amico mio, grazie per avermi aggiunto a questo incredibile gruppo";
        $this->responses[] = new TextResponse($this->groupEvent, $text);
        $text = "Che fate di bello stasera, ragazzi?";
      }
      elseif ( count($newMembers) > 1 )
      {
        $text = 'Benvenuti ragazzi, che fate di bello stasera?';
      }
      else
      {
        $newMemberName = $newMembers[0]->getFirstName();
        $text = "Ciao $newMemberName, che fai di bello stasera?";
      }
      $this->responses[] = new TextResponse($this->groupEvent, $text);
    }
    elseif ( $this->groupEvent instanceof LeftChatMemberEvent )
    {
      $text = "Non è mai bello quando le persone lasciano un gruppo";
      $this->responses[] = new TextResponse($this->groupEvent, $text);
    }
    elseif ( $this->groupEvent instanceof ChatTitleChangedEvent )
    {
      $text = <<<TXT
"{$this->groupEvent->getNewTitle()}" è un bellissimo nome, mio caro amico {$this->groupEvent->getUser()->getFirstName()}, ma mi piaceva di più "{$this->groupEvent->getChat()->getTitle()}"
TXT;
      $this->responses[] = new TextResponse($this->groupEvent, $text);
      $this->groupEvent->getChat()->setTitle($this->groupEvent->getNewTitle());
    }
    elseif ( $this->groupEvent instanceof ChatPhotoChangedEvent )
    {
      $text = "Bellissima questa nuova foto, amico mio";
      $this->responses[] = new TextResponse($this->groupEvent, $text);
    }
    elseif ( $this->groupEvent instanceof ChatPhotoDeletedEvent )
    {
      $text = "Era una bellissima foto amico mio, perché l'hai tolta?";
      $this->responses[] = new TextResponse($this->groupEvent, $text);
    }
  }

}
