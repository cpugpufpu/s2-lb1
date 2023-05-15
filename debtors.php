<?php

include __DIR__ . '/vendor/autoload.php';

include_once __DIR__ . './DBController.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$connection = new DBController();

$debtors = $connection->query('select name, balance from client where balance < 0');

if (!empty($debtors)) {
    echo "<h2>Debtors:</h2>";
    echo "<ul>";

    foreach ($debtors as $debtor) {
        echo "<li>" . $debtor['name'] . " : " . $debtor['balance'] . "</li>";
    }

    echo "</ul>";
} else {
    echo "There is no any debtor :)";
}
