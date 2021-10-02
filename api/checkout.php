<?php
require '../core/db.php';
require '../core/user.php';
require '../core/config.php';

define('config', $_CONFIG);

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


function apply_coupon_code($inputs, $conn, $user)
{
    $uid = $user['uid'];
    $coupon_code = $inputs->coupon_code;
    $today = date("Y-m-d");

    $sql = "SELECT * FROM `coupon_code` 
            WHERE `from` <= '{$today}' AND `to` >= '{$today}' AND `code` = '{$coupon_code}' AND is_delete = 0";
    $res = $conn->query($sql);
    if (!$res->num_rows) {
        return array('status' => 0, 'message' => 'This coupon code invalid or expire.');
    }

    $row = $res->fetch_array();
    $coupon_id = $row['id'];
    $discount = $row['discount'];

    $sql = "SELECT * FROM coupon_code_apply WHERE coupon_id = {$coupon_id} AND uid = {$uid}";
    $res = $conn->query($sql);
    if ($res->num_rows) {
        return array('status' => 0, 'message' => 'This coupon code already use');
    }

    $sql = "INSERT INTO coupon_code_apply(coupon_id,uid) VALUES({$coupon_id},{$uid})";
    $res = $conn->query($sql);
    if ($res) {
        return array(
            'status' => 1,
            'message' => 'This is coupon code is valid',
            'data' => array('discount' => $discount, 'coupon' => $coupon_code)
        );
    } else {
        return array(
            'status' => 0,
            'message' => 'Database error',
        );
    }


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


    $sql = "SELECT coupon_code.* FROM coupon_code_apply 
        INNER JOIN coupon_code ON coupon_code.id = coupon_code_apply.coupon_id AND uid = {$uid} AND order_id = 0";
    $coupons = $conn->query($sql);

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
                INSERT INTO book_stock (book_id,trans_code,trans_id,in_qty) 
                VALUES ({$book_id},'REMOVE-FROM-CART',{$uid},{$qty});
                INSERT INTO book_stock (book_id,trans_code,trans_id,out_qty) 
                VALUES ({$book_id},'PURCHASE',{$order_id},{$qty});
                DELETE FROM user_cart WHERE uid = {$uid} AND book_id = {$book_id};";

    }
    $sql .= "INSERT INTO payment(trans_code,trans_id,out_amount) VALUES('PURCHASE',{$order_id},{$total});";
    while ($row = $coupons->fetch_array()) {
        $coupon_id = $row['id'];
        $discount = $total * $row['discount'];
        $sql .= "INSERT INTO payment(trans_code,trans_id,in_amount) VALUES('COUPON-CODE',{$order_id},{$discount});
                 UPDATE coupon_code_apply SET order_id = {$order_id} WHERE coupon_id = {$coupon_id} AND uid = {$uid};";
        $total -= $discount;
    }
    $res = $conn->multi_query($sql);
    if (!$res) {
        return array('status' => 0, 'message' => 'Database Error');
    }

    return array(
        'status' => 1,
        'message' => 'Order set success',
        'data' => array(
            'merchant_id' => config['PayHere']['merchant_id'],
            'return_url' => 'http://' . $_SERVER['HTTP_HOST'] . '/order-placed.php',
            'cancel_url' => 'http://' . $_SERVER['HTTP_HOST'] . '/order-failed.php',
            'notify_url' => 'http://' . $_SERVER['HTTP_HOST'] . '/checkout.php?func=notify_payment',
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