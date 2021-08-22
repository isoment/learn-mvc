<?php
declare(strict_types=1);

namespace app\core;

use PDO;

class Database
{
    public PDO $pdo;

    public function __construct(array $config)
    {   
        $dsn = $config['dsn'] ?? '';
        $user = $config['user'] ?? '';
        $password = $config['password'] ?? '';

        $this->pdo = new PDO($dsn, $user, $password);

        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    /**
     *  Apply the migrations
     */
    public function applyMigrations()
    {
        $this->createMigrationsTable();

        $appliedMigrations = $this->getAppliedMigrations();

        // Get a list of all the migration files
        $files = scandir(Application::$ROOT_DIR . '/migrations');

        $newMigrations = [];

        // Migrations that have not been applied
        $toApplyMigrations = array_diff($files, $appliedMigrations);

        foreach ($toApplyMigrations as $migration) {
            if ($migration === '.' || $migration === '..') {
                continue;
            }

            require_once Application::$ROOT_DIR . '/migrations/' . $migration;

            $className = pathinfo($migration, PATHINFO_FILENAME);

            $instance = new $className();

            $this->log("Applying migration $migration...");

            $instance->up();

            $this->log("Migration $migration applied successfully");

            $newMigrations[] = $migration;
        }

        if (!empty($newMigrations)) {
            $this->saveMigrations($newMigrations);
        } else {
            $this->log("All migrations are applied");
        }
    }

    /**
     *  Create migrations table if it doesn't exist
     *  where we can keep track of migrations
     */
    public function createMigrationsTable() : void
    {
        $this->pdo->exec("CREATE TABLE IF NOT EXISTS migrations (
                id INT AUTO_INCREMENT PRIMARY KEY,
                migration VARCHAR(255),
                create_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP) ENGINE=INNODB;");
    }

    /**
     *  Get all the migrations that have been applied
     * 
     *  @return array
     */
    public function getAppliedMigrations() : array
    {
        $statement = $this->pdo->prepare("SELECT migration FROM migrations");

        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_COLUMN);
    }

    /**
     *  Save the migrations
     * 
     *  @param array $migrations
     */
    public function saveMigrations(array $migrations)
    {
        // Map over the migrations param and format it for mysql insert
        // then join the array elements with a seperated by ","
        $str = implode(",", array_map(fn($m) => "('$m')", $migrations)) ;

        $statement = $this->pdo->prepare("INSERT INTO migrations (migration) VALUES $str");

        $statement->execute();
    }

    /**
     *  Log output to console
     * 
     *  @param string $message
     */
    protected function log(string $message)
    {
        echo '[' . date('Y-m-d H:i:s') . '] - ' . $message . PHP_EOL;
    }
}