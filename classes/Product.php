<?php
require_once "api/Transaction.php";

class Product
{
    public static function find($id)
    {
        if ($conn = Transaction::get())
        {
            $result = $conn->prepare("select * from product WHERE id= :id");
            $result->execute([':id' => $id]);

            return $result->fetch();
        }
        else
        {
            throw new Exception('Não há transação ativa!!'.__FUNCTION__);
        }
    }

    public static function delete($id)
    {
        if ($conn = Transaction::get())
        {
            $result = $conn->prepare("DELETE from product WHERE id= :id");
            $result->execute([':id' => $id]);

            return $result;
        }
        else
        {
            throw new Exception('Não há transação ativa!!'.__FUNCTION__);
        }
    }

    public static function all()
    {
        if ($conn = Transaction::get())
        {
            $result = $conn->query("select * from product ORDER BY id desc");

            return $result->fetchAll();
        }
        else
        {
            throw new Exception('Não há transação ativa!!'.__FUNCTION__);
        }
    }

    public static function lastFourWithImage()
    {
        if ($conn = Transaction::get())
        {
            $result = $conn->query("SELECT * FROM product WHERE image IS NOT NULL and image <> '' ORDER BY id DESC LIMIT 4");

            return $result->fetchAll();
        }
        else
        {
            throw new Exception('Não há transação ativa!!'.__FUNCTION__);
        }
    }

    public static function save($product)
    {
        if ($conn = Transaction::get())
        {
            $id = $product['id'] ?: null;
            $name = addslashes($product['name']);
            $code = addslashes($product['code']);
            $price = addslashes($product['price']);
            $description = addslashes($product['description']);
            $quantity = addslashes($product['quantity']);
            $image = addslashes($product['image']);

            //Não atualizar imagem se não tiver sido inserida no form
            $field_image = empty($image) ? "" : ", image"; 
            $value_image = empty($image) ? "" : ", '$image'"; 
            $update_image = empty($image) ? "" : "$field_image = '$image'";
          
            if (empty($id)) ///Insere o registro
            {
                $sql = "INSERT INTO product (name, code, price, description, quantity $field_image) 
                VALUES ('$name', '$code', $price, '$description', $quantity $value_image)";
            }
            else // Atualiza o registro
            {
                $sql = "UPDATE product SET 
                name = '$name', code = '$code', price = $price, description = '$description', quantity = $quantity $update_image     
                WHERE id = '$id'";
            }
            $conn->query($sql);
            $last_id =  empty($id) ? $conn->lastInsertId():$id;
            
            return $last_id;
        }
        else
        {
            throw new Exception('Não há transação ativa!!'.__FUNCTION__);
        }
    } 
}