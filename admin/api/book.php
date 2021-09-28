<?php
require '../../core/db.php';


if (isset($_GET['func']) && function_exists($_GET['func'])) {
    $inputs = json_decode(file_get_contents('php://input'));
    echo json_encode($_GET['func']($inputs, $conn));
} else {
    echo json_encode(array("status" => 0));
}

function search_book($inputs, $conn)
{
    if (!isset($_GET['q'])) return array();
    $q = $_GET['q'];

    $sql = "SELECT book.id,CONCAT(book.name,'-',book.isbn) AS name FROM book WHERE is_delete = 0
            AND (name LIKE '%{$q}%')";
    $res = $conn->query($sql);

    $data = array();
    while ($row = $res->fetch_array()) $data[] = array('name' => $row['name'], 'id' => $row['id']);
    return array('status' => 1, 'data' => $data);
}

function get_sub_categories($inputs, $conn)
{
    if (!isset($_GET['category_id'])) return array();
    $data = array();
    $category_id = $_GET['category_id'];
    $sql = "SELECT * FROM book_sub_category WHERE category_id = {$category_id}";
    $result = $conn->query($sql);

    while ($row = $result->fetch_array()) $data[] = $row;

    return array('status' => 1, 'data' => $data);

}