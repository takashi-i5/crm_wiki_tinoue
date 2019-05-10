<?php

// CSRF対策
// Token発行してSessionに格納
// フォームからもTokenを発行、送信
// Check

namespace MyApp;

class Word
{
    private $_db;

    public function __construct()
    {
        $this->_createToken();

        try {
            $this->_db = new \PDO(DSN, DB_USERNAME, DB_PASSWORD);
            $this->_db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            echo $e->getMessage();
            exit;
        }
    }

    private function _createToken()
    {
        if (!isset($_SESSION['token'])) {
            $_SESSION['token'] = bin2hex(openssl_random_pseudo_bytes(16));
        }
    }

    public function getAll()
    {
        $stmt = $this->_db->query("select * from words order by id desc");
        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }

    public function post()
    {
        $this->_validateToken();

        if (!isset($_POST['mode'])) {
            throw new \Exception('mode not set!');
        }

        switch ($_POST['mode']) {
      case 'update':
        return $this->_update();
      case 'create_word':
        return $this->_create_word();
      case 'delete':
        return $this->_delete();
    }
    }

    private function _validateToken()
    {
        if (
      !isset($_SESSION['token']) ||
      !isset($_POST['token']) ||
      $_SESSION['token'] !== $_POST['token']
    ) {
            throw new \Exception('invalid token!');
        }
    }

    private function _create_word()
    {
        // if (!isset($_POST['word']) || $_POST['word'] === '') {
        //     throw new \Exception('[create] word not set!');
        // }

        $sql = "insert into words (word, meaning) values (:word, :meaning)";
        // error_log($_POST['meaning']);

        // $sql = "insert into words (word) values (:word)";
        $stmt = $this->_db->prepare($sql);
        $stmt->execute([':word' => $_POST['word'], ':meaning' => $_POST['meaning']]);
        // $stmt->execute([':word' => $_POST['word']]);

        return [
      'id' => $this->_db->lastInsertId()
    ];
    }

    private function _update()
    {
        $sql = "update words set meaning =:meaning where id =:id";
        $stmt = $this->_db->prepare($sql);
        $stmt->execute([':id' => $_POST['id'], ':meaning' => $_POST['meaning']]);

        return [];
    }

    private function _delete()
    {
        $sql = sprintf("delete from words where id = %d", $_POST['id']);
        $stmt = $this->_db->prepare($sql);
        $stmt->execute();

        return [];
    }
}
