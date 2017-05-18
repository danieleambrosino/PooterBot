<?php

/**
 * Created by PhpStorm.
 * User: danie
 * Date: 19/05/2017
 * Time: 00:09
 */
class PooterBrain
{

  private $text;
  private $interlocutor_name;

  public function __construct($update)
  {
    if (!isset($update['message'])) {
      throw new Exception('No message');
    }
    $message = strtolower(trim($update['message']));

    if (!isset($message['text'])) {
      throw new Exception('No text');
    }
    $this->text = $message['text'];

    if (isset($message['chat']['first_name'])) {
      $this->interlocutor_name = $message['chat']['first_name'];
    } else {
      $this->interlocutor_name = "";
    }

  }

  public function interpret() {
    $text_to_send = "";

    if (strpos($text, 'ciao') !== FALSE || strpos($text, '/start') !== FALSE) {
      $text_to_send = 'Ciao ' . $this->interlocutor_name . ', caro amico mio, io sono Pietro Gusso. Ho 20 anni e mi piace la musica e lo sport e da ben 9 anni pratico rugby!';
    } elseif (strpos($text, 'zitto') !== FALSE) {
      $text_to_send = $this->interlocutor_name . ' potresti rispettare le persone che scrivono quello che vogliono? Senza offesa per te, ma potresti non cagare il cazzo?';
    } elseif (strpos($text, 'somebody') !== FALSE) {
      $text_to_send = 'Eh grande pezzo';
    } elseif (strpos($text, 'fidanzata') !== FALSE || strpos($text, 'sono') !== FALSE ||
      strpos($text, 'sharade') !== FALSE || strpos($text, 'charade') !== FALSE)
    {
      $text_to_send = 'Sono Speedy Gonzales?';
    }

    return $text_to_send;
  }

}