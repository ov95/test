# Test

## Info

    Linux 5.4.80-2-MANJARO x86_64 GNU/Linux
    Apache/2.4.46 (Unix) PHP/7.4.13
    mysql  Ver 15.1 Distrib 10.5.8-MariaDB, for Linux (x86_64)
    PHP version: 7.4.13

## Project Setup

1) Set up the database credentials in `config/config.php`

2) In `public/index.php` uncomment line 22 and 23 to generate all required tables automaticaly. Run code once and then comment them back (project will work anyway if you do not).
```
// $tableBuilder = new \Engine\Database\TableBuilder(new OPdo());
// $tableBuilder->createTables();
```

Thats it.
