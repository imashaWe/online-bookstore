<?php
require '../../core/db.php';


if (isset($_GET['func']) && function_exists($_GET['func'])) {
    $inputs = json_decode(file_get_contents('php://input'));
    echo json_encode($_GET['func']($inputs, $conn));
} else {
    echo json_encode(array("status" => 0, "Invalid url"));
}

//function get_day_wise_orders($inputs, $conn)
//{
//    $to = date("Y-m-d");
//    $from = date("Y-m-d", strtotime('-7 day', strtotime($to)));
//
//
//    $sql = "SELECT COUNT(id) AS num_orders,DATE(created_at) AS `date` FROM `order`
//            WHERE `created_at` BETWEEN '{$from}' AND '{$to}'
//            GROUP BY DAY(created_at)";
//    $res = $conn->query($sql);
//
//    $data = array();
//    while ($row = $res->fetch_array()) $data[] = $row;
//
//    return array('status' => 1, 'data' => $data);
//}

function get_day_wise_orders($inputs, $conn)
{
    $limit = 7;
    $to = date("Y-m-d");
    $from = date("Y-m-d", strtotime('-7 day', strtotime($to)));

    for ($i=0;$i < $limit;$i++) {

    }
    $sql = "SELECT COUNT(id) AS num_orders,DATE(created_at) AS `date` FROM `order`
            WHERE `created_at` BETWEEN '{$from}' AND '{$to}'
            GROUP BY DAY(created_at)";
    $res = $conn->query($sql);

    $data = array();
    while ($row = $res->fetch_array()) $data[] = $row;

    return array('status' => 1, 'data' => $data);
}