<?php

namespace Engine\Database;

use Engine\Database\OPdo;


/**
 * Use TableBuilder to automate creating tables in DB
 */
class TableBuilder
{
  /* @var OPdo */
  protected $db;

  public function __construct(OPdo $db)
  {
    $this->db = $db;
  }

  public function createTables()
  {
    $this->data = $this->db->exec("
        CREATE TABLE IF NOT EXISTS `products` (
            `id` int(11) NOT NULL,
            `title` varchar(30) CHARACTER SET utf8mb4 NOT NULL,
            `image` varchar(50) CHARACTER SET utf8mb4 NOT NULL,
            `description` text CHARACTER SET utf8mb4 NOT NULL
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
          --
          -- Indexes for table `products`
          --
          ALTER TABLE `products`
            ADD PRIMARY KEY (`id`);
          --
          -- AUTO_INCREMENT for table `products`
          --
          ALTER TABLE `products`
            MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
          COMMIT;

        --
        -- Comments table creation
        --
        CREATE TABLE IF NOT EXISTS `comments` (
            `id` int(11) NOT NULL,
            `name` varchar(70) CHARACTER SET utf8mb4 NOT NULL,
            `email` varchar(35) CHARACTER SET utf8mb4 NOT NULL,
            `text` text CHARACTER SET utf8mb4 NOT NULL,
            `approved` tinyint(4) NOT NULL DEFAULT 0 COMMENT '1 - true | 0 - false'
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
          --
          -- Indexes for table `comments`
          --
          ALTER TABLE `comments`
            ADD PRIMARY KEY (`id`);
          --
          -- AUTO_INCREMENT for table `comments`
          --
          ALTER TABLE `comments`
            MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
          COMMIT;
        ");
  }
}
