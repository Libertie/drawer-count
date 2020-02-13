<?php

function dd($var)
{
    echo '<pre>';
    print_r($var);
    die;
}

function redirect($location, $message = null)
{
    $_SESSION['msg'] = $message;
    header('Location: ' . $location);
    exit();
}
