<?php
$url = "https://celestrak.com/pub/TLE/catalog.txt";
$cache_file = 'catalog.cache';
$cache_time = 60 * 60 * 24; // In seconds

if (file_exists($cache_file) && time() - filemtime($cache_file) < $cache_time) {
    // Cache is still fresh
    $cache = file_get_contents($cache_file);
} else {
    // Cache is too old or doesn't exist, fetch and store new data
    $cache = file_get_contents($url);
    file_put_contents($cache_file, $cache);
}

// Process TLE data for all satellites
processTLE($cache);

function processTLE($cache) {
    $lines = explode("\n", $cache);
    $satellites = [];
    $currentSatellite = [];

    foreach ($lines as $line) {
        // Assuming TLE lines have 3 lines per satellite
        $currentSatellite[] = $line;
        
        if (count($currentSatellite) === 3) {
            // Process TLE data for the current satellite
            $satellites[] = $currentSatellite;
            $currentSatellite = [];
        }
    }

    // Now you have an array $satellites containing TLE data for all satellites
    // You can perform further processing or storage here
    foreach ($satellites as $satellite) {
        $name = trim($satellite[0]);
        $tle = implode("\n", $satellite);
        // Store $tle or perform further processing
        $filename = "C:\\Users\\sahil\\Downloads\\satellitetracker-master\\satellitetracker-master\\assets\\tle\\$name.txt";
        file_put_contents($filename, $tle);
    }
}
