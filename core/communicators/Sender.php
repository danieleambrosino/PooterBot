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
 * Description of Sender
 *
 * @author Daniele Ambrosino
 */
class Sender extends Communicator
{

  private $curlHandle;

  public function __construct()
  {
    $this->curlHandle = curl_init();
    curl_setopt_array($this->curlHandle,
                      [
      CURLOPT_RETURNTRANSFER => TRUE,
      CURLOPT_POST           => TRUE,
      CURLOPT_HTTPHEADER     => ['Content-Type: application/json']
    ]);
  }

  public function sendMessage(TextResponse &$response): TextMessage
  {
    $params = [
      'chat_id'             => $response->getMessage()->getChat()->getId(),
      'text'                => $response->getText(),
      'parse_mode'          => 'Markdown',
      'reply_to_message_id' => $response->getMessage()->getId()
    ];
    curl_setopt_array($this->curlHandle,
                      [
      CURLOPT_URL        => 'https://api.telegram.org/bot' . TELEGRAM_TOKEN . '/sendMessage',
      CURLOPT_POSTFIELDS => json_encode($params)
    ]);
    $telegramResponse = $this->performSession();
    return $response->toMessage($telegramResponse['message_id'],
                                $telegramResponse['date']);
  }

  public function sendPhoto(PhotoResponse &$response): Photo
  {
    $params = [
      'chat_id'             => $response->getMessage()->getChat()->getId(),
      'photo'               => $response->getFileId(),
      'parse_mode'          => 'Markdown',
      'reply_to_message_id' => $response->getMessage()->getId()
    ];
    if ( !is_null($response->getCaption()) )
    {
      $params['caption'] = $response->getCaption();
    }
    curl_setopt_array($this->curlHandle,
                      [
      CURLOPT_URL        => 'https://api.telegram.org/bot' . TELEGRAM_TOKEN . '/sendPhoto',
      CURLOPT_POSTFIELDS => json_encode($params)
    ]);
    $telegramResponse = $this->performSession();
    return $response->toMessage($telegramResponse['message_id'],
                                $telegramResponse['date']);
  }

  public function sendVoice(VoiceResponse &$response): Voice
  {
    $params = [
      'chat_id'             => $response->getMessage()->getChat()->getId(),
      'voice'               => $response->getFileId(),
      'parse_mode'          => 'Markdown',
      'reply_to_message_id' => $response->getMessage()->getId()
    ];
    if ( !is_null($response->getCaption()) )
    {
      $params['caption'] = $response->getCaption();
    }
    curl_setopt_array($this->curlHandle,
                      [
      CURLOPT_URL        => 'https://api.telegram.org/bot' . TELEGRAM_TOKEN . '/sendVoice',
      CURLOPT_POSTFIELDS => json_encode($params)
    ]);
    $telegramResponse = $this->performSession();
    return $response->toMessage($telegramResponse['message_id'],
                                $telegramResponse['date']);
  }

  public function leaveGroup(LeaveGroupResponse &$response): ChatMemberRemovedEvent
  {
    $params = [
      'chat_id' => $response->getMessage()->getChat()->getId()
    ];
    curl_setopt_array($this->curlHandle,
                      [
      CURLOPT_URL        => 'https://api.telegram.org/bot' . TELEGRAM_TOKEN . '/leaveChat',
      CURLOPT_POSTFIELDS => json_encode($params)
    ]);
    $this->performSession();
    return $response->toMessage(rand(0, 2147483647), time());
  }

  private function performSession()
  {
    $rawResponse = curl_exec($this->curlHandle);
    if ( FALSE === $rawResponse )
    {
      throw new ErrorException(__METHOD__ . ': cURL error, curl_exec() failed');
    }
    $httpCode = intval(curl_getinfo($this->curlHandle, CURLINFO_RESPONSE_CODE));
    if ( $httpCode >= 500 )
    {
      throw new ErrorException(__METHOD__ . ": Telegram server error (HTTP code $httpCode");
    }
    if ( is_bool($rawResponse) )
    {
      if ( FALSE === $rawResponse )
      {
        throw new ErrorException(__METHOD__ . ': Telegram refused our request');
      }
      return TRUE;
    }
    $response = json_decode($rawResponse, TRUE);
    if ( FALSE === $response )
    {
      throw new ErrorException(__METHOD__ . ': Bad content (unable to decode JSON)');
    }
    if ( $response['ok'] !== TRUE )
    {
      throw new ErrorException(__METHOD__ . ": Telegram refused our request, error code {$response['error_code']}: {$response['description']}");
    }
    $result = $response['result'];
    if ( TRUE === $result )
    {
      return TRUE;
    }
    if ( !isset($result['message_id'], $result['date']) )
    {
      throw new ErrorException(__METHOD__ . ': Invalid response returned by Telegram');
    }
    return $result;
  }

}
