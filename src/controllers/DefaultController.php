<?php

require_once 'AppController.php';
require_once __DIR__.'/../repositories/TicketRepository.php';
require_once __DIR__ .'/../models/Ticket.php';

class DefaultController extends AppController {
    private $message = [];
    private $nameCookie;
    private $clientRepository;
    private $itguyRepository;
    private $ticketRepository;

    public function __construct() {
        parent::__construct();
        $this->nameCookie = 'user_id_cookie';
        $this->clientRepository = new ClientRepository();
        $this->itguyRepository = new ITguyRepository();
        $this->ticketRepository = new TicketRepository();
    }

    public function index() {
        $this->render('loginView');
    }

    public function clientView() {
        return $this->render('clientView', ['messages' => $this->message]);
    }

    public function tickets() {
        return $this->render('itguyView', ['messages' => $this->message, 'tickets' => $this->ticket]);
    }
}