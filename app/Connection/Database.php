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
}
