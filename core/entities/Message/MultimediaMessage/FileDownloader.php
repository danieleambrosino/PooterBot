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
 * Description of FileDownloader
 *
 * @author Daniele Ambrosino
 */
class FileDownloader
{

  public static function downloadFile(string $fileId): string
  {
    $url = 'https://api.telegram.org/bot' . TELEGRAM_TOKEN . '/getFile';
    $params = [
      'file_id' => $fileId
    ];
    $url .= '?' . http_build_query($params);
    $response = file_get_contents($url);
    $decodedResponse = json_decode($response, TRUE);
    if ( $decodedResponse['ok'] === FALSE )
    {
      return "";
    }
    $filePath = $decodedResponse['result']['file_path'];
    $url = 'https://api.telegram.org/file/bot' . TELEGRAM_TOKEN . '/' . $filePath;
    $response = file_get_contents($url);
    return $response;
  }

}
