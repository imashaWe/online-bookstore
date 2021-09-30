<?php
require '../../core/db.php';


if (isset($_GET['func']) && function_exists($_GET['func'])) {
    $inputs = json_decode(file_get_contents('php://input'));
    echo json_encode($_GET['func']($inputs, $conn));
} else {
    echo json_encode(array("status" => 0, "Invalid url"));
}

function get_day_wise_orders($inputs, $conn)
{
    $limit = 7;
    $today = date("Y-m-d");
    $data = array();

    for ($i = 0; $i <= $limit; $i++) {
        $days = $limit - $i;
        $date = date("Y-m-d", strtotime("-{$days} day", strtotime($today)));
        $sql = "SELECT COUNT(id) AS count,DATE(created_at) AS `date` FROM `order`
                WHERE DATE(created_at) = '{$date}'";
        $res = $conn->query($sql);
        $row = $res->fetch_array();
        $data[] = array('count' => $row['count'], 'date' => date("F j", strtotime($date)));

    }


    return array('status' => 1, 'data' => $data);
}

function get_month_wise_orders($inputs, $conn)
{

    $months = array(
        'Jan',
        'Feb',
        'Mar',
        'Apr',
        'May',
        'Jun',
        'Jul',
        'Aug',
        'Sep',
        'Oct',
        'Nov',
        'Dec'
    );

    $this_month = date("m");
    $data = array();

    for ($i = 1; $i <= $this_month; $i++) {

        $sql = "SELECT COUNT(id) AS count,DATE(created_at) AS `date` FROM `order`
                WHERE MONTH (created_at) = '{$i}'";
        $res = $conn->query($sql);
        $row = $res->fetch_array();
        $data[] = array('count' => $row['count'], 'month' => $months[$i - 1]);

    }


    return array('status' => 1, 'data' => $data);
}