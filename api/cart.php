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
    $qty = 1;
    if (isset($inputs->qty)) {
        $qty = $inputs->qty;
    }
    $sql = "SELECT * FROM user_cart WHERE uid = {$uid} AND book_id = {$book_id}";
    $res = $conn->query($sql);
    if ($res->num_rows) {
        return array(
            'status' => 1,
            'message' => 'This book already in cart'
        );
    } else {
        $sql = "INSERT INTO user_cart(uid,book_id,qty) VALUES ({$uid},{$book_id},{$qty});
                INSERT INTO book_stock (book_id,trans_code,trans_id,out_qty) 
                VALUES ({$book_id},'ADD-TO-CART',{$uid},{$qty})";
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

function update_item_qty($inputs, $conn, $user)
{
    $uid = $user['uid'];
    $book_id = $inputs->book_id;
    $qty = $inputs->qty;

    if ($qty) {
        $sql = "UPDATE user_cart SET qty = {$qty} WHERE uid = {$uid} AND book_id = {$book_id};
                UPDATE book_stock SET out_qty = {$qty} 
                WHERE trans_code= 'ADD-TO-CART' AND trans_id = {$uid} AND book_id = {$book_id}";
    } else {
        $sql = "DELETE FROM user_cart WHERE uid = {$uid} AND book_id = {$book_id};
                INSERT INTO book_stock (book_id,trans_code,trans_id,in_qty) 
                VALUES ({$book_id},'REMOVE-FROM-CART',{$uid},{$qty})";
    }

    $res = $conn->multi_query($sql);
    return array('status' => $res, 'sql' => $sql);

}
