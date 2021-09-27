<?php
require '../core/db.php';
require '../core/user.php';
require '../core/config.php';

define('config', $_CONFIG);

if (isset($_GET['func']) && function_exists($_GET['func'])) {
    $inputs = json_decode(file_get_contents('php://input'));
    echo json_encode($_GET['func']($inputs, $conn, $USER));
} else {
    echo json_encode(array("status" => 0));

}

function set_order($inputs, $conn, $user)
{
    $uid = $user['uid'];
    $city = $inputs->city;
    $address_line1 = $inputs->address_line1;
    $address_line2 = $inputs->address_line2;
    $post_code = $inputs->post_code;

    $sql = "SELECT * FROM site_user WHERE id = {$uid};";
    $user_res = $conn->query($sql)->fetch_array();
    $fname = $user_res['fname'];
    $lname = $user_res['lname'];
    $email = $user_res['email'];

    $sql = "SELECT book.*,user_cart.qty FROM user_cart 
            INNER JOIN book ON book.id = user_cart.book_id
            WHERE user_cart.uid = {$uid};";
    $cart_res = $conn->query($sql);

    $sql = " INSERT INTO `order`(uid,city,address_line1,address_line2,post_code) 
            VALUES({$uid},'{$city}','{$address_line1}','{$address_line2}',{$post_code});";
    $res = $conn->query($sql);
    if (!$res) {
        return array('status' => 0, 'message' => 'Database Error');
    }

    $order_id = $conn->insert_id;

    $sql = "DELETE FROM site_user_address WHERE uid = {$uid};
            INSERT INTO site_user_address VALUES ({$uid},'{$city}','{$address_line1}','{$address_line2}',{$post_code});";

    $total = 0;

    while ($row = $cart_res->fetch_array()) {
        $book_id = $row['id'];
        $qty = $row['qty'];
        $price = $row['price'];

        $total += $qty * $price;

        $sql .= "INSERT INTO order_item VALUES({$order_id},{$book_id},{$qty},{$price});
                INSERT INTO book_store (book_id,trans_code,trans_id,in_qty) 
                VALUES ({$book_id},'REMOVE-FROM-CART',{$uid},{$qty});
                INSERT INTO book_store (book_id,trans_code,trans_id,out_qty) 
                VALUES ({$book_id},'PURCHASE',{$order_id},{$qty});
                DELETE FROM user_cart WHERE uid = {$uid} AND book_id = {$book_id};";

    }
    $sql .= "INSERT INTO payment(trans_code,trans_id,out_amount) VALUES('PURCHASE',{$order_id},{$total});";
    $res = $conn->multi_query($sql);
    if (!$res) {
        return array('status' => 0, 'message' => 'Database Error');
    }

    return array(
        'status' => 1,
        'message' => 'Order set success',
        'data' => array(
            'merchant_id' => config['PayHere']['merchant_id'],
            'return_url' => $_SERVER['HTTP_HOST'],
            'cancel_url' => $_SERVER['HTTP_HOST'],
            'notify_url' => $_SERVER['HTTP_HOST'],
            'order_id' => $order_id,
            'items' => '',
            'currency' => 'LKR',
            'amount' => $total,
            'first_name' => $fname,
            'email' => $email,
            'phone' => '0771234567',
            'address' => "{$address_line1},{$address_line2}",
            'city' => "{$city}",
            'country' => "{$city}",
        )
    );


}

function notify_payment($inputs, $conn, $user)
{
    $merchant_id = $_POST['merchant_id'];
    $order_id = $_POST['order_id'];
    $payhere_amount = $_POST['payhere_amount'];
    $payhere_currency = $_POST['payhere_currency'];
    $status_code = $_POST['status_code'];
    $md5sig = $_POST['md5sig'];

    if ($status_code == 2) {
        $now = date('Y:m:d H:i:s');
        $sql = "UPDATE `order` SET `status` = 1,paid_at = '{$now}' WHERE id = {$order_id};
                INSERT INTO payment(trans_code,trans_id,in_amount) 
                VALUES('PURCHASE-PAYMENT',{$order_id},{$payhere_amount});";
    } elseif ($status_code == -1 || $status_code = -2) {
        $sql = "SELECT * FROM order_item WHERE order_id = {$order_id}";
        $res = $conn->query($sql);
        $sql = "UPDATE `order` SET `status` = {$status_code} WHERE id = {$order_id};
                INSERT INTO payment(trans_code,trans_id,in_amount) 
                VALUES('PURCHASE-CANCEL',{$order_id},{$payhere_amount});";
        while ($row = $res->fetch_array()) {
            $book_id = $row['book_id'];
            $qty = $row['qty'];
            $sql .= "INSERT INTO book_store (book_id,trans_code,trans_id,in_qty) 
                     VALUES ({$book_id},'PURCHASE-CANCEL',{$order_id},{$qty});";
        }
    } else {
        return array('status' => 0, 'message' => 'No updates');
    }
    $res = $conn->multi_query($sql);
    if (!$res) {
        return array('status' => 0, 'message' => 'Database Error');
    } else {
        return array('status' => 1, 'message' => 'Update success');
    }

}