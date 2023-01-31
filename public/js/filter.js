document.getElementById("submit").addEventListener("click", function () {
    const status = document.querySelector('select[name="status"]').value;

    const data = {status: status};

    fetch("/filter", {
        method: "POST",
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    }).then(function (response) {
        return response.json();
    }).then(function (tickets) {
        ticketContainer.innerHTML = "";
        loadTickets(tickets)
    });
});