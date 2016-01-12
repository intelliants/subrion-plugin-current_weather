<?php
//##copyright##

if (iaView::REQUEST_HTML == $iaView->getRequestType() && $iaView->blockExists('current_weather'))
{
	$city = urlencode($iaCore->get('current_weather_city'));
	$units = array('Celsius' => 'metric', 'Fahrenheit' => 'imperial');
	$unitParam = $units[$iaCore->get('current_weather_unit')];

	$degrees = array('Celsius' => 'C', 'Fahrenheit' => 'F');
	$degreesParam = $degrees[$iaCore->get('current_weather_unit')];
	$weatherData = iaUtil::jsonDecode(file_get_contents("http://api.openweathermap.org/data/2.5/weather?q={$city}&mode=json&units={$unitParam}"));
	$weatherTemp = round($weatherData['main']['temp']);
	if ($weatherData)
	{
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

		$weatherIcon = str_replace('img/', 'img/' . $iaCore->get('current_weather_scheme') . '/', $images[$weatherData['weather'][0]['main']]);

		$iaView->assign('icon', $weatherIcon);
		$iaView->assign('weather_temp', $weatherTemp);

		$iaView->add_css('_IA_URL_plugins/current_weather/templates/front/css/style');
	}

	$iaView->assign('degrees', $degreesParam);
	$iaView->assign('weather_data', $weatherData);
}