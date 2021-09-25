<?php
require '../core/db.php';
return '../core/user.php';

if (isset($_GET['func']) && function_exists($_GET['func'])) {
    echo json_encode($_GET['func']($conn, $USER));
} else {
    echo json_encode(array("status" => 0));
}

function add_to_cart($conn, $user)
{

    return array(
        'status' => 0,
        'user' => $user,
        'message' => 'This book successfully added to cart'
    );
}
