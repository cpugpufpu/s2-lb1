<?php

include __DIR__ . '/vendor/autoload.php';

include_once __DIR__ . './DBController.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$connection = new DBController();

$clients = $connection->query('select id, name from client');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $selectedClient = null;

    foreach ($clients as $client) {
        if ($_POST['client'] === $client['id']) {
            $selectedClient = $client;

            break;
        }
    }

    if (null === $selectedClient) {
        throw new Exception('There is not such a client');
    }

    $seanses = $connection->query(
        'select * from seanse where client_id=:client_id',
        [
            'client_id' => $selectedClient['id'],
        ],
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
    <label for="client">Select a client:</label>
    <select name="client" id="client">
        <?php foreach ($clients as $client) { ?>
            <option value="<?php echo $client['id']; ?>"><?php echo $client['name']; ?></option>
        <?php } ?>
    </select>
    <br>
    <button type="submit">Get seanses</button>
</form>
