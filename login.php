<?php

require_once 'variable.php';

class Login implements Variable{

    var $user;
    var $sessionData;
    public function __construct($login,$password,$app)
    {
        $this->login($login,$password,$app);
    }

    private function login($login,$password,$app)
    {

        $cred = '{"login":"'.$login.'","password":"'.$password.'","app":"'.$app.'"}';

        $ch = curl_init( $this->SERVER );

        curl_setopt( $ch, CURLOPT_POSTFIELDS, $cred );
        curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));

        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt($ch, CURLOPT_HEADER, true);
        $result = curl_exec($ch);
        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $header = substr($result, 0, $header_size);
        $body = substr($result, $header_size);
        curl_close($ch);
        substr($header, strrpos($header, 'refresh_token: ' )+15, 268);
        $this->user = json_decode($body);
    }

    private function getSessionData()
    {

    }
}