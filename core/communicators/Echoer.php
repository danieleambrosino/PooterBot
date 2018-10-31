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
 * Description of Echoer
 *
 * @author Daniele Ambrosino
 */
class Echoer extends Communicator
{

  public function sendMessage(TextResponse &$response): TextMessage
  {
    echo $response->getText();
    return $response->toMessage(rand(), time());
  }

  public function sendPhoto(PhotoResponse &$response): Photo
  {
    echo $response->getFileId() . ', ' . $response->getCaption();
    return $response->toMessage(rand(), time());
  }

  public function sendVoice(VoiceResponse &$response): Voice
  {
    echo $response->getFileId();
    return $response->toMessage(rand(), time());
  }

  public function leaveGroup(LeaveGroupResponse &$response): ChatMemberRemovedEvent
  {
    echo "Pooter ha abbandonato la chat {$response->getMessage()->getChat()->getId()}";
    return $response->toMessage(rand(), time());
  }

}
