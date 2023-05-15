<?php

include __DIR__ . '/vendor/autoload.php';

include_once __DIR__ . './DBController.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$connection = new DBController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $seanses = $connection->query(
        'select * from seanse where start > :start_date and stop < :end_date',
        [
            'start_date' => $_POST['start_date'],
            'end_date' => $_POST['end_date'],
        ]
    );

    if (!empty($seanses)) {
        echo "<table>";
        echo "<tr><th>Seanse ID</th><th>Client ID</th><th>Start</th><th>Stop</th><th>IN</th><th>OUT</th></tr>";
        foreach ($seanses as $seanse) {
            echo "<tr>";

            echo "<td>" . $seanse['id'] . "</td>";
            echo "<td>" . $seanse['client_id'] . "</td>";
            echo "<td>" . $seanse['start'] . "</td>";
            echo "<td>" . $seanse['stop'] . "</td>";
            echo "<td>" . $seanse['in_traffic'] . "</td>";
            echo "<td>" . $seanse['out_traffic'] . "</td>";

            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo 'No sessions found for Client: ' . $selectedClient['name'];
    }
}
?>

<style>
    table {
        width: 100%;
        border-collapse: collapse;
    }

    table th, table td {
        padding: 8px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    table th {
        background-color: #f2f2f2;
    }

    table tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    table tr:hover {
        background-color: #f5f5f5;
    }
</style>

<form method="POST" action="">
    <label for="start_date">Start Date:</label>
    <input type="datetime-local" id="start_date" name="start_date" required>
    <br>
    <label for="end_date">End Date:</label>
    <input type="datetime-local" id="end_date" name="end_date" required>
    <br>
    <button type="submit">Get Sessions</button>
</form>