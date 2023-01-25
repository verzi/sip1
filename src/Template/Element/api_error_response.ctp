<?php
$r = [
    'status' => isset($status) ? $status : '',
    'developerMessage' => isset($developerMessage) ? $developerMessage : 'Error 4XX',
    'userMessage' => isset($userMessage) ? $userMessage : 'Error',
    'errorCode' => isset($errorCode) ? $errorCode : '',
    'moreInfo' => isset($moreInfo) ? $moreInfo : '',
];

echo json_encode($r);