<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class CloneDb extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:clonedb';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Will clone the database to the fallback panel database.';

    /**
     * Execute the console command.
     */
    public function handle() {

        // Log the start of the process to the laravel log
        Log::info('Starting the database clone process.');

        // Export the current database
        $dbHost = config('database.connections.mysql.host');
        $dbName = config('database.connections.mysql.database');
        $dbUser = config('database.connections.migrate.username');
        $dbPass = config('database.connections.migrate.password');

        $backupPath = storage_path('app/backup.sql');

        $command = "mysqldump -h$dbHost -u$dbUser -p'$dbPass' $dbName > $backupPath";

        try {
            $command = "mysqldump -h$dbHost -u$dbUser -p'$dbPass' $dbName > $backupPath";

            $this->info('Exporting database...');
            exec($command, $output, $resultCode);

            if ($resultCode === 0) {
                $this->info("Database exported successfully to: $backupPath");
            } else {
                $this->error('Database export failed.');
                Log::error('Database export failed.');
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
            Log::error('Database export failed.');
        }

        // Import the current database into the fallback database

        $cloneDbHost = env('FB_DB_HOST');
        $cloneDbName = env('FB_DB_DATABASE');
        $cloneDbUser = env('FB_DB_USERNAME');
        $cloneDbPass = env('FB_DB_PASSWORD');

        $command = "mysql -h$cloneDbHost -u$cloneDbUser -p'$cloneDbPass' $cloneDbName < $backupPath";

        try {
            $this->info('Importing database...');
            exec($command, $output, $resultCode);

            if ($resultCode === 0) {
                $this->info("Database imported successfully to: $cloneDbName");
                Log::info('Database imported successfully. Clone complete.');
            } else {
                $this->error('Database import failed.');
                Log::error('Database import failed.');
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
            Log::error('Database import failed.');
        }

    }
}
