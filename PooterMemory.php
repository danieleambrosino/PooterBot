<?php

include 'types.php';
/**
 * Created by IntelliJ IDEA.
 * User: dani
 * Date: 29/05/17
 * Time: 14.34
 */
class PooterMemory
{
  /**
   * @var mysqli Database handle.
   */
  private $database;

  /**
   * PooterMemory constructor.
   */
  public function __construct()
  {
    $this->database = new mysqli('', '', '', 'my_pooterbot');
  }

  ###########
  # GETTERS #
  ###########

  /**
   * Checks if Pooter knows the specified user.
   *
   * @param int $user_id Telegram user id.
   * @return bool
   */
  private function knows_user($user_id)
  {
    $query = "SELECT id FROM senders WHERE telegram_id = $user_id";
    return $this->database->query($query)->num_rows > 0;
  }

  /**
   * Checks if Pooter knows the specified chat.
   *
   * @param int $chat_id Telegram chat id.
   * @return bool
   */
  private function knows_chat($chat_id)
  {
    $query = "SELECT id FROM chats WHERE telegram_id = $chat_id";
    return $this->database->query($query)->num_rows > 0;
  }

  /**
   * Returns sender id stored in database.
   *
   * @param array $user
   * @return int
   */
  private function get_sender_id($user)
  {
    $user_id = $user['id'];
    if (!$this->knows_user($user_id))
    {
      $this->add_sender($user);
    }

    $query = "SELECT id FROM senders WHERE telegram_id = $user_id";
    return $this->database->query($query)->fetch_row()[0];
  }

  /**
   * Returns chat id stored in database.
   *
   * @param mixed $chat
   * @return int
   */
  private function get_chat_id($chat)
  {
    $chat_id = $chat['id'];
    if (!$this->knows_chat($chat_id))
    {
      $this->add_chat($chat);
    }

    $query = "SELECT id FROM chats WHERE telegram_id = $chat_id";
    return $this->database->query($query)->fetch_row()[0];
  }

  /**
   * Translates default message type to string (for database).
   *
   * @param int $type Type to be translated.
   * @return null|string
   */
  private function get_message_type($type)
  {
    switch ($type)
    {
      case (MessageType::TEXT):
        return 'text';
      case (MessageType::PHOTO):
        return 'photo';
      case (MessageType::AUDIO):
        return 'audio';
      case (MessageType::DOCUMENT):
        return 'document';
      case (MessageType::STICKER):
        return 'sticker';
      case (MessageType::VOICE):
        return 'voice';
      case (MessageType::VIDEO):
        return 'video';
      case (MessageType::VIDEO_NOTE):
        return 'video_note';
      case (MessageType::CONTACT):
        return 'contact';
      case (MessageType::LOCATION):
        return 'location';
      default:
        return NULL;
    }
  }

  /**
   * Returns specific content depending on message type.
   *
   * @param array $message Message to be analyzed.
   * @param int   $type    Detected type.
   * @return null|string
   */
  private function get_content($message, $type)
  {
    switch ($type)
    {
      case (MessageType::TEXT):
        return $message['text'];
      case (MessageType::PHOTO):
        return $message['photo'][count($message['photo']) - 1]['file_id'];
      case (MessageType::AUDIO):
        return $message['audio']['file_id'];
      case (MessageType::DOCUMENT):
        return $message['document']['file_id'];
      case (MessageType::STICKER):
        return $message['sticker']['file_id'];
      case (MessageType::VOICE):
        return $message['voice']['file_id'];
      case (MessageType::VIDEO):
        return $message['video']['file_id'];
      case (MessageType::VIDEO_NOTE):
        return $message['video_note']['file_id'];
      case (MessageType::CONTACT):
        return $message['contact']['phone_number']
               . ' - '
               . $message['contact']['first_name']
               . ' - '
               . $message['contact']['last_name']
               . ' - '
               . $message['contact']['user_id'];
      case (MessageType::LOCATION):
        return $message['location']['longitude']
               . ' - '
               . $message['location']['latitude'];
      default:
        return NULL;
    }
  }

