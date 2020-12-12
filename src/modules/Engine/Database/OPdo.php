<?php

namespace Engine\Database;

use PDO;

/** 
 * Inject PDO as dependacy for Models
 */
class OPdo extends PDO
{
    public function __construct(
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET,
        $username = DB_USER,
        $password = DB_PASSWORD,
        $options = []
    ) {
        $default_options = [
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        ];
        $options = array_replace($default_options, $options);
        parent::__construct($dsn, $username, $password, $options);
    }

    public function run($sql, $args = null)
    {
        if (!$args) {
            return $this->query($sql);
        }
        $stmt = $this->prepare($sql);
        $stmt->execute($args);
        return $stmt;
    }
}
