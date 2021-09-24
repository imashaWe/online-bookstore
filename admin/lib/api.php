<?php
require "db.php";

if (isset($_GET['func']) && function_exists($_GET['func'])) {
    echo json_encode(array(
        "status" => 1,
        "data" => $_GET['func']($conn)
    ));
} else {
    echo json_encode(array("status" => 0));
}

function get_sub_categories($conn)
{
    if (!isset($_GET['category_id'])) return array();
    $data  =array();
    $category_id = $_GET['category_id'];
    $sql = "SELECT * FROM book_sub_category WHERE category_id = {$category_id}";
    $result = $conn->query($sql);
    while ($row = $result->fetch_array()) $data[] = $row;
    return $data;

}
