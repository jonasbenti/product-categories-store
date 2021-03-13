<?php
require_once 'classes/Log.php';

class LogList
{
    private $html;

    public function __construct()
    {
        $this->html = file_get_contents('assets/logs.html');
    }
   
    public function load()
    {
        try 
        {
            Transaction::open('loja_webjump');

            $Logs = Log::all();

            $items = '';
            foreach ($Logs AS $Log)
            {     
                $date = date_create($Log['created_at']);
                $date_format = date_format($date, 'd/m/Y H:i:s');
                $item = file_get_contents('assets/item_logs.html');
                $item = str_replace('{id}', $Log['id'], $item);
                $item = str_replace('{item}', $Log['type']." ".$Log['row_id'], $item);
                $item = str_replace('{action}', $Log['action'], $item);               
                $item = str_replace('{description}', $Log['description'], $item);               
                $item = str_replace('{date_time}', $date_format, $item);                        
            
                $items .= $item;
            }
            $this->html = str_replace('{items}', $items, $this->html);

            Transaction::close();
        } 
        catch (Exception $e) 
        {
            echo $e->getMessage();
        }
    }

    public function show()
    {
        $this->load();
        echo $this->html;
    }
}