  ###########
  # SETTERS #
  ###########

  /**
   * Adds an user to Pooter's memory.
   *
   * @param mixed $user User to be inserted
   */
  private function add_sender($user)
  {
    $telegram_id = $user['id'];
    $first_name = isset($user['first_name']) ? '\''.$user['first_name'].'\'' : 'NULL';
    $last_name = isset($user['last_name']) ? '\''.$user['last_name'].'\'' : 'NULL';
    $username = isset($user['username']) ? '\''.$user['username'].'\'' : 'NULL';

    $query = "INSERT INTO senders (id, telegram_id, first_name, last_name, username)
              VALUES (NULL, $telegram_id, $first_name, $last_name, $username)";
    $this->database->query($query);
  }

  /**
   * Adds a chat to Pooter's memory.
   *
   * @param mixed $chat Chat to be inserted.
   */
  private function add_chat($chat)
  {
    $telegram_id = $chat['id'];
    $type = $chat['type'];
    $title = isset($chat['title']) ? '\''.$chat['title'].'\'' : 'NULL';

    $query = "INSERT INTO chats (id, telegram_id, title, type)
              VALUES (NULL, $telegram_id, $title, '$type')";
    $this->database->query($query);
  }

  ##################
  # USER INTERFACE #
  ##################

  /**
   * Save message into database.
   *
   * @param array $message Message to store.
   */
  public function save_message($message)
  {
    // detect message type
    if (isset($message['text']))
    {
      $type = MessageType::TEXT;
    }
    elseif (isset($message['photo']))
    {
      $type = MessageType::PHOTO;
    }
    elseif (isset($message['audio']))
    {
      $type = MessageType::AUDIO;
    }
    elseif (isset($message['document']))
    {
      $type = MessageType::DOCUMENT;
    }
    elseif (isset($message['sticker']))
    {
      $type = MessageType::STICKER;
    }
    elseif (isset($message['voice']))
    {
      $type = MessageType::VOICE;
    }
    elseif (isset($message['video']))
    {
      $type = MessageType::VIDEO;
    }
    elseif (isset($message['video_note']))
    {
      $type = MessageType::VIDEO_NOTE;
    }
    elseif (isset($message['contact']))
    {
      $type = MessageType::CONTACT;
    }
    elseif (isset($message['location']))
    {
      $type = MessageType::LOCATION;
    }
    else
    {
      return;
    }

    $chat_id = $this->get_chat_id($message['chat']);
    $sender_id = $this->get_sender_id($message['from']);

    $sending_date = gmdate('Y-m-d H:i:s', $message['date']);

    $content = $this->get_content($message, $type);

    $caption = isset($message['caption']) ? '\''.$message['caption'].'\'' : 'NULL';

    // now re-translate type from int to enum-string (for database)
    $type = $this->get_message_type($type);

    $query = "INSERT INTO messages (id, chat_id, sender_id, sending_date, type, content, caption)
              VALUES (NULL, $chat_id, $sender_id, '$sending_date', '$type', '$content', $caption)";
    $this->database->query($query);
  }

  /**
   * Checks if a group is muted.
   *
   * @param int $group_id Group to be checked.
   * @return bool
   */
  public function is_muted($group_id)
  {
    $query = "SELECT * FROM muted_groups WHERE group_id = $group_id";
    $result = $this->database->query($query);

    return $result->num_rows > 0;
  }

  /**
   * Mutes PooterBot in a specific group.
   *
   * @param int $group_id Group to be muted.
   */
  public function mute($group_id)
  {
    $query = "INSERT INTO muted_groups (group_id) VALUES ($group_id)";
    $this->database->query($query);
  }

  /**
   * Unmutes PooterBot in a specific group.
   *
   * @param int $group_id Group to be unmuted.
   */
  public function unmute($group_id)
  {
    $query = "DELETE FROM muted_groups WHERE group_id = $group_id";
    $this->database->query($query);
  }

}