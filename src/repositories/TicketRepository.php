<?php

date_default_timezone_set('Europe/Warsaw');

require_once 'Repository.php';
require_once __DIR__ .'/../models/Ticket.php';

class TicketRepository extends Repository {
    public function getTicket(int $id): ?Ticket {
        $stmt = $this->database->connect()->prepare('
        SELECT * FROM tickets t 
	        LEFT JOIN (ticketdetails td 
		        LEFT JOIN categories c ON td."categoriesID" = c.ID
		        LEFT JOIN statuses s ON td."statusID" = s.ID)
	        ON t.ID = td."ticketsID" WHERE t.ID = :id');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $ticket = $stmt->fetch(PDO::FETCH_ASSOC);

        if($ticket == false) {
            return null;
        }

        $closeDate = $ticket['closeDate'];
        if($closeDate == NULL) $closeDate = "-";
        $assignee = $ticket['assignee'];
        if($assignee == NULL) $assignee = "unnasigned";
        return new Ticket(
            $ticket["ticketsID"],
            $ticket['openDate'],
            $closeDate,
            $assignee,
            $ticket['contact'],
            $ticket['description'],
            $ticket['priority'],
            $ticket['category'],
            $ticket['status']
        );
    }

    public function addTicket(Ticket $ticket): void {
        $currentdate = date('m/d/Y h:i:s a', time());
        $category = $ticket->getCategory();
        $status = $ticket->getStatus();

        $stmt = $this->database->connect()->prepare('
        INSERT INTO tickets ("openDate") VALUES (:date)
        ');

        $stmt->bindParam(':date', $currentdate);
        $stmt->execute();

        $stmt = $this->database->connect()->prepare('
        INSERT INTO categories ("category") VALUES (:cat)
        ');

        $stmt->bindParam(':cat', $category, PDO::PARAM_STR);
        $stmt->execute();

        $stmt = $this->database->connect()->prepare('
        INSERT INTO statuses ("status") VALUES (:stat)
        ');

        $stmt->bindParam(':stat', $status, PDO::PARAM_STR);
        $stmt->execute();

        $stmt = $this->database->connect()->prepare('
        INSERT INTO ticketdetails ("ticketsID", "contact", "description", "priority", "categoriesID", "statusID") VALUES (?, ?, ?, ?, ?, ?)'
        );

        $stmt->execute([
            $this->getTicketId($currentdate),
            $ticket->getContact(),
            $ticket->getDescription(),
            $ticket->getPriority(),
            $this->getCategory($category),
            $this->getStatus($status)
        ]);
    }

    public function updatePriority(Ticket $ticket) {
        $id = $ticket->getID();
        $priority = $ticket->getPriority();

        $stmt = $this->database->connect()->prepare('
            UPDATE ticketdetails
            SET "priority" = :priority
            WHERE "ticketsID" = :id;
        ');

        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':priority', $priority);

        $stmt->execute();
    }

    public function updateAssignee(Ticket $ticket) {
        $id = $ticket->getID();
        $assignee = $ticket->getAssignee();

        $stmt = $this->database->connect()->prepare('
            UPDATE tickets
            SET "assignee" = :assignee
            WHERE ID = :id;
        ');

        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':assignee', $assignee);

        $stmt->execute();
    }

    public function updateStatus(Ticket $ticket) {
        $id = $ticket->getID();
        $status = $ticket->getStatus();

        $stmt = $this->database->connect()->prepare('
            SELECT * FROM ticketdetails WHERE "ticketsID" = :id;
        ');

        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        $statusID = $data["statusID"];

        $stmt = $this->database->connect()->prepare('
            UPDATE statuses
            SET "status" = :status
            WHERE ID = :id;
        ');

        $stmt->bindParam(':id', $statusID, PDO::PARAM_INT);
        $stmt->bindParam(':status', $status);

        $stmt->execute();

        if($status == "closed") {
            $currentdate = date('m/d/Y h:i:s a', time());

            $stmt = $this->database->connect()->prepare('
            UPDATE tickets
            SET "closeDate" = :date
            WHERE ID = :id;
        ');

            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->bindParam(':date', $currentdate);

            $stmt->execute();
        }

        if($status == "opened" || $status == "waiting" || $status = "") {
            $date = "-";

            $stmt = $this->database->connect()->prepare('
            UPDATE tickets
            SET "closeDate" = :date
            WHERE ID = :id;
        ');

            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->bindParam(':date', $date);

            $stmt->execute();
        }
    }

    public function getTicketId(string $date): int {
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM tickets WHERE "openDate" = :date;
        ');
        $stmt->bindParam(':date', $date, PDO::PARAM_STR);
        $stmt->execute();

        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data['id'];
    }

    public function getLastTicketId(): int {
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM tickets
            ORDER BY "openDate" DESC
            LIMIT 1;
        ');
        $stmt->execute();

        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data['id'];
    }

    public function getCategory(string $category): string {
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM categories WHERE "category" = :cat
        ');
        $stmt->bindParam(':cat', $category, PDO::PARAM_STR);
        $stmt->execute();

        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data['id'];
    }

    public function getStatus(string $status): string {
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM statuses WHERE "status" = :stat
        ');
        $stmt->bindParam(':stat', $status, PDO::PARAM_STR);
        $stmt->execute();

        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data['id'];
    }

    public function getTickets(): array {
        $result = [];

        $stmt = $this->database->connect()->prepare('
        SELECT * FROM tickets t 
	        LEFT JOIN (ticketdetails td 
		        LEFT JOIN categories c ON td."categoriesID" = c.ID
		        LEFT JOIN statuses s ON td."statusID" = s.ID)
	        ON t.ID = td."ticketsID"
	        ');

        $stmt->execute();
        $tickets = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($tickets as $ticket) {
            $closeDate = $ticket['closeDate'];
            if($closeDate == NULL) $closeDate = "-";
            $assignee = $ticket['assignee'];
            if($assignee == NULL) $assignee = "unnasigned";
            $result[] = new Ticket(
                $ticket["ticketsID"],
                $ticket['openDate'],
                $closeDate,
                $assignee,
                $ticket['contact'],
                $ticket['description'],
                $ticket['priority'],
                $ticket['category'],
                $ticket['status']
            );
        }
        return $result;
    }
    
    public function getTicketByDesc(string $searchString) {
        $searchString = '%'.strtolower($searchString).'%';

        $stmt = $this->database->connect()->prepare('
        SELECT * FROM tickets t 
	        LEFT JOIN (ticketdetails td 
		        LEFT JOIN categories c ON td."categoriesID" = c.ID
		        LEFT JOIN statuses s ON td."statusID" = s.ID)
	        ON t.ID = td."ticketsID" WHERE LOWER(description) LIKE :search');

        $stmt->bindParam(':search', $searchString, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTicketByStatus(string $statusValue) {
        if($statusValue !== "") {
            $stmt = $this->database->connect()->prepare('
            SELECT * FROM tickets t 
	        LEFT JOIN (ticketdetails td 
		        LEFT JOIN categories c ON td."categoriesID" = c.ID
		        LEFT JOIN statuses s ON td."statusID" = s.ID)
	        ON t.ID = td."ticketsID" WHERE LOWER(status) LIKE :status');

            $stmt->bindParam(':status', $statusValue, PDO::PARAM_STR);
            $stmt->execute();
        }
        else {
            $stmt = $this->database->connect()->prepare('
            SELECT * FROM tickets t 
	        LEFT JOIN (ticketdetails td 
		        LEFT JOIN categories c ON td."categoriesID" = c.ID
		        LEFT JOIN statuses s ON td."statusID" = s.ID)
	        ON t.ID = td."ticketsID"
	        ');

            $stmt->execute();
        }

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}