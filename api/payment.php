<?php
require '../core/db.php';
require '../core/config.php';

define('config', $_CONFIG);

if (isset($_GET['func']) && function_exists($_GET['func'])) {

    $inputs = json_decode(file_get_contents('php://input'));
    echo json_encode($_GET['func']($inputs, $conn));

} else {

    echo json_encode(array("status" => 0, 'message' => 'Invalid url'));

}


function notify_payment($inputs, $conn)
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
            $sql .= "INSERT INTO book_stock (book_id,trans_code,trans_id,in_qty) 
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