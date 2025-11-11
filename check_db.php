<?php

require_once 'vendor/autoload.php';

use Illuminate\Container\Container;
use Illuminate\Events\Dispatcher;
use Illuminate\Database\Capsule\Manager as Capsule;

// Create a service container
$container = new Container();

// Create a new app instance
$app = new Illuminate\Foundation\Application(
    $_ENV['APP_BASE_PATH'] ?? dirname(__DIR__)
);

// Bootstrap the application
$app->bootstrapWith([
    \Illuminate\Foundation\Bootstrap\LoadEnvironmentVariables::class,
    \Illuminate\Foundation\Bootstrap\LoadConfiguration::class,
    \Illuminate\Foundation\Bootstrap\HandleExceptions::class,
    \Illuminate\Foundation\Bootstrap\RegisterFacades::class,
    \Illuminate\Foundation\Bootstrap\RegisterProviders::class,
    \Illuminate\Foundation\Bootstrap\BootProviders::class,
]);

// Initialize the Capsule
$capsule = new Capsule($app);
$capsule->addConnection($app['config']['database.connections.mysql']);
$capsule->setEventDispatcher(new Dispatcher($app));
$capsule->setAsGlobal();
$capsule->bootEloquent();

try {
    // Check if categories table exists
    if (Capsule::schema()->hasTable('categories')) {
        echo "Categories table exists\n";
        
        // Check columns in categories table
        $columns = Capsule::schema()->getColumnListing('categories');
        echo "Columns in categories table:\n";
        foreach ($columns as $column) {
            echo "- " . $column . "\n";
        }
        
        // Check if image column exists
        if (in_array('image', $columns)) {
            echo "\nImage column exists in categories table\n";
        } else {
            echo "\nImage column does not exist in categories table\n";
        }
    } else {
        echo "Categories table does not exist\n";
    }
} catch (Exception $e) {
    echo "Error checking database: " . $e->getMessage() . "\n";
}