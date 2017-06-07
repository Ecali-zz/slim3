<?php
namespace App\Connection;

class Database
{
    private $pdo;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function queryuser()
    {
        $req = $this->pdo->prepare('SELECT * FROM users');
        $req->execute();

        return $req->fetchAll();
    }

    public function querypost()
    {
        $req = $this->pdo->prepare('SELECT * FROM posts');
        $req->execute();
        return $req->fetchAll();
    }
    public function addpost( $title, $body,$img)
    {

        $str="INSERT INTO posts(title,body,img) VALUES ('".$title."','".$body."','".$img."')";
        $req = $this->pdo->prepare($str);
       //die(var_dump($str));
        $req->execute();

        //return $req->fetchAll();
    }

    public function queryvideo()
    {
        $req = $this->pdo->prepare('SELECT * FROM video');
        $req->execute();

        return $req->fetchAll();
    }
    public function queryvideotags($tag)
    {
        $req = $this->pdo->prepare('SELECT * FROM video WHERE tag ="'.$tag.'"');
        $req->execute();
                return $req->fetchAll();
    }

    public function queryvideoprotect()
    {
        $req = $this->pdo->prepare('SELECT * FROM video WHERE protetto ="1"');
        $req->execute();
        return $req->fetchAll();
    }

    public function queryvideononprotect()
    {
        $req = $this->pdo->prepare('SELECT * FROM video WHERE protetto ="0"');
        $req->execute();
        return $req->fetchAll();
    }

    public function addvideo( $title, $embed,$tag,$protetto,$playlist)
    {
        $str="INSERT INTO video(titolovideo,playlist,embed,protetto,tag) VALUES ('".$title."','".$playlist."','".$embed."','".$protetto."','".$tag."')";
        $req = $this->pdo->prepare($str);
        //die(var_dump($str));
        $req->execute();

        //return $req->fetchAll();
    }
    public function deletevideo( $title )
    {
        $str='DELETE FROM `video` WHERE titolovideo = "'.$title.'"';
        $req = $this->pdo->prepare($str);
        //die(var_dump($str));
        $req->execute();

        //return $req->fetchAll();
    }
    public function querytitlevideo( $title )
    {
        $str='SELECT * FROM `video` WHERE titolovideo = "'.$title.'"';
        $req = $this->pdo->prepare($str);
        //die(var_dump($str));
        $req->execute();
        return $req->fetchAll();
    }
}



