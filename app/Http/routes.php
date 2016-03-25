<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::group(['middleware' => ['web']], function () {

    Route::get('/thorn/{action}', function ($action) {
        $email = 'josh@fastpxl.com';
        $apiKey = 'ef35538f8d5635271f2728c010dbfadb1b99e';
        $zoneID = 'd107b424b4608852fd14f63ca6fc0e7c';
        $dnsID = 'ab5e70381df726b8d58cc7e5c071c8f1';
        
        if ($action == 'backup') {
          $newIP = '198.185.159.144';
        } else {
          $newIP = '45.79.159.18';
        }
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://api.cloudflare.com/client/v4/zones/$zoneID/dns_records/$dnsID");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
    
        $headers = [ 
            'X-Auth-Email: '.$email,
            'X-Auth-Key: '.$apiKey,
            'Content-Type: application/json'
        ];
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    
        $dnsData = [
          'id' => $dnsID,
          'type' => 'A',
          'name' => 'thethorn.net',
          'content' => $newIP,
        ];
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($dnsData));
    
    
        echo "posting to API<br />";
        $result = curl_exec($ch);
        echo "Result: " . $result;
    });

});
