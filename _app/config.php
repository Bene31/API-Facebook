<?php

session_start();
require_once 'Facebook/autoload.php';

$fb = new Facebook\Facebook([
    'app_id' => '460545798018223',
    'app_secret' => 'fd458614261041563be12fc560362d80',
    'default_graph_version' => 'v3.2',
]);
	
/*try {
  // Returns a `Facebook\FacebookResponse` object
  $response = $fb->get('/me?fields=id,name', '{access-token}');
} catch(Facebook\Exceptions\FacebookResponseException $e) {
  echo 'Graph returned an error: ' . $e->getMessage();
  exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
  echo 'Facebook SDK returned an error: ' . $e->getMessage();
  exit;
}

$user = $response->getGraphUser();

echo 'Name: ' . $user['name'];
// OR
// echo 'Name: ' . $user->getName();*/
