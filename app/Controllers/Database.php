<?php


class Database{

    private $pdo;

    public function __construct(PDO $pdo){

        $this->pdo = $pdo;
    }

    public function query($sql){
        $req = $this->pdo->prepare( 'SELECT * FROM posts');
        $req->execute();
        return $req->fetchAll();
    }

}