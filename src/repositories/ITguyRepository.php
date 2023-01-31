<?php

require_once 'Repository.php';
require_once __DIR__ .'/../models/ITguy.php';

class ITguyRepository extends Repository {
    public function getITguy(string $email): ?ITguy {
        $stmt = $this->database->connect()->prepare('
        SELECT * FROM supportteam WHERE email = :email');
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if(!$user) {
            return null;
        }

        return new ITguy(
            $user['email'],
            $user['password']
        );
    }

    public function getITguyById(int $id): ?ITguy {
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM supportteam WHERE ID = :id
        ');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            return null;
        }

        return new ITguy(
            $user['email'],
            $user['password']
        );
    }

    public function getITguyId(string $email) {
        $stmt = $this->database->connect()->prepare('
            SELECT ID FROM supportteam WHERE email = :email
        ');
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_COLUMN);
    }
}