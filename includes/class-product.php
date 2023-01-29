<?php

class Product
{
    /**
     * Retrieve all users from database
     */
    public static function getAllProducts()
    {
        return DB::Connect()->select(
            'SELECT * FROM products ORDER BY id DESC',
            [],
            true
        );
    }

    /**
     * Retrieve product data by id
     */
    public static function getProductById($product_id)
    {
        return DB::connect()->select(
            'SELECT * FROM products WHERE id = :id',
            [
                'id' => $product_id
            ]
        );
    }

    /**
     * Retrieve all the publish products
     */
    public static function getPublishProducts()
    {
        return DB::connect()->select(
            'SELECT * FROM products WHERE status = :status ORDER BY id DESC',
            [
                'status' => 'publish'
            ],
            true
        );
    }

    public static function add( $name, $price, $image_url )
    {
        return DB::connect()->insert(
            'INSERT INTO products ( name, price, image_url )
            VALUES ( :name, :price, :image_url )',
            [
            'name' => $name,
            'price' => $price,
            'image_url' => $image_url
            ]
        );
    }

    public static function update( $id, $name, $price, $status, $image_url)
    {
        // setup params
        $params = [
            'id' => $id,
            'name' => $name,
            'price' => $price,
            'status' => $status,
            'image_url' => $image_url

        ];


        // update product data into the database
        return DB::connect()->update(
            'UPDATE products SET name = :name, price = :price, status = :status, image_url = :image_url WHERE id = :id',
            $params
        );

    }

    public static function delete ( $product_id )
    {
        return DB::connect()->delete(
            'DELETE FROM products where id = :id',
            [
                'id' => $product_id
            ]
        );
    }
}