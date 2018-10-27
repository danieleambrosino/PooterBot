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

  /**
   *
   * @var User
   */
  private $user;

  /**
   *
   * @var Chat
   */
  private $chat;

  /**
   *
   * @var Message
   */
  private $message;

  /**
   *
   * @var array
   */
  private $responses;

  /**
   *
   * @var Communicator
   */
  private $communicator;

  public function __construct(string $update)
  {
    $decodedUpdate = json_decode($update, TRUE);
    if ( $decodedUpdate === NULL )
    {
      throw new MalformedUpdateException();
    }

    if ( isset($decodedUpdate['message']) )
    {
      $messageArray = $decodedUpdate['message'];
    }
    elseif ( isset($decodedUpdate['edited_message']) )
    {
      $messageArray = $decodedUpdate['edited_message'];
    }
    else
    {
      exit;
    }

    // construct User
    $userArray = $messageArray['from'];
    $this->user = new User($userArray['id'], $userArray['first_name'],
                           isset($userArray['last_name']) ? $userArray['last_name'] : NULL,
                                 isset($userArray['username']) ? $userArray['username'] : NULL);

    // construct Chat
    $chatArray = $messageArray['chat'];
    switch ($chatArray['type'])
    {
      case 'private':
        $this->chat = new PrivateChat($chatArray['id'],
                                      $chatArray['first_name'],
                                      isset($chatArray['last_name']) ? $chatArray['last_name'] : NULL,
                                            isset($chatArray['username']) ? $chatArray['username'] : NULL);
        break;
      case 'group':
        $this->chat = new Group($chatArray['id'], $chatArray['title']);
        break;
      case 'supergroup':
        $this->chat = new Supergroup($chatArray['id'], $chatArray['title'],
                                     isset($chatArray['username']) ? $chatArray['username'] : NULL);
        break;
      case 'channel':
        $this->chat = new Channel($chatArray['id'], $chatArray['title'],
                                  isset($chatArray['username']) ? $chatArray['username'] : NULL);
        break;
      default:
        throw new MalformedUpdateException();
    }

    if ( isset($messageArray['text']) )
    {
      if ( isset($decodedUpdate['message']) )
      {
        $this->message = new TextMessage($messageArray['message_id'],
                                         $messageArray['date'], $this->user,
                                         $this->chat, $messageArray['text']);
      }
      elseif ( isset($decodedUpdate['edited_message']) )
      {
        $this->message = new EditedTextMessage($messageArray['message_id'],
                                               $messageArray['date'],
                                               $this->user, $this->chat,
                                               $messageArray['text']);
      }
    }
    elseif ( isset($messageArray['photo']) )
    {
      $photoSize = $messageArray['photo'][count($messageArray['photo']) - 1];
      $this->message = new Photo($messageArray['message_id'],
                                 $messageArray['date'], $this->user,
                                 $this->chat, $photoSize['file_id'],
                                 $photoSize['file_size'], 'image/jpg',
                                 $photoSize['width'], $photoSize['height'],
                                 isset($messageArray['caption']) ? $messageArray['caption'] : NULL);
    }
    elseif ( isset($messageArray['voice']) )
    {
      $voice = $messageArray['voice'];
      $this->message = new Voice($messageArray['message_id'],
                                 $messageArray['date'], $this->user,
                                 $this->chat, $voice['file_id'],
                                 $voice['file_size'], $voice['mime_type'],
                                 $voice['duration'],
                                 isset($messageArray['caption']) ? $messageArray['caption'] : NULL);
    }
    elseif ( isset($messageArray['audio']) )
    {
      $audio = $messageArray['audio'];
      $this->message = new Audio($messageArray['message_id'],
                                 $messageArray['date'], $this->user,
                                 $this->chat, $audio['file_id'],
                                 $audio['file_size'], $audio['mime_type'],
                                 $audio['duration'],
                                 isset($audio['title']) ? $audio['title'] : NULL,
                                 isset($audio['performer']) ? $audio['performer'] : NULL,
                                 isset($messageArray['caption']) ? $messageArray['caption'] : NULL);
    }
    elseif ( isset($messageArray['video']) )
    {
      $video = $messageArray['video'];
      $this->message = new Video($messageArray['message_id'],
                                 $messageArray['date'], $this->user,
                                 $this->chat, $video['file_id'],
                                 $video['file_size'], $video['mime_type'],
                                 $video['width'], $video['height'],
                                 $video['duration'],
                                 isset($messageArray['caption']) ? $messageArray['caption'] : NULL);
    }
    elseif ( isset($messageArray['video_note']) )
    {
      $videoNote = $messageArray['video_note'];
      $this->message = new VideoNote($messageArray['message_id'],
                                     $messageArray['date'], $this->user,
                                     $this->chat, $videoNote['file_id'],
                                     $videoNote['file_size'],
                                     $videoNote['length'],
                                     $videoNote['duration']);
    }
    elseif ( isset($messageArray['animation']) )
    {
      $animation = $messageArray['animation'];
      $this->message = new Animation($messageArray['message_id'],
                                     $messageArray['date'], $this->user,
                                     $this->chat, $animation['file_id'],
                                     $animation['file_size'],
                                     $animation['mime_type'],
                                     $animation['width'], $animation['height'],
                                     $animation['duration'],
                                     $animation['mime_type']);
    }
    elseif ( isset($messageArray['sticker']) )
    {
      $sticker = $messageArray['sticker'];
      $this->message = new Sticker($messageArray['message_id'],
                                   $messageArray['date'], $this->user,
                                   $this->chat, $sticker['file_id'],
                                   $sticker['file_size'], $sticker['width'],
                                   $sticker['height'], $sticker['emoji'],
                                   $sticker['set_name']);
    }
    elseif ( isset($messageArray['document']) )
    {
      $document = $messageArray['document'];
      $this->message = new Document($messageArray['message_id'],
                                    $messageArray['date'], $this->user,
                                    $this->chat, $document['file_id'],
                                    $document['file_size'],
                                    $document['mime_type'],
                                    $document['file_name'],
                                    isset($messageArray['caption']) ? $messageArray['caption'] : NULL);
    }
    elseif ( isset($messageArray['contact']) )
    {
      $contact = $messageArray['contact'];
      $this->message = new Contact($messageArray['message_id'],
                                   $messageArray['date'], $this->user,
                                   $this->chat, $contact['phone_number'],
                                   $contact['first_name'],
                                   $contact['last_name'], $contact['user_id'],
                                   $contact['vcard']);
    }
    elseif ( isset($messageArray['location']) )
    {
      $location = $messageArray['location'];
      $this->message = new Location($messageArray['message_id'],
                                    $messageArray['date'], $this->user,
                                    $this->chat, $location['latitude'],
                                    $location['longitude']);
    }
    elseif ( isset($messageArray['venue']) )
    {
      // si deve vedere
    }
    elseif ( isset($messageArray['group_chat_created']) )
    {
      $this->message = new ChatCreatedEvent($messageArray['message_id'],
                                            $messageArray['date'], $this->user,
                                            $this->chat);
    }
    elseif ( isset($messageArray['new_chat_members']) )
    {
      $newMembersArray = &$messageArray['new_chat_members'];
      $newMembers = [];
      foreach ($newMembersArray as $newMemberArray)
      {
        $newMembers[] = new User($newMemberArray['id'],
                                 $newMemberArray['first_name'],
                                 isset($newMemberArray['last_name']) ? $newMemberArray['last_name'] : NULL,
                                 isset($newMemberArray['username']) ? $newMemberArray['username'] : NULL);
      }
      $this->message = new ChatMembersAddedEvent($messageArray['message_id'],
                                                 $messageArray['date'],
                                                 $this->user, $this->chat,
                                                 $newMembers);
    }
    elseif ( isset($messageArray['left_chat_member']) )
    {
      $leftMemberArray = &$messageArray['left_chat_member'];
      $leftMember = new User($leftMemberArray['id'],
                             $leftMemberArray['first_name'],
                             isset($leftMemberArray['last_name']) ? $leftMemberArray['last_name'] : NULL,
                             isset($leftMemberArray['username']) ? $leftMemberArray['username'] : NULL);
      $this->message = new ChatMemberRemovedEvent($messageArray['message_id'],
                                                  $messageArray['date'],
                                                  $this->user, $this->chat,
                                                  $leftMember);
    }
    elseif ( isset($messageArray['new_chat_title']) )
    {
      $this->message = new ChatTitleChangedEvent($messageArray['message_id'],
                                                 $messageArray['date'],
                                                 $this->user, $this->chat,
                                                 $messageArray['new_chat_title']);
    }
    elseif ( isset($messageArray['new_chat_photo']) )
    {
      $newPhotoArray = &$messageArray['new_chat_photo'][count($messageArray['new_chat_photo']) - 1];
      $newPhoto = new Photo($messageArray['message_id'], $messageArray['date'],
                            $this->user, $this->chat, $newPhotoArray['file_id'],
                            $newPhotoArray['file_size'], 'image/jpg',
                            $newPhotoArray['width'], $newPhotoArray['height']);
      $this->message = new ChatPhotoChangedEvent($messageArray['message_id'],
                                                 $messageArray['date'],
                                                 $this->user, $this->chat,
                                                 $newPhoto);
    }
    elseif ( isset($messageArray['delete_chat_photo']) )
    {
      $this->message = new ChatPhotoDeletedEvent($messageArray['message_id'],
                                                 $messageArray['date'],
                                                 $this->user, $this->chat);
    }
    else
    {
      throw new ErrorException();
    }

    $this->communicator = Factory::createCommunicator();
    $this->responses = [];
  }

  public function handleUpdate()
  {
    $responders = [];
    if ( $this->message instanceof TextMessage )
    {
      $responders[] = new TextResponder($this->message);
    }
    elseif ( $this->message instanceof Photo )
    {
      $responders[] = new PhotoResponder($this->message);
    }
    elseif ( $this->message instanceof ChatEvent )
    {
      $responders[] = new ChatEventResponder($this->message);
    }

    if ( $this->message instanceof EditedTextMessage )
    {
      $responders[] = new EditedTextMessageResponder($this->message);
    }

    foreach ($responders as $responder)
    {
      $responder->evaluateResponse();
      $responses = $responder->getResponses();
      foreach ($responses as &$response)
      {
        $this->responses[] = $response;
      }
    }
    foreach ($this->responses as &$response)
    {
      $response = $this->sendResponse($response);
    }
  }

  public function storeData()
  {
    $userDao = Factory::createUserDao();

    /* @var $chatDao ChatDao */
    $chatDao = NULL;
    if ( $this->chat instanceof PrivateChat )
    {
      $chatDao = Factory::createPrivateChatDao();
    }
    elseif ( $this->chat instanceof Group )
    {
      $chatDao = Factory::createGroupDao();
    }
    elseif ( $this->chat instanceof Supergroup )
    {
      $chatDao = Factory::createSupergroupDao();
    }
    elseif ( $this->chat instanceof Channel )
    {
      $chatDao = Factory::createChannelDao();
    }

    try
    {
      $oldUser = $userDao->get($this->user->getId());
      if ( $this->user != $oldUser )
      {
        $userDao->update($this->user);
      }
    }
    catch (ResourceNotFoundException $exc)
    {
      $userDao->store($this->user);
    }

    try
    {
      $oldChat = $chatDao->get($this->chat->getId());
      if ( $this->chat != $oldChat )
      {
        $chatDao->update($this->chat);
      }
    }
    catch (ResourceNotFoundException $exc)
    {
      $chatDao->store($this->chat);
    }

    $this->storeMessage($this->message);
    foreach ($this->responses as &$message)
    {
      $this->storeMessage($message);
    }
  }

  private function sendResponse(Response $response): Message
  {
    if ( $response instanceof TextResponse )
    {
      return $this->communicator->sendMessage($response);
    }
    if ( $response instanceof PhotoResponse )
    {
      return $this->communicator->sendPhoto($response);
    }
    if ( $response instanceof VoiceResponse )
    {
      return $this->communicator->sendVoice($response);
    }
  }

  private function storeMessage(Message &$message)
  {
    /* @var $messageDao MessageDao */
    $messageDao = NULL;
    if ( $message instanceof TextMessage )
    {
      $messageDao = Factory::createTextMessageDao();
    }
    elseif ( $message instanceof Sticker )
    {
      $messageDao = Factory::createStickerDao();
    }
    elseif ( $message instanceof Photo )
    {
      $messageDao = Factory::createPhotoDao();
    }
    elseif ( $message instanceof Animation )
    {
      $messageDao = Factory::createAnimationDao();
    }
    elseif ( $message instanceof Voice )
    {
      $messageDao = Factory::createVoiceDao();
    }
    elseif ( $message instanceof Audio )
    {
      $messageDao = Factory::createAudioDao();
    }
    elseif ( $message instanceof Video )
    {
      $messageDao = Factory::createVideoDao();
    }
    elseif ( $message instanceof Document )
    {
      $messageDao = Factory::createDocumentDao();
    }
    elseif ( $message instanceof VideoNote )
    {
      $messageDao = Factory::createVideoNoteDao();
    }
    elseif ( $message instanceof Contact )
    {
      $messageDao = Factory::createContactDao();
    }
    elseif ( $message instanceof Location )
    {
      $messageDao = Factory::createLocationDao();
    }
    elseif ( $message instanceof Venue )
    {
      $messageDao = Factory::createVenueDao();
    }
    elseif ( $message instanceof ChatCreatedEvent )
    {
      $messageDao = Factory::createChatCreatedEventDao();
    }
    elseif ( $message instanceof ChatMembersAddedEvent )
    {
      $messageDao = Factory::createChatMembersAddedEventDao();
    }
    elseif ( $message instanceof ChatMemberRemovedEvent )
    {
      $messageDao = Factory::createChatMemberRemovedEventDao();
    }
    else
    {
      return;
    }

    $messageDao->store($message);
  }

}
