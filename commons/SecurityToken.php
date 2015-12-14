<?php
/**
 * Created by PhpStorm.
 * User: mkt
 * Date: 2015-12-14
 * Time: 17:40
 */

namespace commons;


class SecurityToken
{
    /**
     * @param $formName
     * @return string
     * generates a token used in posts
     * to validate user and mitigate
     * CSRF
     */
    public function generateToken($formName){
        $secretKey='xf3hdgstloy';
        $sessionId = session_id();

        return sha1($formName.$sessionId.$secretKey);
    }

    public function checkToken($token, $formname){
        return $token == $this->generateToken($formname);
    }
}