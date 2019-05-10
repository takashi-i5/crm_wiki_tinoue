<?php

# エラー時にディスプレイに出力
ini_set('display_errors', 1);

# PDOのための設定
define('DSN', 'mysql:host=db;dbname=dotinstall_todo_app');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', 'password');
