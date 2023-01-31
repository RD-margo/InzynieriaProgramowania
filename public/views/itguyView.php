<!DOCTYPE html>
<head>
    <link rel="stylesheet" type="text/css" href="public/css/style.css">
    <script type="text/javascript" src="./public/js/search.js" defer></script>
    <script type="text/javascript" src="./public/js/filter.js" defer></script>
    <title>TICKETS</title>
</head>
<body>
    <div class="container">
        <div class="ticket-container">
            <h2 style="font-size: 7vh;">TICKETS
            <img src="public/img/itguy.png" style="height: 8vh; margin-left: 20px; border-radius: 5px;"></h2>
            <div class="search-bar">
                <input type="search" placeholder="Search for tickets...">
                <form class="filter-bar">
                    <div class="status">status: 
                        <select name="status" id="status" style="width: 9vw;">
                            <option value="">select status</option>
                            <option value="opened">opened</option>
                            <option value="waiting">waiting</option>
                            <option value="closed">closed</option>
                        </select>
                    </div>
                    <input id="submit" type="button" value="FILTER" style="width: 100px; height: fit-content; margin: 0; margin-left: 10px; background-color: #000000B3; color: #FFFFFF;font-size: 2vh;">
                </form>
            </div>
            <section class="tickets-catalog">
                <?php foreach ($tickets as $ticket): ?>
                <div class="ticket" id="ticket">
                    <div class="ticket-details">
                        <div class="item"><b>contact:&nbsp</b><div class="contact"> <?= $ticket->getContact() ?></div></div>
                        <div class="item"><b>category:&nbsp</b><div class="category"> <?= $ticket->getCategory() ?></div></div>
                        <div class="item"><b>opened:&nbsp</b><div class="opendate"> <?= $ticket->getOpen() ?></div></div>
                        <div class="item"><b>closed:&nbsp</b><div class="closedate"> <?= $ticket->getClose() ?></div></div>
                        <div class="item"><b>priority:&nbsp</b><div class="priority"> <?= $ticket->getPriority() ?></div></div>
                        <div class="ticket-form">
                            <form action="editPriority" method="POST">
                                <input name="id" value="<?= $ticket->getID() ?>" style="display: none">
                                <select name="priority" style="width: 9vw;">
                                    <option value="">select priority</option>
                                    <option value="low">low</option>
                                    <option value="medium">medium</option>
                                    <option value="high">high</option>
                                </select>
                                <button id="priority" type="submit" style="width: 50px; height: fit-content; font-size: 2vh;">SET</button>
                            </form>
                        </div>
                    </div>
                    <div class="ticket-desc">
                        <div class="ditem"><b>Description:&nbsp</b><div class="desc"> <?= $ticket->getDescription() ?></div></div>
                    </div>
                    <div class="ticket-status">
                        <div class="item"><b>assigned to:&nbsp</b><div class="assignee"> <?= $ticket->getAssignee() ?></div></div>
                        <div class="ticket-form">
                            <form action="editAssignee" method="POST">
                                <input name="id" value="<?= $ticket->getID() ?>" style="display: none">
                                <input name="assignee" type="text" placeholder="set assignee" style="width: 9vw; margin: 0">
                                <button type="submit" style="width: 50px; height: fit-content; font-size: 2vh;">SET</button>
                            </form>
                        </div>
                        <div class="item"><b>status:&nbsp</b><div class="status"> <?= $ticket->getStatus() ?></div></div>
                        <div class="ticket-form">
                            <form action="editStatus" method="POST">
                                <input name="id" value="<?= $ticket->getID() ?>" style="display: none">
                                <select name="status" id="status" style="width: 9vw;">
                                    <option value="">select status</option>
                                    <option value="opened">opened</option>
                                    <option value="waiting">waiting</option>
                                    <option value="closed">closed</option>
                                </select>
                                <button type="submit" style="width: 50px; height: fit-content; font-size: 2vh;">SET</button>
                            </form>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
                <a href="/itlogout" style="position: absolute; bottom: 0;"><button class="logout-button">LOG OUT</button></a>
            </div>
        </div>
    </div>
</body>

<template id="ticket-template">
    <div class="ticket" id="ticket">
        <div class="ticket-details">
            <div class="item"><b>contact:&nbsp</b><div class="contact"></div></div>
            <div class="item"><b>category:&nbsp</b><div class="category"></div></div>
            <div class="item"><b>opened:&nbsp</b><div class="opendate"></div></div>
            <div class="item"><b>closed:&nbsp</b><div class="closedate"></div></div>
            <div class="item"><b>priority:&nbsp</b><div class="priority"></div></div>
            <div class="ticket-form">
                <form action="editPriority" method="POST">
                    <input name="id" style="display: none">
                    <select name="priority" style="width: 9vw;">
                        <option value="">select priority</option>
                        <option value="low">low</option>
                        <option value="medium">medium</option>
                        <option value="high">high</option>
                    </select>
                    <button id="priority" type="submit" style="width: 50px; height: fit-content; font-size: 2vh;">SET</button>
                </form>
            </div>
        </div>
        <div class="ticket-desc">
            <div class="ditem"><b>Description:&nbsp</b><div class="desc"></div></div>
        </div>
        <div class="ticket-status">
            <div class="item"><b>assigned to:&nbsp</b><div class="assignee"></div></div>
            <div class="ticket-form">
                <form action="editAssignee" method="POST">
                    <input name="id" style="display: none">
                    <input name="assignee" type="text" placeholder="set assignee" style="width: 9vw; margin: 0">
                    <button type="submit" style="width: 50px; height: fit-content; font-size: 2vh;">SET</button>
                </form>
            </div>
            <div class="item"><b>status:&nbsp</b><div class="status"></div></div>
            <div class="ticket-form">
                <form action="editStatus" method="POST">
                    <input name="id" style="display: none">
                    <select name="status" id="status" style="width: 9vw;">
                        <option value="">select status</option>
                        <option value="opened">opened</option>
                        <option value="waiting">waiting</option>
                        <option value="closed">closed</option>
                    </select>
                    <button type="submit" style="width: 50px; height: fit-content; font-size: 2vh;">SET</button>
                </form>
            </div>
        </div>
    </div>
</template>