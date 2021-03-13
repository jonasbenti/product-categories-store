<?php
require_once "api/Transaction.php";

class Log
{
    public static function all()
    {
        if ($conn = Transaction::get())
        {
            $result = $conn->query("SELECT * FROM LOG ORDER BY created_at DESC limit 200");

            return $result->fetchAll();
        }
        else
        {
            throw new Exception('Não há transação ativa!!'.__FUNCTION__);
        }
    }

   
}