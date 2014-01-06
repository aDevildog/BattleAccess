<?php
/**
 *
 * @Author      Johnathon "Devildog" Holmes
 * @Version     1.0 (initial)
 * @Package     BattleAccess
 * @Copyright   Copyright (c) 2013, Johnathon "Devildog" Holmes
 *
 */

//Required files
require_once 'BattleAccessContainer.php';
require_once 'BattleAccessServer.php';

//Define constants for use mainly by cURL
define ('COOKIE_FILE', 'cookies.txt'); //Where cookies will be stored.
define ('USER_AGENT', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:6.0.2) Gecko/20100101 Firefox/6.0.2'); //Act like a real browser
define ('LOGIN_URL', 'http://battlelog.battlefield.com/bf4/gate/'); //Login page for Battlelog

class Battlelog
{
    private $username = null;       //Battlelog email
    private $password = null;       //Battlelog password
    private $credentials = false;

    public function __construct($username, $password)
    {
        $this->username = (string) $username;
        $this->password = (string) $password;
    }

    public function getUrl ($url, $battlelog = true) {
        if (!$this->credentials)
        {
            $this->_getCredentials();
            $this->credentials = true;
        }

        if ($battlelog === true)
        {
            $ch = curl_init("http://battlelog.battlefield.com/$url");
            curl_setopt($ch, CURLOPT_COOKIEFILE, COOKIE_FILE);
        }
        else
            $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_HTTPHEADER, array (
            'Expect:',
            'User-Agent: ' . USER_AGENT,
            'Accept: */*',
            'Accept-Language: en-us,en;q=0.5',
            'Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7',
            'X-Requested-With: XMLHttpRequest',
            'X-AjaxNavigation: 1'
        ));

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_ENCODING, "gzip");
        $data = curl_exec($ch);
        curl_close($ch);

        return $data;
    }

    private function _getCredentials() {
        $postchars = http_build_query(array(
            'redirect' => '|bf4|',
            'email' => $this->username,
            'password' => $this->password,
            'submit' => 'Sign+in'
        ), '', '&');

        $ch = curl_init(LOGIN_URL);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Expect:',
            'User-Agent: ' . USER_AGENT,
            'Accept: */*',
            'Accept-Language: en-us,en;q=0.5',
            'Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7'
        ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_COOKIEJAR, COOKIE_FILE);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postchars);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_exec($ch);
        curl_close($ch);
    }

    public function getServer ($serverId)
    {
        return new Server($this, $serverId, true);
    }
}