<?php

namespace Dao\Products;

use Dao\Table;

class Products extends Table
{
    public static function getProducts($name = "", $status = "", $ordBy = "productName", $ordDesc = false, $page = 0, $items = 10)
    {
        $sql = "SELECT productId, productName, productDescription, productPrice, productImgUrl, productStatus
              FROM products
             WHERE 1=1";
        $params = [];
        if ($name !== "") {
            $sql .= " AND productName LIKE :name";
            $params["name"] = "%" . $name . "%";
        }
        if ($status !== "") {
            $sql .= " AND productStatus = :status";
            $params["status"] = $status;
        }
        $ordBy = in_array($ordBy, ["productName", "productPrice"]) ? $ordBy : "productName";
        $sql .= " ORDER BY {$ordBy} " . ($ordDesc ? "DESC" : "ASC");
        $sql .= " LIMIT :ofs, :lim";
        $params["ofs"] = $page * $items;
        $params["lim"] = $items;
        return self::obtenerRegistros($sql, $params);
    }

    public static function getProductById(int $id)
    {
        $sql = "SELECT productId, productName, productDescription, productPrice, productImgUrl, productStatus
              FROM products
             WHERE productId = :id";
        return self::obtenerUnRegistro($sql, ["id" => $id]);
    }

    public static function insertProduct($name, $desc, $price, $img, $status)
    {
        $sql = "INSERT INTO products (productName, productDescription, productPrice, productImgUrl, productStatus)
            VALUES (:name, :desc, :price, :img, :status)";
        return self::executeNonQuery($sql, [
            "name" => $name,
            "desc" => $desc,
            "price" => $price,
            "img" => $img,
            "status" => $status
        ]);
    }

    public static function updateProduct($id, $name, $desc, $price, $img, $status)
    {
        $sql = "UPDATE products
               SET productName=:name,
                   productDescription=:desc,
                   productPrice=:price,
                   productImgUrl=:img,
                   productStatus=:status
             WHERE productId=:id";
        return self::executeNonQuery($sql, [
            "id" => $id,
            "name" => $name,
            "desc" => $desc,
            "price" => $price,
            "img" => $img,
            "status" => $status
        ]);
    }

    public static function deleteProduct($id)
    {
        $sql = "DELETE FROM products WHERE productId=:id";
        return self::executeNonQuery($sql, ["id" => $id]);
    }
}
