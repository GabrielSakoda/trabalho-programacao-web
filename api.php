<?php

function fetchFipe($endpoint) {
    $url = 'https://fipe.parallelum.com.br/api/v2/' . $endpoint;
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Accept: application/json']);
    $response = curl_exec($ch);
    curl_close($ch);

    return json_decode($response, true);
}
