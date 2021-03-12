<?php
require_once 'classes/Product.php';
require_once 'classes/ProductCategories.php';
require_once 'classes/Category.php';

class ProductList
{
    private $html;

    public function __construct()
    {
        $this->html = file_get_contents('assets/products.html');
    }

    public function delete($param)
    {
        try 
        {
            Transaction::open('loja_webjump');

            $id = (int) $param['id'];
            Product::delete($id);

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
            $Products = Product::all();

            $items = '';
            foreach ($Products as $Product)
            {
                //busca as categorias do produto
                $Categories = ProductCategories::find($Product['id']);
                $product_categories = [];
                foreach ($Categories as $Category) {
                    $product_category = Category::find($Category['category_id']);
                    $product_categories[] = "[{$product_category['code']}] - {$product_category['name']}";
                }
                $text_categories = implode(' | ', $product_categories);


                // $implode_categories = empty($Categories) ? "-": implode(',',$Categories);
                // var_dump($Categories);
                // die();
                $item = file_get_contents('assets/item_products.html');
                $item = str_replace('{id}', $Product['id'], $item);
                $item = str_replace('{name}', $Product['name'], $item);
                $item = str_replace('{code}', $Product['code'], $item);               
                $item = str_replace('{price}', $Product['price'], $item);               
                $item = str_replace('{description}', $Product['description'], $item);               
                $item = str_replace('{quantity}', $Product['quantity'], $item);               
                $item = str_replace('{categories}', $text_categories, $item);               
            
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
