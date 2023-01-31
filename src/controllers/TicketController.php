<?php

require_once 'AppController.php';
require_once __DIR__.'/../repositories/ClientRepository.php';
require_once __DIR__.'/../repositories/TicketRepository.php';
require_once __DIR__ .'/../models/Client.php';
require_once __DIR__ .'/../models/Ticket.php';

class TicketController extends AppController {
    private $message = [];
    private $itCookie;
    private $clientCookie;
    private $clientRepository;
    private $itguyRepository;
    private $ticketRepository;

    public function __construct() {
        parent::__construct();
        $this->itCookie = 'itguy_id_cookie';
        $this->clientCookie = 'client_id_cookie';
        $this->clientRepository = new ClientRepository();
        $this->itguyRepository = new ITguyRepository();
        $this->ticketRepository = new TicketRepository();
    }

    public function tickets() {
        if (!isset($_COOKIE[$this->itCookie])) {
            $this->render('itloginView');
        }

        $id_user = $_COOKIE[$this->itCookie];
        $user = $this->itguyRepository->getITguyById($id_user);

        $tickets = $this->ticketRepository->getTickets();

        return $this->render('itguyView', ['user' => $user, 'tickets' => $tickets]);
    }

    public function createTicket() {
        if (!isset($_COOKIE[$this->clientCookie])) {
            $this->render('loginView');
        }

        $id_user = $_COOKIE[$this->clientCookie];
        $user = $this->clientRepository->getClientById($id_user);
        $image = 'yoda.jpg';

        if ($this->isPost()) {
            $id = $this->ticketRepository->getLastTicketId() + 1;
            $ticket = new Ticket($id, date('Y-m-d'), date('Y-m-d', null), "unassigned", $_POST['contact'], $_POST['desc'], $_POST['priority'], $_POST['category'], "opened");
            $this->ticketRepository->addTicket($ticket);
            $image = 'ticketcomplete.jpg';

            return $this->render('clientView', ['messages' => ['Ticket has been submitted!'], 'user'=>$user, 'image' => $image]);
        }
        return $this->render('clientView', ['messages' => $this->message, 'user' => $user, 'image' => $image]);
    }

    public function editPriority() {
        if (!isset($_COOKIE[$this->itCookie])) {
            $this->render('itloginView');
        }

        $id_user = $_COOKIE[$this->itCookie];
        $user = $this->itguyRepository->getITguyById($id_user);

        if ($this->isPost()) {
            $ticket = $this->ticketRepository->getTicket($_POST['id']);
            $newticket = new Ticket($_POST['id'], $ticket->getOpen(), $ticket->getClose(), $ticket->getAssignee(), $ticket->getContact(),
                $ticket->getDescription(), $_POST['priority'], $ticket->getCategory(), $ticket->getStatus());
            $this->ticketRepository->updatePriority($newticket);

            $url = "http://$_SERVER[HTTP_HOST]";
            header("Location: {$url}/tickets");
        }
        $url = "http://$_SERVER[HTTP_HOST]";
        header("Location: {$url}/tickets");
    }

    public function editAssignee() {
        if (!isset($_COOKIE[$this->itCookie])) {
            $this->render('itloginView');
        }

        $id_user = $_COOKIE[$this->itCookie];
        $user = $this->itguyRepository->getITguyById($id_user);

        if ($this->isPost()) {
            $ticket = $this->ticketRepository->getTicket($_POST['id']);
            $newticket = new Ticket($_POST['id'], $ticket->getOpen(), $ticket->getClose(), $_POST['assignee'], $ticket->getContact(),
                $ticket->getDescription(), $ticket->getPriority(), $ticket->getCategory(), $ticket->getStatus());
            $this->ticketRepository->updateAssignee($newticket);

            $url = "http://$_SERVER[HTTP_HOST]";
            header("Location: {$url}/tickets");
        }
        $url = "http://$_SERVER[HTTP_HOST]";
        header("Location: {$url}/tickets");
    }

    public function editStatus() {
        if (!isset($_COOKIE[$this->itCookie])) {
            $this->render('itloginView');
        }

        $id_user = $_COOKIE[$this->itCookie];
        $user = $this->itguyRepository->getITguyById($id_user);

        if ($this->isPost()) {
            $ticket = $this->ticketRepository->getTicket($_POST['id']);
            $newticket = new Ticket($_POST['id'], $ticket->getOpen(), $ticket->getClose(), $ticket->getAssignee(), $ticket->getContact(),
                $ticket->getDescription(), $ticket->getPriority(), $ticket->getCategory(), $_POST['status']);
            $this->ticketRepository->updateStatus($newticket);

            $url = "http://$_SERVER[HTTP_HOST]";
            header("Location: {$url}/tickets");
        }
        $url = "http://$_SERVER[HTTP_HOST]";
        header("Location: {$url}/tickets");
    }

    public function search() {
        $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';

        if($contentType === "application/json") {
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);

            header('Content-type: application/json');
            http_response_code(200);

            echo json_encode($this->ticketRepository->getTicketByDesc($decoded['search']));
        }
    }

    public function filter() {
        $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';

        if($contentType === "application/json") {
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);

            header('Content-type: application/json');
            http_response_code(200);

            echo json_encode($this->ticketRepository->getTicketByStatus($decoded['status']));
        }
    }
}

