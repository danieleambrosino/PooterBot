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
    $message = $update['message'];

    if (!isset($message['text'])) {
      throw new Exception('No text');
    }
    $this->text = strtolower(trim($message['text']));

    if (isset($message['chat']['first_name'])) {
      $this->interlocutor_name = $message['chat']['first_name'];
    } else {
      $this->interlocutor_name = "";
    }

  }

  public function interpret()
  {
    $text_to_send = "";

    if (strpos($this->text, 'ciao') !== FALSE || strpos($this->text, '/start') !== FALSE) {
      $text_to_send = 'Ciao ' . $this->interlocutor_name . ', caro amico mio, io sono Pietro Gusso. Ho 20 anni e mi piace la musica e lo sport e da ben 9 anni pratico rugby!';
    } elseif (strpos($this->text, 'zitto') !== FALSE) {
      $text_to_send = $this->interlocutor_name . ' potresti rispettare le persone che scrivono quello che vogliono? Senza offesa per te, ma potresti non cagare il cazzo?';
    } elseif (strpos($this->text, 'somebody') !== FALSE) {
      $text_to_send = 'Eh grande pezzo';
    } elseif (strpos($this->text, 'fidanzata') !== FALSE || strpos($this->text, 'sono') !== FALSE ||
      strpos($this->text, 'sharade') !== FALSE || strpos($this->text, 'charade') !== FALSE
    ) {
      $text_to_send = 'Sono Speedy Gonzales?';
    } elseif (preg_match('/sto+p{2,}er*/', $this->text)) {
      $text_to_send = 'Sergio Brio!';
    }

    return $text_to_send;
  }

}