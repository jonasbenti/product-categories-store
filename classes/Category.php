<?php
require_once "api/Transaction.php";

class Category
{
    public static function find($id)
    {
        if ($conn = Transaction::get())
        {            
            $result = $conn->prepare("select * from category WHERE id= :id");
            $result->execute([':id' => $id]);
            return $result->fetch();
            
        $conn = null;
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
            $result = $conn->prepare("DELETE from category WHERE id= :id");
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
            $result = $conn->query("select * from category ORDER BY id desc");

            return $result->fetchAll();
        }
        else
        {
            throw new Exception('Não há transação ativa!!'.__FUNCTION__);
        }
    }

    public static function save($category)
    {
        if ($conn = Transaction::get())
        {
            $id = addslashes($category['id']);
            $name = addslashes($category['name']);
            $code = addslashes($category['code']);
           
            if (empty($id)) ///Insere o registro
            {
                $sql = "INSERT INTO category (name, code) 
                VALUES ('$name', '$code')";
            }
            else // Atualiza o registro
            {
                $sql = "UPDATE category SET name = '$name', code = '$code'           
                WHERE id = '$id'";
            }

            return $conn->query($sql);
        }
        else
        {
            throw new Exception('Não há transação ativa!!'.__FUNCTION__);
        }
    }    
}