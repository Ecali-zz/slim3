<?php

namespace App\Controllers;

class TextPageController
{
    public function __construct()
    {
        $this->text = [
            'PageTitle' => 'Ex Page Title', //Automatically takes the root of the page
            //They do not change
            'login'     => 'login',
            'singin'    => 'singin',
            'quit'      => 'https://www.google.it/',
            'about'     => 'abut',
            //--------------------
            'Userlog'   => 'User',
        ];

        return $this->text;
    }
}