<?php

require_once 'AppController.php';
require_once __DIR__ .'/../repositories/ClientRepository.php';
require_once __DIR__ .'/../repositories/ITguyRepository.php';

class SecurityController extends AppController {
    private $messages = [];
    private $itCookie;
    private $clientCookie;
    private $clientRepository;
    private $itguyRepository;

    public function __construct() {
        parent::__construct();
        $this->itCookie = 'itguy_id_cookie';
        $this->clientCookie = 'client_id_cookie';
        $this->clientRepository = new ClientRepository();
        $this->itguyRepository = new ITguyRepository();
    }

    public function login() {
        $clientRepository = new ClientRepository();

        if(!$this->isPost()) {
            return $this->render('loginView');
        }

        $email = $_POST["email"];
        $password = $_POST["password"];

        $user = $clientRepository->getClient($email);

        if(!$user) {
            return $this->render('loginView', ['messages' => ['User doesn\'t exist!']]);
        }

        if($user->getEmail() !== $email) {
            return $this->render('loginView', ['messages' => ['User with this email doesn\'t exist!']]);
        }

       if($user->getPassword() !== $password) {
            return $this->render('loginView', ['messages' => ['Wrong password!']]);
        }

        $user_id = $this->clientRepository->getClientId($email);

        if(!isset($_COOKIE[$this->clientCookie])) {
            setcookie($this->clientCookie, $user_id, time() + (86400 * 7), "/");
        }

        return $this->render('clientView', ['image' => "yoda.jpg"]);
    }

    public function itlogin() {
        $itguyRepository = new ITguyRepository();

        if(!$this->isPost()) {
            return $this->render('itloginView');
        }

        $email = $_POST["email"];
        $password = $_POST["password"];

        $user = $itguyRepository->getITguy($email);

        if(!$user) {
            return $this->render('itloginView', ['messages' => ['User doesn\'t exist!']]);
        }

        if ($user->getEmail() !== $email) {
            return $this->render('itloginView', ['messages' => ['User with this email doesn\'t exist!']]);
        }

       if ($user->getPassword() !== $password) {
            return $this->render('itloginView', ['messages' => ['Wrong password!']]);
        }

        $user_id = $this->itguyRepository->getITguyId($email);

        if(!isset($_COOKIE[$this->itCookie])) {
            setcookie($this->itCookie, $user_id, time() + (86400 * 7), "/");
        }

        $url = "http://$_SERVER[HTTP_HOST]";
        header("Location: {$url}/tickets");
    }

    public function logout() {
        if(isset($_COOKIE['client_id_cookie'])) {
            setcookie($this->clientCookie, ' ', time() - 3600, "/");
        }

        return $this->render('loginView');
    }

    public function itlogout() {
        if(isset($_COOKIE['itguy_id_cookie'])) {
            setcookie($this->itCookie, ' ', time() - 3600, "/");
        }

        return $this->render('itloginView');
    }
}