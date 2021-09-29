<?php
require '../core/db.php';
require '../core/user.php';

if (isset($_GET['func']) && function_exists($_GET['func'])) {
    if (IS_LOGGED_IN) {

        $inputs = json_decode(file_get_contents('php://input'));
        echo json_encode($_GET['func']($inputs, $conn, $USER));

    } else {

        echo json_encode(array('status' => 0, 'message' => 'Please login to get access to this feature'));

    }
} else {

    echo json_encode(array("status" => 0, 'message' => 'Invalid url'));

}


function add_to_wishlist($inputs, $conn, $user)
{
    $book_id = $inputs->book_id;
    $uid = $user['uid'];

    $sql = "SELECT * FROM user_wishlist WHERE book_id = {$book_id} AND uid = {$uid}";
    $res = $conn->query($sql);
    if ($res->num_rows) {
        return array('status' => 1, 'message' => "This book is already in wishlist");
    }

    $sql = "INSERT INTO user_wishlist(book_id,uid) VALUES({$book_id},{$uid})";
    $res = $conn->query($sql);
    if ($res) {
        return array('status' => 1, 'message' => "This book successfully added to wishlist");
    } else {
        return array('status' => 0, 'message' => "Something went wrong");
    }
}

function remove_from_wishlist($inputs, $conn, $user)
{
    $book_id = $inputs->book_id;
    $uid = $user['uid'];

    $sql = "DELETE FROM user_wishlist WHERE book_id = {$book_id} AND uid = {$uid}";
    $res = $conn->query($sql);
    if ($res) {
        return array('status' => 1, 'message' => "This book successfully removed from wishlist");
    } else {
        return array('status' => 0, 'message' => "Something went wrong");
    }
}

function get_wishlist_ids($inputs, $conn, $user)
{
    $uid = $user['uid'];

    $sql = "SELECT * FROM user_wishlist WHERE uid = {$uid}";
    $res = $conn->query($sql);

    $data = [];
    while ($row = $res->fetch_array()) $data[] = $row['book_id'];

    return array('status' => 1, 'data' => $data);

}