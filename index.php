<?php

require 'Routing.php';

$path = trim($_SERVER['REQUEST_URI'], '/');
$path = parse_url( $path, PHP_URL_PATH);

Routing::get('', 'DefaultController');
Routing::get('form', 'DefaultController');
Routing::get('tickets', 'TicketController');
Routing::get('logout', 'SecurityController');
Routing::get('itlogout', 'SecurityController');

Routing::post('login', 'SecurityController');
Routing::post('itlogin', 'SecurityController');
Routing::post('createTicket', 'TicketController');
Routing::post('editStatus', 'TicketController');
Routing::post('editPriority', 'TicketController');
Routing::post('editAssignee', 'TicketController');
Routing::post('search', 'TicketController');
Routing::post('filter', 'TicketController');

Routing::run($path);