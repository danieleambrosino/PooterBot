<?php

include 'PooterMemory.php';

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
  private $is_female;
  private $message;

  private $database;
  private $memory;

  private $pictures = array(
      'rugby'       => 'AgADBAADRKkxGzn7-VAjJrMG6scndNWMuxkABGNtHsrxnyBOJysBAAEC',
      'intenso'     => 'AgADBAADR6kxGzn7-VBUBMOaS-y26OfJnhkABBhGeuQ5-mma5FoEAAEC',
      'linguaccia'  => 'AgADBAADGakxG0EyCFGAkt-oPjv8GqNrmxkABHaZp0cgZuKvbmAEAAEC',
      'filosofia'   => 'AgADBAADGqkxG0EyCFG4sm1oqFa0fBLnnxkABGk_yfNNlWpb6WUEAAEC',
      'sociale'     => 'AgADBAADG6kxG0EyCFHcuocSdX-pfcjWnBkABMBjO6Rh8bYfrFgEAAEC',
      'evil'        => 'AgADBAADHKkxG0EyCFGGD1Pgnh6Fmz0AAb0ZAAShfA5vbTv5tms3AQABAg',
      'hooligan'    => 'AgADBAADMaoxGwJlEVFlm6cmRDZVWV51mxkABPJAlMffzG8bZGcEAAEC',
      'caschetto'   => 'AgADBAADzagxG09xGFGgt-QvRKw20QTmnxkABELGH8Fe93p0a2kEAAEC',
      'donna'       => 'AgADBAAD1KgxG09xGFFhmilQ01jlD6ZkqRkABENvTwYiKKi0Eq0BAAEC',
      'olmo'        => 'AgADBAAD16gxG09xGFEnfKKKMsxpaVimuxkABD9pYMaIW39cSUIBAAEC',
      'sergio_brio' => 'AgADBAADxqgxG3sfIVENltTMCQQs5j9KuxkABPt2tL9OyLESg0EBAAEC'
  );
  private $voices = array(
      'esatto' => 'AwADBAADEwEAAk-rYVFJ4vECDuLzJQI',
      'somebody' => 'AwADBAADFAEAAk-rYVFyXdKkQimdpAI',
      'somebody_poesia' => 'AwADBAADFQEAAk-rYVFQWqetvlT71gI',
      'allucinazioni' => 'AwADBAADFgEAAk-rYVG_x599FffrNwI',
      'delirio1' => 'AwADBAADHwEAAk-rYVGQ1P9swKylxAI',
      'reflections' => 'AwADBAADIAEAAk-rYVGvbgt2Dgc4egI',
      'delirio2' => 'AwADBAADIQEAAk-rYVHpLsH7DHxrBAI',
      'english_reflections' => 'AwADBAADIgEAAk-rYVHvZta-RnFYogI',
      'ruggito' => 'AwADBAADEQEAAk-rYVGqSDFbkF5YJwI',
      'fantasia_potenza' => 'AwADBAADEAEAAk-rYVHxjRG3s8hRogI',
      'magico' => 'AwADBAADDwEAAk-rYVH8yZwt5mEWpwI',
      'sergio_brio' => 'AwADBAADCgEAAk-rYVGvbZpjP5UEmAI',
      'most_famous' => 'AwADBAADCQEAAk-rYVGodJALE2_0owI',
      'avventurosa' => 'AwADBAADBgEAAk-rYVHTcFJ5z_hXNwI',
      'romagnolo' => 'AwADBAADBwEAAk-rYVHej38x5nECogI',
      'zampino' => 'AwADBAADBQEAAk-rYVHqF1j_TDjzMAI'
  );
  private $songs = array(
      'tempo_cattedrali' => 'AwADBAADFwEAAk-rYVHPx0beI6ewEQI',
      'stranieri' => 'AwADBAADGAEAAk-rYVEihOZVNCQDdAI',
      'corte_miracoli' => 'AwADBAADHgEAAk-rYVEx2Nikwfdh1QI',
  );

  /**
   * PooterBrain constructor.
   *
   * @param array $update Associative array containing message data.
   * @throws Exception if no message was sent.
   */
  public function __construct($update)
  {
    // hold received message
    if (!isset($update['message'])) {
      throw new Exception('No message');
    }
    $this->message = $update['message'];

    // hold received text (if present)
    if (isset($this->message['text'])) {
      $this->text = strtolower(trim($this->message['text']));
    }
    else {
      $this->text = "";
    }

    // hold interlocutor's name
    $this->interlocutor_name = $this->message['from']['first_name'];

    $this->database = new mysqli('', '', '', 'my_pooterbot');
    $this->memory = new PooterMemory();
    $this->memory->save_message($this->message);

    $this->is_female = $this->is_female();

    define('BOT_ID', '395202945');
  }

  /**
   * Interprets the content and sends it in the form of the selected type.
   * Returns an array ready to be JSON-serialized as a Telegram message object.
   *
   * @param int    $type    Type of message to be send (text, photo...)
   * @param string $content Content to be send
   * @param string $caption Optional caption (multimedia only)
   *
   * @return array
   * @throws Exception if an unknown type is passed
   */
  private function get_message($type, $content, $caption = NULL)
  {
    switch ($type)
    {
      case (MessageType::TEXT):
      {
        return array('method'              => 'sendMessage',
                     'reply_to_message_id' => $this->message['message_id'],
                     'text'                => $content);
      }
      case (MessageType::PHOTO):
      {
        $message = array('method'              => 'sendPhoto',
                         'reply_to_message_id' => $this->message['message_id']);

        if ($content === 'random')
        {
          $message['photo'] = $this->pictures[array_rand($this->pictures)];
        }
        elseif (array_key_exists($content, $this->pictures))
        {
          $message['photo'] = $this->pictures[$content];
          $message['caption'] = $caption;
        }
        else
        {
          throw new Exception('Selected picture is not available');
        }
        return $message;
      }
      case (MessageType::VOICE):
      {
        $message = array('method'              => 'sendVoice',
                         'reply_to_message_id' => $this->message['message_id']);
        if ($content == 'random')
        {
          $message['voice'] = $this->voices[array_rand($this->voices)];
        }
        elseif ($content == 'random_song')
        {
          $message['voice'] = $this->songs[array_rand($this->songs)];
        }
        elseif (array_key_exists($content, $this->voices))
        {
          $message['voice'] = $this->voices[$content];
        }
        else
        {
          throw new Exception('Selected voice is not available');
        }
        return $message;
      }
      default:
        throw new Exception('Invalid argument');
    }
  }

  ####################
  # RANDOM RESOURCES #
  ####################

  /**
   * Returns a brief weather report of a random city.
   *
   * @return string
   */
  private function get_weather()
  {
    $api_key = 'e65327d8546ce97da440352f6a915c61';
    $base_url = 'http://api.openweathermap.org/data/2.5/weather';
    $cities = array(
        'Bangkok',
        'Pyongyang',
        'Kuala Lumpur',
        'Reykjavik',
        'Beirut',
        'Kabul',
        'Kathmandu',
        'Jakarta',
        'Tehran',
        'Baghdad',
        'Caracas',
        'Quito',
        'La Vella',
        'Brazzaville',
        'Minsk',
        'Glasgow',
        'Dakar',
        'Bissau',
        'Cusco',
        'Antananarivo',
        'Male',
        'Pita Kotte',
    );
    $city = $cities[array_rand($cities)];

    $url = $base_url
           . '?q='
           . $city
           . '&units=metric'
           . '&lang=it'
           . '&appid='
           . $api_key;
    $content = file_get_contents($url);
    $response = json_decode($content, true);

    $current_weather = $response['weather'][0]['description'];
    $temperature = $response['main']['temp'];
    $wind_speed = $response['wind']['speed'];
    $wind_direction = $response['wind']['deg'];

    $text_to_send = 'A '
                    . "$city c'è "
                    . "$current_weather con una temperatura di "
                    . $temperature
                    . '°C, il vento tira ad una velocità di '
                    . "$wind_speed km/h a "
                    . $wind_direction
                    . '°';
    return $text_to_send;
  }

  /**
   * Returns a random silly joke.
   *
   * @return string
   */
  private function get_joke()
  {
    $jokes = array(
        "Due gamberetti si incontrano a un party ed uno si accorge che l'altro è un po' triste e gli chiede:\n-\"Che cosa c'è?\"\n-\"No niente\"",
        "Una tartaruga, dopo aver battuto la testa contro un albero si confida con un'amica:\n-\"Spero che... che la... sgusa, anzi, prego...\"\nNon me la ricordo più",
        "-\"Voto inglese\"?\n-\"Ottimo\"\n-\"Ok... traduca 'capire le donne'\n-\"Somebody\"",
        "Che cosa fa un pittore al polo nord? Io non lo so",
        "Tua madre è cosi troia che quando le dico... no cioè, quando non le dico... che poi tua madre non è troia... capito? Sto scherzando amico mio!",
        "Il commendator Colombo Ernesto va in Africa a caccia di leoni nella savana. Mentre è acquattato con il fucile in mano nel più completo silenzio, si sente toccare su una spalla e, giratosi di scatto, vede un negro tutto nudo, alto e muscoloso che gli grida: \"SOOOOMEBOOOOODY\"",
        "Nella sala d'attesa dello studio di un dottore c'è una lunghissima fila. I pazienti si consultano tra di loro, un paziente dice: \"io mi sono rotto un braccio\" ed un altro: \"io mi sono rotto una gamba\" e l'ultimo paziente: \"SOOOOMEBOOOOODY\""
    );

    return $jokes[array_rand($jokes)];
  }

  /**
   * Returns a random proverb.
   *
   * @return string
   */
  private function get_proverb()
  {
    $proverbs = array(
      'A buon intenditor ogni scherzo vale',
      'A carnevale poche parole',
      'Al cuor, che si vinca o che si perda, si fa il mare',
      'A mali estremi, Pasqua con chi vuoi',
      'Campa cavallo che il buon sangue batte il ferro finché è caldo',
      'Chi ben comincia, disperato muore',
      'Chi disprezza ed è causa del suo mal, non fa errori',
      'Chi dorme non lascia la via vecchia per la nuova',
      'Chi di spada ferisce è per gli altri un trastullo',
      'Can che abbaia non prende lezioni',
      'Chi la fa sa quel che lascia ma non piglia pesci',
      'Chi nasce tondo raccoglie solo rabbia',
      'Chi non muore non rosica',
      'Chi non risica si rivede',
      'Chiodo scaccia chi ti accarezza oltre quel che suole',
      'Chi va piano va con lo zoppo e impara a toccare il fuoco',
    );

    return $proverbs[array_rand($proverbs)];
  }

  /**
   * Returns a random opinion.
   *
   * @return string
   */
  private function get_opinion()
  {
    $opinions = array(
        'Somebody',
        'A me piace',
        'Sono d\'accordissimo',
        'Ma cosa dici, amico mio',
        'Eh! Eh! No dai scherzo amico mio',
        'Hai assolutamente ragione, amico mio',
        'Heh... non so che dirti amico mio...',
        'Secondo me sì',
        'Secondo me no',
        'Secondo me sbaglia',
        'Secondo me è giusto',
        'Secondo me... Somebody',
        'Secondo me è giustissimo così',
        'Secondo me... non lo so amico mio',
        'Secondo me non è tanto vero, amico mio',
        'Secondo me fa schifo... ahah dai scherzavo amico mio'
    );

    return $this->tr($opinions[array_rand($opinions)]);
  }

  /**
   * Returns a random approval sentence.
   *
   * @return string
   */
  private function get_like()
  {
    $likes = array(
        'No',
        'Proprio per nulla amico mio',
        'Senza offesa amico mio ma fa proprio schifo',
        'Può andare',
        'Non è male',
        'Sì',
        'Mi piace',
        'Mi piace molto amico mio',
        'Amico mio, non avrei saputo fare di meglio',
        'È incredibile, quasi quanto te, caro amico mio'
    );
    return $this->tr($likes[array_rand($likes)]);
  }

  #############
  # UTILITIES #
  #############

  /**
   * Returns if a substring is found in received text.
   *
   * @param string $needle Substring to find
   * @return bool
   */
  private function found($needle)
  {
    return strpos($this->text, $needle) !== FALSE;
  }

  /**
   * Checks interlocutor's gender and returns the correct string.
   *
   * @param string    $string    Translation input.
   * @param bool|null $is_female Gender parameter.
   * @return string
   */
  private function tr($string, $is_female = NULL)
  {
    $final_string = $string;

    if ($is_female == NULL)
    {
      $is_female = $this->is_female;
    }

    if ($is_female)
    {
      $final_string = preg_replace('/caro/', 'cara', $final_string);
      $final_string = preg_replace('/Caro/', 'Cara', $final_string);
      $final_string = preg_replace('/mico/', 'mica', $final_string);
      $final_string = preg_replace('/mio/', 'mia', $final_string);
      $final_string = preg_replace('/Mio/', 'Mia', $final_string);
    }

    return $final_string;
  }

  /**
   * Checks if passed name is female.
   *
   * @param string|null $name
   * @return bool
   */
  private function is_female($name = NULL)
  {
    if ($name == NULL)
    {
      $name = $this->interlocutor_name;
    }

    $name = strtolower($name);

    return $this->database->query("SELECT name FROM female_names WHERE name = '$name'")->num_rows > 0;
  }

  /**
   * Checks if a group is muted.
   *
   * @return bool
   */
  private function is_muted()
  {
    $group_id = $this->message['chat']['id'];
    $query = "SELECT * FROM muted_groups WHERE group_id = $group_id";
    $result = $this->database->query($query);

    return $result->num_rows > 0;
  }

  /**
   * Mutes PooterBot in a specific group.
   */
  private function mute()
  {
    $group_id = $this->message['chat']['id'];
    $query = "INSERT INTO muted_groups (group_id) VALUES ($group_id)";
    $this->database->query($query);
  }

  /**
   * Unmutes PooterBot in a specific group.
   */
  private function unmute()
  {
    $group_id = $this->message['chat']['id'];
    $query = "DELETE FROM muted_groups WHERE group_id = $group_id";
    $this->database->query($query);
  }

  ####################
  # MESSAGE HANDLERS #
  ####################

  /**
   * This is the syntactic analyzer of the class. Looks for keywords and returns
   * the interpreted text.
   *
   * @return array|null
   */
  private function handle_text()
  {
    if ($this->found('/start'))
    {
      $text_to_send = $this->tr("Ciao $this->interlocutor_name, caro amico mio, io sono Pietro Gusso. Ho 20 anni e mi piace la musica e lo sport e da ben 9 anni pratico rugby!");
      return $this->get_message(MessageType::TEXT, $text_to_send);
    }

    if ($this->found('basta pooter'))
    {
      if ($this->message['chat']['type'] == 'private')
      {
        return NULL;
      }
      else
      {
        $this->mute();
        return $this->get_message('text', 'Sto zitto va bene non dico stronzate');
      }
    }

    if ($this->found('/foto'))
    {
      return $this->get_message(MessageType::PHOTO, 'random');
    }

    if ($this->found('barzelletta'))
    {
      $text_to_send = $this->get_joke();
      return $this->get_message(MessageType::TEXT, $text_to_send);
    }

    if ($this->found('proverbio'))
    {
      $text_to_send = $this->get_proverb();
      return $this->get_message(MessageType::TEXT, $text_to_send);
    }

    if ($this->found('meteo')
     || $this->found('clima'))
    {
      $text_to_send = $this->get_weather();
      return $this->get_message(MessageType::TEXT, $text_to_send);
    }

    if ($this->found('canzone'))
    {
      return $this->get_message(MessageType::VOICE, 'random_song');
    }

    if ($this->found('/audio'))
    {
      return $this->get_message(MessageType::VOICE, 'random');
    }

    if ($this->found('zitto'))
    {
      $text_to_send = "$this->interlocutor_name potresti rispettare le persone che scrivono quello che vogliono? Senza offesa per te, ma potresti non cagare il cazzo?";
      return $this->get_message(MessageType::TEXT, $text_to_send);
    }

    if ($this->found('somebody'))
    {
      $text_to_send = 'Eh grande pezzo';
      return $this->get_message(MessageType::TEXT, $text_to_send);
    }

    if ($this->found('fidanzata')
     || $this->found('sharade')
     || $this->found('charade'))
    {
      $text_to_send = 'Sono Speedy Gonzales?';
      return $this->get_message(MessageType::TEXT, $text_to_send);
    }

    if (preg_match('/s+t+o+p{2,}e+r+/', $this->text)) {
      return $this->get_message(MessageType::PHOTO, 'sergio_brio', 'Il più grande di tutti');
    }

    if ($this->found('some'))
    {
      return $this->get_message(MessageType::TEXT, 'Body');
    }

    if ($this->found('once'))
    {
      return $this->get_message(MessageType::TEXT, 'Told me');
    }

    if ($this->found('the'))
    {
      return $this->get_message(MessageType::TEXT, 'World');
    }

    if ($this->found('is gonna'))
    {
      return $this->get_message(MessageType::TEXT, 'Roll me');
    }

    if (preg_match('/s+o+m+e+/', $this->text))
    {
      $text_to_send = 'Bbbbbbboooooooooooodddddddddddyyyyyyyyyyy';
      return $this->get_message(MessageType::TEXT, $text_to_send);
    }

    if (preg_match('/b+o+d+y+/', $this->text))
    {
      $text_to_send = "Sssssssssssoooooooooommmmmmmeeeeeeeeeeee";
      return $this->get_message(MessageType::TEXT, $text_to_send);
    }

    if ($this->found('passione'))
    {
      $text_to_send = 'Il mio sogno è fare il telecronista';
      return $this->get_message(MessageType::TEXT, $text_to_send);
    }

    if ($this->found('brau')
     || $this->found('birr'))
    {
      return $this->get_message(MessageType::PHOTO, 'caschetto', "Sto arrivando, $this->interlocutor_name mi dai uno strappo?");
    }

    if (preg_match('/lava.*piedi/', $this->text)) {
      return $this->get_message(MessageType::PHOTO, 'filosofia', 'Come dissi tempo fa...');
    }

    if ($this->found('conquista'))
    {
      return $this->get_message(MessageType::PHOTO, 'rugby', 'Ti sventro la passera');
    }

    if ($this->found('intimidisci')
     || $this->found('spaventa'))
    {
      $caption = $this->tr('Trema! No scherzo amico mio <3');
      return $this->get_message(MessageType::PHOTO, 'hooligan', $caption);
    }

    if ($this->found('olmo'))
    {
      $caption = $this->tr("$this->interlocutor_name hai nominato Olmo? Grande amico mio <3");
      return $this->get_message(MessageType::PHOTO, 'olmo', $caption);
    }

    if (preg_match('/(secondo te|((che|cosa)( ne)? (pens|dic))|come (la vedi|(ti )?sembra)|che te ne pare)/', $this->text))
    {
      $opinion = $this->get_opinion();
      return $this->get_message(MessageType::TEXT, $opinion);
    }

    if (preg_match('/(a te|ti) piace/', $this->text))
    {
      $like = $this->get_like();
      return $this->get_message(MessageType::TEXT, $like);
    }

    if ($this->found('pietrausen greco'))
    {
      $text_to_send = "Non è carino da parte tua, amico mio";
      return $this->get_message(MessageType::TEXT, $text_to_send);
    }

    if (preg_match('/(pooter|sugo|gusso|pietro|luca)/', $this->text))
    {
      $text_to_send = "Dimmi $this->interlocutor_name, mi hai chiamato?";
      return $this->get_message(MessageType::TEXT, $text_to_send);
    }

    else {
      return NULL;
    }
  }

  /**
   * Handles Telegram groups events.
   *
   * @return array|null
   */
  private function handle_group_event()
  {
    // greet new group members (included Pooter himself)
    if (isset($this->message['new_chat_members']))
    {
      $new_members = $this->message['new_chat_members'];
      if ($new_members[0]['id'] == BOT_ID)
      {
        return $this->get_message(MessageType::TEXT, 'Amici miei come va? Che fate di bello stasera?');
      }
      elseif (count($new_members) > 1)
      {
        return $this->get_message(MessageType::TEXT, 'Benvenuti ragazzi, che fate di bello stasera?');
      }
      else
      {
        $new_member = $new_members[0]['first_name'];
        return $this->get_message(MessageType::TEXT, "Ciao $new_member, che fai di bello stasera?");
      }
    }

    // greet left group member
    if (isset($this->message['left_chat_member']))
    {
      $left_member = $this->message['left_chat_member']['first_name'];
      $message = $this->tr("No $left_member amico mio dove vai?");
      return $this->get_message(MessageType::TEXT, $message);
    }

    // comment new group photo
    if (isset($this->message['new_chat_photo']))
    {
      $message = $this->tr('Bellissima foto amico mio');
      return $this->get_message(MessageType::TEXT, $message);
    }

    // comment deleted group photo
    if (isset($this->message['delete_chat_photo']))
    {
      $message = $this->tr('Era una bellissima foto amico mio, perché l\'hai tolta?');
      return $this->get_message(MessageType::TEXT, $message);
    }

    // comment new group title
    if (isset($this->message['new_chat_title']))
    {
      $message = $this->tr('Bellissimo nome amico mio');
      return $this->get_message(MessageType::TEXT, $message);
    }

    return NULL;
  }

  /**
   * Comments a received photo.
   *
   * @return array
   */
  private function comment_photo()
  {
    $comments = array(
        'Questa foto non mi piace amico mio',
        'Questa foto non mi piace proprio per nulla amico mio',
        'Senza offesa amico mio ma questa foto fa proprio schifo',
        'Bella foto amico mio',
        'Mi piace questa foto, si vede che hai il palato fino amico mio',
        'Mi piace molto amico mio, sei un grande',
        'Amico mio, non avrei saputo fare di meglio',
        'Questa foto è incredibile quasi quanto te, caro amico mio'
    );
    $comment = $this->tr($comments[array_rand($comments)]);
    return $this->get_message(MessageType::TEXT, $comment);
  }

  ##################
  # USER INTERFACE #
  ##################

  /**
   * Returns Pooter's answer.
   *
   * @return array|null
   */
  public function answer()
  {
    if ($this->message['chat']['type'] == 'group'
     || $this->message['chat']['type'] == 'supergroup')
    {
      if ($this->is_muted())
      {
        if (preg_match('/pooter.*(si )?(scherza|scherzav)/', $this->text))
        {
          $this->unmute();
          return $this->get_message(MessageType::TEXT, 'Allora torno, amici miei');
        }

        if ($this->message['left_chat_member']['id'] == BOT_ID)
        {
          $this->unmute();
          return NULL;
        }

        return NULL;
      }

      if ($this->text != '')
      {
        return $this->handle_text();
      }

      if (isset($this->message['photo']))
      {
        return $this->comment_photo();
      }

      return $this->handle_group_event();
    }

    if ($this->text != '')
    {
      return $this->handle_text();
    }

    if (isset($this->message['photo']))
    {
      return $this->comment_photo();
    }

    return NULL;
  }

}
