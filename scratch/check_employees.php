<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Http;

$apiUrl = env('EMPLOYEE_API_URL');
echo "API URL: $apiUrl\n";
try {
    $response = Http::get($apiUrl);
    if ($response->successful()) {
        $employees = $response->json();
        echo "Found " . count($employees) . " employees.\n";
        echo "First employee: " . json_encode($employees[0], JSON_PRETTY_PRINT) . "\n";
    } else {
        echo "Failed to fetch. Status: " . $response->status() . "\n";
    }
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
