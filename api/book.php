<?php
require '../core/db.php';
require '../core/user.php';

if (isset($_GET['func']) && function_exists($_GET['func'])) {
    $inputs = json_decode(file_get_contents('php://input'));
    echo json_encode($_GET['func']($inputs, $conn, $USER));
} else {
    echo json_encode(array("status" => 0));
}

function search($inputs, $conn)
{
    if (!isset($_GET['q'])) return array('status' => 0);
    $q = strtoupper($_GET['q']);

    $result = array();

    $sql = "SELECT name as k FROM book WHERE is_delete = 0 AND UPPER(name) LIKE '%{$q}%'
            UNION SELECT isbn as k FROM book WHERE is_delete = 0 AND UPPER(isbn) LIKE '%{$q}%'
            UNION SELECT  CONCAT(book_author.fname,' ',book_author.lname) AS k  FROM book_author 
            WHERE is_delete = 0 AND (UPPER(fname) LIKE '%{$q}%' OR UPPER(lname) LIKE '%{$q}%')
            UNION SELECT category AS k FROM book_category WHERE is_delete = 0 AND UPPER(category) LIKE '%{$q}%'
            UNION SELECT sub_category as k FROM book_sub_category WHERE is_delete = 0 AND UPPER(sub_category) LIKE '%{$q}%'
            UNION SELECT name as k FROM book_publisher WHERE is_delete = 0 AND UPPER(name) LIKE '%{$q}%'";

    $res = $conn->query($sql);
    while ($row = $res->fetch_array()) $result[] = $row['k'];

    return array('status' => 1, 'data' => $result);


}