<?php
//require_once 'classes/api/Transaction.php';
require_once 'classes/Category.php';

class CategoryList
{
    private $html;

    public function __construct()
    {
        $this->html = file_get_contents('assets/categories.html');
    }

    public function delete($param)
    {
        try 
        {
            Transaction::open('loja_webjump');

            $id = (int) $param['id'];
            Category::delete($id);

            Transaction::close();
        } 
        
        catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function load()
    {
        try 
        {
            Transaction::open('loja_webjump');

            $Categories = Category::all();

            $items = '';
            foreach ($Categories as $Category)
            {     
                $item = file_get_contents('assets/item_categories.html');
                $item = str_replace('{id}', $Category['id'], $item);
                $item = str_replace('{name}', $Category['name'], $item);
                $item = str_replace('{code}', $Category['code'], $item);               
            
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
