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
      'id'    => $id,
      'units' => 'metric',
      'lang'  => 'it',
      'APPID' => OPENWEATHERMAP_TOKEN
    ];
    $url .= http_build_query($params);
    $content = file_get_contents($url);
    $response = json_decode($content, TRUE);

    $city = isset($response['name']) ? $response['name'] : NULL;
    $latitude = isset($response['coord']['lat']) ? $response['coord']['lat'] : NULL;
    $longitude = isset($response['coord']['lon']) ? $response['coord']['lon'] : NULL;
    $currentWeather = isset($response['weather'][0]['description']) ? $response['weather'][0]['description'] : NULL;
    $temperature = isset($response['main']['temp']) ? $response['main']['temp'] : NULL;
    $pressure = isset($response['main']['pressure']) ? $response['main']['pressure'] : NULL;
    $humidity = isset($response['main']['humidity']) ? $response['main']['humidity'] : NULL;
    $clouds = isset($response['clouds']['all']) ? $response['clouds']['all'] : NULL;
    $windSpeed = isset($response['wind']['speed']) ? $response['wind']['speed'] : NULL;
    $windDirection = isset($response['wind']['deg']) ? $response['wind']['deg'] : NULL;

    $weatherReport = "A $city";
    if ( !empty($latitude) && !empty($longitude) )
    {
      $weatherReport .= " (situata a {$latitude}° di latitudine e {$longitude}° di longitudine)";
    }
    if ( !empty($currentWeather) )
    {
      $weatherReport .= " c'è $currentWeather;";
    }
    if ( !empty($temperature) )
    {
      $weatherReport .= " la temperatura è di {$temperature}°C,";
    }
    if ( !empty($humidity) )
    {
      $weatherReport .= " l'umidità è al $humidity%,";
    }
    if ( !empty($pressure) )
    {
      $weatherReport .= " la pressione è di $pressure hPa,";
    }
    if ( !empty($clouds) )
    {
      $weatherReport .= " la nuvolosità è del $clouds%,";
    }
    if ( !empty($windSpeed) )
    {
      $weatherReport .= " il vento tira ad una velocità di $windSpeed km/h";
      if ( !empty($windDirection) )
      {
        $weatherReport .= " a {$windDirection}°";
      }
    }

    return $weatherReport;
  }

}
