<?php

require_once 'Repository.php';
require_once __DIR__ .'/../models/Client.php';

class ClientRepository extends Repository {
    public function getClient(string $email): ?Client {
        $stmt = $this->database->connect()->prepare('
        SELECT * FROM clients WHERE email = :email');
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if(!$user) {
            return null;
        }

        return new Client(
            $user['email'],
            $user['password']
        );
    }

    public function getClientById(int $id): ?Client {
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM clients WHERE ID = :id
        ');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            return null;
        }

        return new Client(
            $user['email'],
            $user['password']
        );
    }

    public function getClientId(string $email) {
        $stmt = $this->database->connect()->prepare('
            SELECT ID FROM clients WHERE email = :email
        ');
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_COLUMN);
    }
}