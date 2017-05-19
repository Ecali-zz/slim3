<?php
namespace App\Controllers;


class TextPageControll{

    public function __construct(){
        $this->text= array(
            'login' => 'login',
            'singin' => 'singin',
            'quit' => 'https://www.google.it/',
            'about' => 'abut'
        );
         return $this->text;
    }

}