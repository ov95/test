<?php

namespace Models;

use Engine\Database\OPdo;


/**
 * Product Model
 */
class Product
{
    /* @var OPdo */
    protected $db;

    public function __construct()
    {
        $this->db = new OPdo;
    }

    // Function is used in development to seed products table
    public function create()
    {
        try {
            $faker = \Faker\Factory::create();
            $image = 'public/images/plains.jpg';

            $stmt = 'INSERT INTO products(title, image, description) VALUES(:title, :image, :description)';
            $stmt = $this->db->prepare($stmt);
            $stmt->bindParam(':title', $faker->name);
            $stmt->bindParam(':image', $image);
            $stmt->bindParam(':description', $faker->text);

            $stmt->execute();
        } catch (\Throwable $th) {
            echo $th->getMessage() . 'AKSJD';
        }
    }

    public function getAll()
    {
        $stmt = $this->db->prepare('SELECT * FROM products');
        $stmt->execute();
        return $stmt->fetchAll(OPdo::FETCH_OBJ);
    }
}
