<?php
require '../core/db.php';
require '../core/user.php';

if (isset($_GET['func']) && function_exists($_GET['func'])) {
    $inputs = json_decode(file_get_contents('php://input'));
    echo json_encode($_GET['func']($inputs, $conn, $USER));
} else {
    echo json_encode(array("status" => 0));
}

function add_to_cart($inputs, $conn, $user)
{
    $uid = $user['uid'];
    $book_id = $inputs->book_id;
    $sql = "SELECT * FROM user_cart WHERE uid = {$uid} AND book_id = {$book_id}";
    $res = $conn->query($sql);
    if ($res->num_rows) {
        return array(
            'status' => 1,
            'message' => 'This book already in cart'
        );
    } else {
        $sql = "INSERT INTO user_cart(uid,book_id) VALUES ({$uid},{$book_id});
                INSERT INTO book_store (book_id,trans_code,trans_id,out_qty) 
                VALUES ({$book_id},'ADD-TO-CART',{$uid},1)";
        $res = $conn->multi_query($sql);
        if ($res) {
            return array(
                'status' => 1,
                'message' => 'This book successfully added to card'
            );
        } else {
            return array(
                'status' => 0,
                'message' => 'Something went wrong',
                'sql' => $sql
            );
        }
    }
}

function get_cart_items($inputs, $conn, $user)
{
    $uid = $user['uid'];
    $data = array();
    $sql = "SELECT book.*,user_cart.qty FROM user_cart 
            INNER JOIN book ON book.id = user_cart.book_id
            WHERE user_cart.uid = {$uid}";
    $res = $conn->query($sql);
    while ($row = $res->fetch_array()) $data[] = $row;
    return array(
        'status' => 1,
        'data' => $data
    );
}


function get_cart_count($inputs, $conn, $user)
{
    $uid = $user['uid'];

    $sql = "SELECT COUNT(book_id) AS `count` FROM user_cart 
            WHERE uid = {$uid}";
    $res = $conn->query($sql);

    return array(
        'status' => 1,
        'count' => $res->fetch_array()['count']
    );
}
