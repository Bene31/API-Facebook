<?php

require ('Facebook/autoload.php');

$facebook = new Facebook(array(
    'appId' => '460545798018223',
    'secret' => 'fd458614261041563be12fc560362d80',
));

$perm = 'public_profile, email';

$urlLogin = $facebook -> getLoginUrl(array('scope'=>$perm));

$user = $facebook->getUser;

if($user){
    try{
        $facebook->api('/me');
    }catch(FacebookApiException $e){
        $user = null;
    }
}
