<?php
/******************************************************************************
 *
 * Subrion - open source content management system
 * Copyright (C) 2018 Intelliants, LLC <https://intelliants.com>
 *
 * This file is part of Subrion.
 *
 * Subrion is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Subrion is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Subrion. If not, see <http://www.gnu.org/licenses/>.
 *
 *
 * @link https://subrion.org/
 *
 ******************************************************************************/

if (iaView::REQUEST_HTML == $iaView->getRequestType() && $iaView->blockExists('current_weather')) {
    $city = $iaCore->get('current_weather_city');
    $units = array('Celsius' => 'metric', 'Fahrenheit' => 'imperial');
    $unitParam = $units[$iaCore->get('current_weather_unit')];

    $degrees = array('Celsius' => 'C', 'Fahrenheit' => 'F');
    $degreesParam = $degrees[$iaCore->get('current_weather_unit')];
    $appID = $iaCore->get('current_weather_key');

    $url = "http://api.openweathermap.org/data/2.5/weather?q={$city}&mode=json&units={$unitParam}&appid={$appID}";

    $curl_response = iaUtil::getPageContent($url);
    $weatherData = json_decode($curl_response, true);
    $weatherTemp = round($weatherData['main']['temp']);

    if ($weatherData) {
        $images = array(
            'Mist' => 'img/mist.png',
            'Snow' => 'img/snow.png',
            'Thunderstorm' => 'img/thunderstorm.png',
            'Rain' => 'img/rain.png',
            'Shower rain' => 'img/shower_rain.png',
            'Broken clouds' => 'img/clouds.png',
            'Clouds' => 'img/clouds.png',
            'Scattered clouds' => 'img/clouds.png',
            'Few clouds' => 'img/cloudy_day.png',
            'Clear sky' => 'img/clear_sky.png',
            'Clear' => 'img/clear_sky.png');

        $weatherIconUrl = 'http://openweathermap.org/img/w/' . $weatherData['weather'][0]['icon'];

        $iaView->assign('icon', $weatherIconUrl);
        $iaView->assign('weather_temp', $weatherTemp);

        $iaView->add_css('_IA_URL_modules/weather/templates/front/css/style');
    }

    $iaView->assign('degrees', $degreesParam);
    $iaView->assign('weather_data', $weatherData);
}