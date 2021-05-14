<?php

require_once 'const.php';

require_once 'ec_common.php';
require_once 'doushin_next_function.php';

$err_msg   = [];
$msg       = [];
$name = '';
$mail  = '';
$tell = '';
$subject  = '';
$explanation = '';
$date      = date('Y-m-d H:i:s');

$link = get_db_connect();

$request_method = get_request_method();

if ($request_method === 'POST') {
    $name = get_post_date('name');
    $mail  = get_post_date('mail');
    $tell = get_post_date('tell');
    $subject  = get_post_date('subject');
    $explanation  = get_post_date('explanation');

    check_name($name);
    check_mail($mail);
    check_tell($tell);
    check_subject($subject);
    check_explanation($explanation);

    if (count($err_msg) === 0) {
        check_same_user($link, $user_name);
    }
    if (count($err_msg) === 0) {
        insert_user_info($link, $name, $mail, $tell, $subject, $explanation, $date);
        }
    }

close_db_connect($link);

include_once 'doushin_index.php';
