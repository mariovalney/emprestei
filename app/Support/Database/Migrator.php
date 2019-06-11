<?php

namespace App\Support\Database;

use App\Support\Facades\Database;

class Migrator
{
    /**
     * The dir for migrations
     */
    const DIRECTORY = 'database';

    /**
     * Timestamp from last migration
     *
     * @var integer
     */
    private $migration = 0;

    /**
     * Migration files
     * @var array
     */
    private $migrations = [];

    /**
     * The constructor
     */
    public function __construct()
    {
        if (! DEBUG) {
            return;
        }

        $this->migration = $this->getMigrationStatus();
        $this->migrations = $this->getMigrations();
    }

    /**
     * Run migrations
     *
     * @return void
     */
    public function run()
    {
        $now = date('U');

        foreach ($this->migrations as $time => $file) {
            if ($time > $now || $time <= $this->migration) {
                continue;
            }

            require_once($file);

            $this->setMigrationStatus($time);
        }
    }

    /**
     * Find the .migration file with the
     *
     * @return int
     */
    private function getMigrationStatus()
    {
        $file = ROOT . DS . self::DIRECTORY . DS . '.migration';

        if (! file_exists($file)) {
            return 0;
        }

        $migration = file_get_contents($file);

        return intval($migration);
    }

    /**
     * Set migration
     *
     * @return array
     */
    private function setMigrationStatus($time)
    {
        $file = ROOT . DS . self::DIRECTORY . DS . '.migration';

        file_put_contents($file, $time);
    }

    /**
     * Find the files and prepare data
     *
     * @return array
     */
    private function getMigrations()
    {
        $migrations = [];

        foreach (scandir(ROOT . self::DIRECTORY . DS) as $file) {
            if (strpos($file, '.') === 0) {
                continue;
            }

            $data = explode('_', $file);

            if (strlen($data[0]) !== 12) {
                continue;
            }

            $migrations[ strtotime($data[0]) ] = ROOT . self::DIRECTORY . DS . $file;
        }

        return $migrations;
    }
}
