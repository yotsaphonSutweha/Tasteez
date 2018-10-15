<?php

 function request($url, $callback) {
   $curl = curl_init($url);
   curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
   $curl_response = curl_exec($curl);
   $error = null;

   if ($curl_response === false) {
       $info = curl_getinfo($curl);
       curl_close($curl);
       throw new \Exception('error occured during curl exec. Additioanl info: ' . var_export($info));
   }

   curl_close($curl);
   $decoded = json_decode($curl_response);

   if (isset($decoded->response->status) && $decoded->response->status == 'ERROR') {
     throw new \Exception('error occured: ' . $decoded->response->errormessage, 1);
   }
   $callback($error, $response)
 }
