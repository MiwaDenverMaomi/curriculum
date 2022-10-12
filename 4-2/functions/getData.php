<?php
require_once("pdo.php");

class getData{

    public $pdo;
    public $data;

    //コンストラクタ
    function __construct()  {
        $this->pdo = connect();
    }

    /**
     * ユーザ情報の取得
     *
     * @param
     * @return array $users_data ユーザ情報
     */
    public function getUserData(){
        debug('getUserData');
        $getusers_sql = "SELECT * FROM users limit 1";
        $users_data = $this->pdo->query($getusers_sql)->fetch(PDO::FETCH_ASSOC);
        debug('$users_data中身：'.print_r($users_data,true));
        return $users_data;
    }

    /**
     * 記事情報の取得
     *
     * @param
     * @return array $post_data 記事情報
     */
    public function getPostData(){
        debug('getPostData');
        $getposts_sql = "SELECT * FROM posts ORDER BY id desc";
        $post_data = $this->pdo->query($getposts_sql);
        debug('$post_data=:'.print_r($post_data,true));
        return $post_data;
    }
}
