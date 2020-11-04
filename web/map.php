<?php

function map($lat, $lon, $zoom)
{
    $embed = "https://embed.windy.com/embed2.html?lat={$lat}&lon={$lon}&detailLat={$lat}&detailLon={$lon}&width=650&height=450&zoom={$zoom}&level=surface&overlay=wind&product=ecmwf&menu=&message=&marker=&calendar=now&pressure=&type=map&location=coordinates&detail=&metricWind=default&metricTemp=default&radarRange=-1";
    $sectionStart = '<section class="content-b">';
    $iframe = '<iframe width="100%" height="100%" src="' . $embed . '"frameborder="0"></iframe>';
    $sectionEnd = '</section>';
    return $sectionStart . $iframe . $sectionEnd;
}
