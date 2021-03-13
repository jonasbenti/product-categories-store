<?php
require_once 'classes/Product.php';

class Dashboard
{
    private $html;

    public function __construct()
    {
        $this->html = file_get_contents('assets/dashboard.html');
    }

    public function load()
    {
        try 
        {
            Transaction::open('loja_webjump');
            $Products = Product::lastFourWithImage();

            $items = '';
            foreach ($Products as $Product)
            {
                $item = file_get_contents('assets/item_dashboard.html');
                $item = str_replace('{id}', $Product['id'], $item);
                $item = str_replace('{name}', $Product['code']." - ".$Product['name'], $item);
                $item = str_replace('{price}', str_replace('.', ',', $Product['price']), $item);          
                $item = str_replace('{quantity}', $Product['quantity'], $item);             
                $item = str_replace('{image}', $Product['image'], $item);               
            
                $items .= $item;
            }
            $this->html = str_replace('{quantity_items}', count($Products), $this->html);
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
