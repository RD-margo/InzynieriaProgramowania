const search = document.querySelector('input[placeholder="Search for tickets..."]');
const ticketContainer = document.querySelector(".tickets-catalog");

search.addEventListener("keyup", function(event) {
    if(event.key === "Enter") {
        event.preventDefault();

        const data = {search: this.value};

        fetch("/search", {
            method: "POST",
            headers: {
                'Content-type': 'application/json'
            },
            body: JSON.stringify(data)
        }).then(function (response) {
            return response.json();
        }).then(function (tickets) {
            ticketContainer.innerHTML = "";
            loadTickets(tickets)
        });
    }
});

function loadTickets(tickets) {
    tickets.forEach(ticket => {
        console.log(ticket);
        createTicket(ticket);
    })
}

function createTicket(ticket) {
    const template = document.querySelector("#ticket-template");

    const clone = template.content.cloneNode(true);
    const div = clone.querySelector("div");
    div.id = ticket.id;
    const contact = clone.querySelector('div[class="contact"]');
    contact.innerHTML = ticket.contact;
    const category = clone.querySelector('div[class="category"]');
    category.innerHTML = ticket.category;
    const opendate = clone.querySelector('div[class="opendate"]');
    opendate.innerHTML = ticket.opendate;
    const closedate = clone.querySelector('div[class="closedate"]');
    closedate.innerHTML = ticket.closedate;
    const priority = clone.querySelector('div[class="priority"]');
    priority.innerHTML = ticket.priority;
    const description = clone.querySelector('div[class="desc"]');
    description.innerHTML = ticket.description;
    const assignee = clone.querySelector('div[class="assignee"]');
    assignee.innerHTML = ticket.assignee;
    const status = clone.querySelector('div[class="status"]');
    status.innerHTML = ticket.status;

    ticketContainer.appendChild(clone);
}