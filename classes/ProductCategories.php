<?php
require_once "api/Transaction.php";
class ProductCategories
{
    public static function find($product_id)
    {
        if ($conn = Transaction::get())
        {
            $result = $conn->prepare("select * from product_categories WHERE product_id = :product_id");
            $result->execute([':product_id' => $product_id]);
            
            return $result->fetchAll();  
        }
        else
        {
            throw new Exception('Não há transação ativa!!'.__FUNCTION__);
        }
    }

    public static function delete($product_id)
    {
        if ($conn = Transaction::get())
        {
            $result = $conn->prepare("DELETE from product_categories WHERE product_id= :product_id");
            $result->execute([':product_id' => $product_id]);

            return $result;        
        }
        else
        {
            throw new Exception('Não há transação ativa!!'.__FUNCTION__);
        }
    }

    public static function save($category_id, $product_id)
    {
        if ($conn = Transaction::get())
        {
            $sql = "INSERT INTO product_categories (category_id, product_id) 
            VALUES ($category_id, $product_id)";
 
            return $conn->query($sql);
        }
        else
        {
            throw new Exception('Não há transação ativa!!'.__FUNCTION__);
        }
    }    

}