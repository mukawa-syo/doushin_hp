<?php
function check_same_user($link, $user_name) {
    global $err_msg;
    $sql = 'SELECT user_id
            FROM user_info
            WHERE user_name = "' . $user_name . '"';
    $data = get_as_array($link, $sql);
    if (count($data) > 0) {
        $err_msg[] = '既に同じユーザが登録されています';
    }
}

function insert_user_info($link, $name, $mail, $tell, $subject, $explanation, $date) {
    global $err_msg, $msg;
    $sql = 'INSERT INTO user_info(name, mail, tell, subject, explanation, created_date)
            VALUES ("'. $name . '", "' . $mail . '", "' . $tell . '", "' . $subject . '", "'. $explanation . '", "' . $date . '")';
    if (insert_db($link, $sql) !== TRUE) {
        $err_msg[] = 'user_infoにインサート失敗';
    } else {
        $msg[] = 'send complety';
    }
}

function check_name($name) {
    global $err_msg;
    if (mb_strlen($name) === 0) {
        $err_msg[] = '名前を入力してください';
    }
}

function check_mail($mail) {
    global $err_msg;
    if (mb_strlen($mail) === 0) {
        $err_msg[] = 'メールを入力してください';
    }
}

function check_tell($tell) {
    global $err_msg;
    if (mb_strlen($tell) === 0) {
        $err_msg[] = '電話番号を入力してください';
    }
}

function check_subject($subject) {
    global $err_msg;
    if (mb_strlen($subject) === 0) {
        $err_msg[] = '件名を入力してください';
    }
}

function check_explanation($explanation) {
    global $err_msg;
    if (mb_strlen($explanation) === 0) {
        $err_msg[] = '内容を入力してください';
    }
}
