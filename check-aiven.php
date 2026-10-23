
<?php

$ca = getenv('MYSQL_ATTR_SSL_CA');

echo "=== SafeSpace Aiven SSL Check ===\n";
echo "CA path configured: " . ($ca ?: 'NO') . "\n";
echo "CA file readable: " .
    (($ca && is_readable($ca)) ? 'YES' : 'NO') . "\n";
echo "pdo_mysql enabled: " .
    (extension_loaded('pdo_mysql') ? 'YES' : 'NO') . "\n";
echo "SSL CA option available: " .
    (defined('PDO::MYSQL_ATTR_SSL_CA') ? 'YES' : 'NO') . "\n";

try {
    if (!$ca || !is_readable($ca)) {
        throw new RuntimeException(
            'CA certificate is missing or unreadable.'
        );
    }

    $host = getenv('DB_HOST');
    $port = getenv('DB_PORT') ?: '3306';
    $database = getenv('DB_DATABASE');
    $username = getenv('DB_USERNAME');
    $password = getenv('DB_PASSWORD');

    $pdo = new PDO(
        "mysql:host={$host};port={$port};dbname={$database};charset=utf8mb4",
        $username,
        $password,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::MYSQL_ATTR_SSL_CA => $ca,
            PDO::ATTR_TIMEOUT => 10,
        ]
    );

    $pdo->query('SELECT 1');
    echo "Aiven connection test: PASSED\n";
} catch (Throwable $e) {
    echo "Aiven connection test: FAILED\n";
    echo "Error: " . $e->getMessage() . "\n";
}
