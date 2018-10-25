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
    /* @var $decodedUpdate array */
    $decodedUpdate = json_decode($update, TRUE);
    if ( $decodedUpdate === NULL )
    {
      throw new MalformedUpdateException();
    }

    /* @var $messageArray array */
    $messageArray = $decodedUpdate['message'];

    /* @var $userArray array */
    $userArray = $messageArray['from'];
    $this->user = new User($userArray['id'], $userArray['first_name'],
                           $userArray['last_name'], $userArray['username']);

    /* @var $chatArray array */
    $chatArray = $messageArray['chat'];
    switch ($chatArray['type'])
    {
      case 'private':
        $this->chat = new PrivateChat($chatArray['id'],
                                      $chatArray['first_name'],
                                      $chatArray['last_name'],
                                      $chatArray['username']);
        break;
      case 'group':
        $this->chat = new Group($chatArray['id'], $chatArray['title']);
        break;
      case 'supergroup':
        $this->chat = new Supergroup($chatArray['id'], $chatArray['title'],
                                     $chatArray['username']);
        break;
      case 'channel':
        $this->chat = new Channel($chatArray['id'], $chatArray['title'],
                                  $chatArray['username']);
        break;
      default:
        throw new MalformedUpdateException();
    }

    if ( isset($messageArray['text']) )
    {
      $this->message = new TextMessage($messageArray['message_id'],
                                       $messageArray['date'], $this->user,
                                       $this->chat, $messageArray['text']);
    }
    elseif ( isset($messageArray['photo']) )
    {
      $photoSize = $messageArray['photo'][count($messageArray['photo']) - 1];
      $this->message = new Photo($messageArray['message_id'],
                                 $messageArray['date'], $this->user,
                                 $this->chat, $photoSize['file_id'],
                                 $photoSize['file_size'], 'image/jpg',
                                 $photoSize['width'], $photoSize['height'],
                                 $messageArray['caption']);
    }
    elseif ( isset($messageArray['voice']) )
    {
      $voice = $messageArray['voice'];
      $this->message = new Voice($messageArray['message_id'],
                                 $messageArray['date'], $this->user,
                                 $this->chat, $voice['file_id'],
                                 $voice['file_size'], $voice['mime_type'],
                                 $voice['duration'], $messageArray['caption']);
    }
    elseif ( isset($messageArray['audio']) )
    {
      $audio = $messageArray['audio'];
      $this->message = new Audio($messageArray['message_id'],
                                 $messageArray['date'], $this->user,
                                 $this->chat, $audio['file_id'],
                                 $audio['file_size'], $audio['mime_type'],
                                 $audio['duration'], $audio['title'],
                                 $audio['performer'], $messageArray['caption']);
    }
    elseif ( isset($messageArray['video']) )
    {
      $video = $messageArray['video'];
      $this->message = new Video($messageArray['message_id'],
                                 $messageArray['date'], $this->user,
                                 $this->chat, $video['file_id'],
                                 $video['file_size'], $video['mime_type'],
                                 $video['width'], $video['height'],
                                 $video['duration'], $messageArray['caption']);
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
                                    $messageArray['caption']);
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

    $this->communicator = Factory::createCommunicator();
    $this->responses = [];
  }

  public function handleUpdate()
  {
    if ( $this->message instanceof TextMessage )
    {
      $responder = new TextResponder($this->message);
    }
    elseif ( $this->message instanceof Photo )
    {
      $responder = new PhotoResponder($this->message);
    }
    else
    {
      return;
    }

    $responder->evaluateResponse();
    /* @var $responses array */
    $this->responses = $responder->getResponses();
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
    
    $messageDao->store($message);
  }

}
