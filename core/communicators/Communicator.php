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
 * Description of Communicator
 *
 * @author Daniele Ambrosino
 */
abstract class Communicator
{

  /**
   * @return TextMessage
   */
  public abstract function sendMessage(TextResponse &$response): TextMessage;

  /**
   * @return Photo
   */
  public abstract function sendPhoto(PhotoResponse &$response): Photo;

  /**
   * @return Voice
   */
  public abstract function sendVoice(VoiceResponse &$response): Voice;

  /**
   * @return ChatMemberRemovedEvent
   */
  public abstract function leaveGroup(LeaveGroupResponse &$response): ChatMemberRemovedEvent;
}
