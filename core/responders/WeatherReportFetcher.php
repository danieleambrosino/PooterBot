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
 * Description of WeatherReportFetcher
 *
 * @author Daniele Ambrosino
 */
class WeatherReportFetcher
{

  public static function getWeatherReport(int $id)
  {
    $url = 'https://api.openweathermap.org/data/2.5/weather?';
    $params = [
      'id'     => $id,
      'units' => 'metric',
      'lang'  => 'it',
      'APPID' => OPENWEATHERMAP_TOKEN
    ];
    $url .= http_build_query($params);
    $content = file_get_contents($url);
    $response = json_decode($content, TRUE);

    $city = $response['name'];
    $currentWeather = $response['weather'][0]['description'];
    $temperature = $response['main']['temp'];
    $windSpeed = $response['wind']['speed'];
    $windDirection = $response['wind']['deg'];
    
    return "A $city c'è $currentWeather con una temperatura di {$temperature}°C, il vento tira ad una velocità di $windSpeed km/h a {$windDirection}°";
  }

}
