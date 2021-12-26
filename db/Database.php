<?php


namespace jddev2381\phpmvc\db;



use jddev2381\phpmvc\Application;

/**
 * Class Database
 * 
 * @author JD Simpkins <jd@huntingtonwebsolutions.com>
 * @package jddev2381\phpmvc
 */


 class Database {

    public \PDO $pdo;

    public function __construct(array $config) {
        $dsn        = $config['dsn'] ?? '';
        $user       = $config['user'] ?? '';
        $password   = $config['password'] ?? '';
        
        $this->pdo  = new \PDO($dsn, $user, $password);

        $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    public function applyMigrations() {
        $this->createMigrationsTable();
        $appliedMigrations = $this->getAppliedMigrations();

        $newMigrations = [];
        $files = scandir(Application::$ROOT_DIR.'/migrations');
        $migrationsToApply = array_diff($files, $appliedMigrations);
        
        foreach($migrationsToApply as $migration) {
            if($migration === '.' || $migration === '..') {
                continue;
            }

            require_once Application::$ROOT_DIR . '/migrations/' . $migration;
            $className = pathinfo($migration, PATHINFO_FILENAME);
            $instance = new $className();
            $this->log("Applying the \"$className\" migration.");
            $instance->up();
            $this->log("The \"$className\" migration has been applied!", true);
            $newMigrations[] = $migration;
        }

        if(!empty($newMigrations)) {
            $this->saveMigrations($newMigrations);
        } else {
            $this->log("Your migrations are already up to date!");
        }
    }

    public function createMigrationsTable() {
        $this->pdo->exec("CREATE TABLE IF NOT EXISTS migrations(
            id INT AUTO_INCREMENT PRIMARY KEY,
            migration VARCHAR(255),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=INNODB;");
    }

    public function getAppliedMigrations() {
        $statement = $this->pdo->prepare("SELECT migration FROM migrations");
        $statement->execute();

        return $statement->fetchAll(\PDO::FETCH_COLUMN);
    }

    public function saveMigrations(array $migrations) {
        $migrationsString = implode(",", array_map(fn($m) => "('$m')", $migrations));
        $statement = $this->pdo->prepare("INSERT INTO migrations (migration) VALUES 
            $migrationsString
        ");
        $statement->execute();
    }

    public function prepare($sql) {
        $this->pdo->prepare($sql);
    }

    protected function log($msg, $doubleSpace = null) {
        echo '['.date('F jS, Y H:i:s') . '] - ' . $msg . PHP_EOL;
        if($doubleSpace) {
            echo PHP_EOL;
        }
    }

 }