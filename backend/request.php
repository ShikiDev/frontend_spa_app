<?php
include_once 'curl.php';

use Curl\CurlWorker;

if(!empty($_GET['get_data'])){
    $result = CurlWorker::getData(true);
} else {
    $result['status'] = 'error';
    $result['message'] = 'Wrong request';
    $result['data'] = [];
}

echo json_encode($result);