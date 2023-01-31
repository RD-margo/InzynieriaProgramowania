<?

date_default_timezone_set('Poland/Warsaw');

class Ticket {
    private $id;
    private $open_date;
    private $close_date;
    private $assignee;
    private $contact;
    private $description;
    private $priority;
    private $category;
    private $status;

    public function __construct(int $id, string $open_date, string $close_date, string $assignee, string $contact, string $description, string $priority, string $category, string $status) {
        $this->id = $id;
        $this->open_date = $open_date;
        $this->close_date = $close_date;
        $this->assignee = $assignee;
        $this->contact = $contact;
        $this->description = $description;
        $this->priority = $priority;
        $this->category = $category;
        $this->status = $status;
    }

    public function getID() : int {
        return $this->id;
    }

    public function setID(int $id) : void {
        $this->id = $id;
    }

    public function getOpen() : string {
        return $this->open_date;
    }

    public function setOpen(string $open_date) : void {
        $this->open_date = $open_date;
    }

    public function getClose() : string {
        return $this->close_date;
    }

    public function setClose(string $close_date) : void {
        
    }

    public function getAssignee() : string {
        return $this->assignee;
    }

    public function setAssignee(string $assignee) : void {
        $this->assignee = $assignee;
    }

    public function getContact() : string {
        return $this->contact;
    }

    public function setContact(string $contact) : void {
        $this->contact = $contact;
    }

    public function getDescription() : string {
        return $this->description;
    }

    public function setDescription(string $description) : void {
        $this->description = $description;
    }

    public function getPriority() : string {
        return $this->priority;
    }

    public function setPriority(string $priority) : void {
        $this->priority - $priority;
    }

    public function getCategory() : string {
        return $this->category;
    }

    public function setCategory(string $category) : void {
        $this->category = $category;
    }

    public function getStatus() : string {
        return $this->status;
    }

    public function setStatus(string $status) : void {
        $this->status = $status;
    }
}