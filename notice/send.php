<?php

require('Pusher.php');
$options = array(
    'encrypted' => false
);
$pusher = new Pusher(
    '124c57e264a19f011fee', '73e1eb4adfaf15fb6a46', '407879', $options
);
$data['name'] = 'Sale App';
$data['message'] = 'Đây là tin nhắn test realtime với pusher';
$pusher->trigger('saleapp', 'themkhach', $data);
//Freetuts la ten kenh ban dat la gi thuy
//notice la su kien ban dat gi cung duoc ban co the tao ra nhieu kenh
//data la du lieu gui di
?>