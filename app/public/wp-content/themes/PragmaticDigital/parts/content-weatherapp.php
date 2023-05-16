<?php

	

	$xml = file_get_contents('https://api.openweathermap.org/data/2.5/weather?q=London&mode=xml&units=metric&appid=C815e7e6f6adf63781437395939c7e9d');

	$sxml = new SimpleXMLElement($xml);


	//all variables provided:
	$name = $sxml->city->attributes()->name;
	$long = $sxml->city->coord->attributes()->lon;
	$lat  = $sxml->city->coord->attributes()->lat;
	$rise = $sxml->city->sun->attributes()->rise;
	$set  = $sxml->city->sun->attributes()->set;

	$temp_cur = $sxml->temperature->attributes()->value;
	$temp_min = $sxml->temperature->attributes()->min;
	$temp_max = $sxml->temperature->attributes()->max;
	$temp_unit= $sxml->temperature->attributes()->unit;
	$temp_feel= $sxml->feels_like->attributes()->value;

	$humidity = $sxml->humidity->attributes()->value;//%
	$pressure = $sxml->pressure->attributes()->value;//hPa

	$wind_spd  = $sxml->wind->speed->attributes()->value;
	$wind_unit = $sxml->wind->speed->attributes()->unit;
	$wind_name = $sxml->wind->speed->attributes()->name;
	$wind_valu  = $sxml->wind->direction->attributes()->value;
	$wind_code  = $sxml->wind->direction->attributes()->code;
	$wind_dname = $sxml->wind->direction->attributes()->name;
	
	$cloud_name = $sxml->clouds->attributes()->value;
	$cloud_valu = $sxml->clouds->attributes()->name;

	$visibility = $sxml->visibility->attributes()->value;
	$visibility = $visibility/1000;//conv m-km

	$precip = $sxml->precipitation ->attributes()->mode;

	$weather_value = $sxml->weather->attributes()->value;
	$weather_icon  = $sxml->weather->attributes()->icon;

	//change wind speed m/s to km/h
	if ($wind_unit = "m/s"){
		$wind_spd = intval($wind_spd)*3.6;
		$wind_unit = "km/h";//conv m/s-km/h
	}

	//convert text to temp-icon
	if ($temp_unit = "celsius"){ 
		$temp_unit = "&deg;C"; 
	} elseif ($temp_unit = "fahrenheit") {
		$temp_unit = "&deg;F";
	} else {
		$temp_unit = "&nbsp;K";
	}

	//change text color depending on temperature
	if ($temp_unit = "&deg;C") {
		if ($temp_cur > 30) {
			$temp_col = "#b30000";//red
		} elseif ($temp_cur > 20) {
			$temp_col = "#F58220";//orange
		} elseif ($temp_cur > 10) {
			$temp_col = "#3333ff";//blue
		} else {
			$temp_col = "#00008b";//darkblue
		}
	} elseif ($temp_unit = "&deg;F") {
		if ($temp_cur > 86) {
			$temp_col = "#b30000";//red
		} elseif ($temp_cur > 68) {
			$temp_col = "#F58220";//orange
		} elseif ($temp_cur > 50) {
			$temp_col = "#3333ff";//blue
		} else {
			$temp_col = "#00008b";//darkblue
		}
	} else {
		if ($temp_cur > 303) {
			$temp_col = "#b30000";//red
		} elseif ($temp_cur > 293) {
			$temp_col = "#F58220";//orange
		} elseif ($temp_cur > 283) {
			$temp_col = "#3333ff";//blue
		} else {
			$temp_col = "#00008b";//darkblue
		}
	}
?>

	<div id="app" class="grid-x cell">
		<div class="grid-x small-12 medium-12 large-12">
			<div class="small-12 medium-6 large-6 show-mobile">
				<img class="wicon" src="http://openweathermap.org/img/w/<? echo $weather_icon ?>.png">
			</div>
			<div class="small-12 medium-6 large-6">
				<h3><? echo $name; ?></h3>
		    	<h2 style="color:<?php echo $temp_col; ?>;"><? echo intval($temp_cur), $temp_unit; ?></h2>
		    	<sub><? echo intval($temp_min), $temp_unit . ' - ' . intval($temp_max), $temp_unit; ?><br></sub>
		    	<div class="w-value"><? echo $weather_value ?></div>
			</div>
			<div class="small-12 medium-6 large-6 hide-mobile">
				<img class="wicon" src="http://openweathermap.org/img/w/<? echo $weather_icon ?>.png">
			</div>
			<div class="small-12 medium-12 large-12">
				<p>Wind: <? echo $wind_spd, $wind_unit . "&nbsp;(" . $wind_name . ")";?><br>
				Humidity: <? echo $humidity ?>%<br>
				<? echo substr($rise,11,5); ?> AM <svg data-v-916d5630="" width="17" height="11" viewBox="0 0 17 11" xmlns="http://www.w3.org/2000/svg" class="weather-details__sun-times-icon" aria-hidden="true"><path d="M4.211 7.96a4.193 4.193 0 018.265 0h-1.02a3.194 3.194 0 00-6.225 0H4.21zM.377 9.818a.5.5 0 01.5-.5h15a.5.5 0 010 1h-15a.5.5 0 01-.5-.5zm15.29-3.56a.5.5 0 01-.354.612l-1.411.378a.5.5 0 11-.26-.966l1.412-.378a.5.5 0 01.613.353zM8.377.671a.5.5 0 01.5.5V3.25a.5.5 0 01-1 0V1.172a.5.5 0 01.5-.5zm5.037 2.207a.5.5 0 010 .707L12.38 4.619a.5.5 0 11-.707-.707l1.034-1.033a.5.5 0 01.707 0zM1.149 6.049a.5.5 0 01.612-.353l1.412.378a.5.5 0 01-.259.966l-1.411-.378a.5.5 0 01-.354-.612zM3.34 2.786a.5.5 0 01.707 0L5.081 3.82a.5.5 0 11-.707.707L3.34 3.492a.5.5 0 010-.707z" fill="currentColor"></path></svg><? echo substr($set,11,5); ?> PM</p>
			</div>
		</div>
	</div>