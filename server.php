<?php
/*
 * Custom server script to avoid Laravel's ServeCommand bug on Windows
 */

// Set the document root to the public directory
$documentRoot = __DIR__ . '/public';
$host = '127.0.0.1';
$port = 8000;

// Check if port is available
$connection = @fsockopen($host, $port);
if (is_resource($connection)) {
    fclose($connection);
    echo "Port {$port} is already in use. Try a different port.\n";
    exit(1);
}

// Start the server
$command = sprintf(
    'php -S %s:%d -t %s %s',
    $host,
    $port,
    escapeshellarg($documentRoot),
    escapeshellarg($documentRoot . '/index.php')
);

echo "Starting Laravel development server...\n";
echo "Server running on http://{$host}:{$port}\n";
echo "Press Ctrl+C to stop the server\n\n";

// Execute the command
passthru($command);