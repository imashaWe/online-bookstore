<?php

$routes = array(
    array('path' => 'index.php', 'name' => 'Home'),
    array('path' => 'about.php',  'name' => 'About Us'),
    array('path' => 'contact-us.php',  'name' => 'Contact Us'),
);


function check_route_active($route)
{
    $this_route = basename($_SERVER['PHP_SELF']);
    return $this_route == $route;
}

function change_url_params($key, $value)
{
    $query = $_GET;
    // replace parameter(s)
    $query[$key] = $value;
    // rebuild url
    $new_query = http_build_query($query);
    // plain url
    $url = explode("?", $_SERVER['REQUEST_URI'])[0];

    return $url . "?" . $new_query;
}

function change_url_params_array($ary)
{
    $query = $_GET;
    foreach ($ary as $a) {
        if (isset($a['value'])) {
            $query[$a['key']] = $a['value'];
        } else {
            unset($query[$a['key']]);
        }
    }
    $new_query = http_build_query($query);
    $url = explode("?", $_SERVER['REQUEST_URI'])[0];

    return $url . "?" . $new_query;
}