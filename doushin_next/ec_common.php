<?php
function entity_str($strlen) {
    return htmlspecialchars($strlen, ENT_QUOTES, HTML_CHARACTER_SET);
}

function entity_assoc_array($assoc_array) {
    foreach ($assoc_array as $key => $value) {
        
        foreach ($value as $keys => $values) {
            $assoc_array[$key][$keys] = entity_str($values);
        }
    }
    return $assoc_array;
}

function get_db_connect() {
    if (!$link = mysqli_connect(DB_HOST, DB_USER, DB_PASSWD, DB_NAME)) {
        die('error: ' . mysqli_connect_error());
    }
    
    mysqli_set_charset($link, DB_CHARACTER_SET);
    return $link;
}

function close_db_connect($link) {
    mysqli_close($link);
}

function transaction_start($link) {
    return mysqli_autocommit($link, false);
}

function transaction_commit($link) {
    return mysqli_commit($link);
}

function transaction_rollback($link) {
    return mysqli_rollback($link);
}

function get_as_array($link, $sql) {
    $data = [];
    if ($result = mysqli_query($link, $sql)) {
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $data[] = $row;
            }
        }
        mysqli_free_result($result);
    }
    return $data;
}

function insert_db($link, $sql) {
    if (mysqli_query($link, $sql) === TRUE) {
        return TRUE;
    } else {
        return FALSE;
    }
}

function insert($link,$sql, $user_name) {
    if (mysqli_query($link, $sql, $user_name) !== 'user_name') {
        return TRUE;
    } else {
        return FALSE;
    }
}

function get_request_method() {
    return $_SERVER['REQUEST_METHOD'];
}

function get_post_date($key) {
    
    $str = '';
    
    if (isset($_POST[$key]) === TRUE) {
        $str = trim($_POST[$key]);
    }
    return $str;
}

function check_login_user() {
    if (isset($_SESSION['user_id']) === TRUE) {
       $user_id = $_SESSION['user_id'];
    } else {
       // 非ログインの場合、ログインページへリダイレクト
       header('Location: login.php');
       exit;
    }
    return $user_id;
}

function get_user_name($link, $user_id) {
    // user_idからユーザ名を取得するSQL
    $sql = 'SELECT user_name 
            FROM user_info 
            WHERE user_id = ' . $user_id;
    // SQL実行し登録データを配列で取得
    $data = get_as_array($link, $sql);
    // データベース切断
    // ユーザ名を取得できたか確認
    if (isset($data[0]['user_name'])) {
        $user_name = $data[0]['user_name'];
    } else {
       // ユーザ名が取得できない場合、ログアウト処理へリダイレクト
        close_db_connect($link);
        header('Location: logout.php');
        exit;
    }
    return $user_name;
}

function check_login_admin() {
    if (isset($_SESSION['user_id'])) {
        if ($_SESSION['user_id'] !== 'admin') {
            header('Location: logout.php');
            exit;
        }
    } else {
        header('Location: logout.php');
        exit;
    }
}