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
    private $message;

    private $pictures = array(
        'rugby' => 'AgADBAADRKkxGzn7-VAjJrMG6scndNWMuxkABGNtHsrxnyBOJysBAAEC',
        'intenso' => 'AgADBAADR6kxGzn7-VBUBMOaS-y26OfJnhkABBhGeuQ5-mma5FoEAAEC',
        'linguaccia' => 'AgADBAADGakxG0EyCFGAkt-oPjv8GqNrmxkABHaZp0cgZuKvbmAEAAEC',
        'filosofia' => 'AgADBAADGqkxG0EyCFG4sm1oqFa0fBLnnxkABGk_yfNNlWpb6WUEAAEC',
        'sociale' => 'AgADBAADG6kxG0EyCFHcuocSdX-pfcjWnBkABMBjO6Rh8bYfrFgEAAEC',
        'evil' => 'AgADBAADHKkxG0EyCFGGD1Pgnh6Fmz0AAb0ZAAShfA5vbTv5tms3AQABAg',
        'hooligan' => 'AgADBAADMaoxGwJlEVFlm6cmRDZVWV51mxkABPJAlMffzG8bZGcEAAEC',
        'caschetto' => 'AgADBAADzagxG09xGFGgt-QvRKw20QTmnxkABELGH8Fe93p0a2kEAAEC',
        'donna' => 'AgADBAAD1KgxG09xGFFhmilQ01jlD6ZkqRkABENvTwYiKKi0Eq0BAAEC',
        'olmo' => 'AgADBAAD16gxG09xGFEnfKKKMsxpaVimuxkABD9pYMaIW39cSUIBAAEC'
    );

    /**
     * PooterBrain constructor.
     *
     * @param $update JsonSerializable object.
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
        } else {
            $this->text = "";
        }

        // hold interlocutor's name
        if (isset($this->message['chat'])) {
            switch ($this->message['chat']['type']) {
                case ('private'): {
                    $this->interlocutor_name = $this->message['chat']['first_name'];
                    break;
                }
                case ('group'): {
                    $this->interlocutor_name = $this->message['from']['first_name'];
                    break;
                }
            }
        }
        define('BOT_ID', '395202945');
    }

    /**
     * Interprets the content and sends it in the form of the selected type.
     *
     * @param $type string: type of message to be send (text, photo...)
     * @param $content string: content to be send
     * @return array ready to be JSON-serialized as a Telegram message
     * @throws Exception if an unknown type is passed
     */
    private function interpret($type, $content)
    {
        switch ($type) {
            case ('text'):
                return array('method' => 'sendMessage', 'text' => $content);
            case ('photo'): {
                switch ($content) {
                    case ('rugby'):
                        return array('method' => 'sendPhoto', 'photo' => $this->pictures['rugby'], 'caption' => 'Ti sventro la passera');
                    case ('filosofia'):
                        return array('method' => 'sendPhoto', 'photo' => $this->pictures['filosofia'], 'caption' => 'Come dissi tempo fa...');
                    case ('hooligan'):
                        return array('method' => 'sendPhoto', 'photo' => $this->pictures['hooligan'], 'caption' => 'Trema! No scherzo amico mio <3');
                    default:
                        throw new Exception('Invalid argument');
                }
            }
            default:
                throw new Exception('Invalid argument');
        }
    }

    /**
     * Returns a brief weather report of a random city.
     *
     * @return string containing a short weather report
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

        $url = $base_url . '?q=' . $city . '&units=metric' . '&lang=it' . '&appid=' . $api_key;
        $content = file_get_contents($url);
        $response = json_decode($content, true);

        $current_weather = $response['weather'][0]['description'];
        $temperature = $response['main']['temp'];
        $wind_speed = $response['wind']['speed'];
        $wind_direction = $response['wind']['deg'];

        $text_to_send = 'Ci penso io tranquilli, a '.
                        "$city c'è ".
                        "$current_weather con una temperatura di ".
                         $temperature . '°C, il vento tira ad una velocità di '.
                        "$wind_speed km/h a ".
                         $wind_direction . '°';
        return $text_to_send;
    }

    /**
     * Returns a random silly joke.
     *
     * @return string containing a random joke
     */
    private function get_joke() {
        $jokes = array(
            "Due gamberetti si incontrano a un party ed uno si accorge che l'altro è un po' triste e gli chiede:\n-\"Che cosa c'è?\"\n-\"No niente\"",
            "Una tartaruga, dopo aver battuto la testa contro un albero si confida con un'amica:\n-\"Spero che... che la... sgusa, anzi, prego...\"\nNon me la ricordo più",
            "-\"Voto inglese\"?\n-\"Ottimo\"\n-\"Ok... traduca 'capire le donne'\n-\"Somebody\"",
            "Che cosa fa un pittore al polo nord? Io non lo so",
            "Tua madre è cosi troia che quando le dico... no cioè, quando non le dico... che poi tua madre non è troia... capito? Sto scherzando amico mio!",
            "Il commendator Colombo Ernesto va in Africa a caccia di leoni nella savana. Mentre è acquattato con il fucile in mano nel più completo silenzio, si sente toccare su una spalla e, giratosi di scatto, vede un negro tutto nudo, alto e muscoloso che gli grida: \"SOOOOMEBOOOOODY\"",
            "Nella sala d'attesa dello studio di un dottore c'è una lunghissima fila. I pazienti si consultano tra di loro, un paziente dice: \"io mi sono rotto un braccio\" ed un altro: \"io mi sono rotto una gamba\" e l'ultimo paziente: \"SOOOOMEBOOOOODY\""
        );
        $joke = $jokes[array_rand($jokes)];
        return $joke;
    }

    /**
     * This is the syntactic analyzer of the class. Looks for specific tokens and returns the
     * interpreted text.
     *
     * @return array|bool containing the interpreted message.
     */
    private function parse_text()
    {
        if (strpos($this->text, '/start') !== FALSE)
        {
            $text_to_send = "Ciao $this->interlocutor_name, caro amico mio, io sono Pietro Gusso. Ho 20 anni e mi piace la musica e lo sport e da ben 9 anni pratico rugby!";
            return $this->interpret('text', $text_to_send);
        }
        elseif (strpos($this->text, 'barzelletta') !== FALSE)
        {
            $text_to_send = $this->get_joke();
            return $this->interpret('text', $text_to_send);
        }
        elseif (strpos($this->text, 'meteo') !== FALSE
             || strpos($this->text, 'clima') !== FALSE)
        {
            $text_to_send = $this->get_weather();
            return $this->interpret('text', $text_to_send);
        }
        elseif (strpos($this->text, 'zitto') !== FALSE)
        {
            $text_to_send = $this->interlocutor_name . ' potresti rispettare le persone che scrivono quello che vogliono? Senza offesa per te, ma potresti non cagare il cazzo?';
            return $this->interpret('text', $text_to_send);
        }
        elseif (strpos($this->text, 'somebody') !== FALSE)
        {
            $text_to_send = 'Eh grande pezzo';
            return $this->interpret('text', $text_to_send);
        }
        elseif (strpos($this->text, 'fidanzata') !== FALSE
             || strpos($this->text, 'sono') !== FALSE
             || strpos($this->text, 'sharade') !== FALSE
             || strpos($this->text, 'charade') !== FALSE)
        {
            $text_to_send = 'Sono Speedy Gonzales?';
            return $this->interpret('text', $text_to_send);
        }
        elseif (preg_match('/s+t+o+p{2,}e+r+/', $this->text))
        {
            $text_to_send = 'Sergio Brio!';
            return $this->interpret('text', $text_to_send);
        }
        elseif (preg_match('/s+o+m+e+/', $this->text))
        {
            $text_to_send = 'Bbbbbbboooooooooooodddddddddddyyyyyyyyyyy';
            return $this->interpret('text', $text_to_send);
        }
        elseif (preg_match('/b+o+d+y+/', $this->text))
        {
            $text_to_send = "Sssssssssssoooooooooommmmmmmeeeeeeeeeeee";
            return $this->interpret('text', $text_to_send);
        }
        elseif (strpos($this->text, 'passione') !== FALSE)
        {
            $text_to_send = 'Il mio sogno è fare il telecronista';
            return $this->interpret('text', $text_to_send);
        }
        elseif (strpos($this->text, 'brau') !== FALSE)
        {
            $text_to_send = 'Sto arrivando, ' . $this->interlocutor_name . ' mi dai uno strappo?';
            return $this->interpret('text', $text_to_send);
        }
        elseif (preg_match('/.*lava.*piedi.*/', $this->text))
        {
            return $this->interpret('photo', 'filosofia');
        }
        elseif (strpos($this->text, 'conquista') !== FALSE)
        {
            return $this->interpret('photo', 'rugby');
        }
        elseif (strpos($this->text, 'intimidisci') !== FALSE
             || strpos($this->text, 'spaventa') !== FALSE)
        {
            return $this->interpret('photo', 'hooligan');
        }
        elseif (preg_match('/.*(pooter|sugo|gusso|pietro|luca).*/', $this->text)) {
            $text_to_send = 'Dimmi ' . $this->interlocutor_name . ', mi hai chiamato?';
            return $this->interpret('text', $text_to_send);
        }
        else {
            return FALSE;
        }
    }

    /**
     * Returns Pooter's answer.
     *
     * @return array|bool containing the answer to be sent.
     */
    public function answer()
    {
        // greet new group members (included Pooter himself)
        if (isset($this->message['new_chat_members'])) {
            $new_members = $this->message['new_chat_members'];
            if ($new_members[0]['id'] == BOT_ID) {
                return $this->interpret('text', 'Amici miei come va? Che fate di bello stasera?');
            } else {
                if (count($new_members) > 1) {
                    return $this->interpret('text', 'Benvenuti ragazzi, che fate di bello stasera?');
                } else {
                    $new_member = $new_members[0]['first_name'];
                    return $this->interpret('text', "Ciao $new_member, che fai di bello stasera?");
                }
            }
        }

        if ($this->text === "") return FALSE;
        return $this->parse_text();
    }

}
