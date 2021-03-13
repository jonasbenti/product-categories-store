<?php
    require_once 'classes/Product.php';
    require_once 'classes/Category.php';
    require_once 'classes/ProductCategories.php';
    require_once 'classes/Upload.php';

    class Productform
    {
    private $html;
    private $data;

    public function __construct() 
    {
        $this->html = file_get_contents('assets/form_product.html');
        $categories = '';
        Transaction::open('loja_webjump');

        foreach (Category::all() as $Category)
        {
             $categories .= "<option value='{$Category['id']}'> [{$Category['code']}] - {$Category['name']} </option>";
        }

        Transaction::close();

        $this->data = [
        'id' => null,
        'name' => null,
        'code' => null,
        'price' => null,
        'description' => null,
        'quantity' => null,
        'categories' => $categories,
        'image' => "Imagem"
        ];        
   
    }

        public function edit($param)
        {
            try 
            {
                Transaction::open('loja_webjump');
                
                $id = (int) $param['id'];
                $this->data = Product::find($id);

                if(!empty($this->data['image']))
                {
                    $this->data['image'] = "<a href='".$this->data['image']."' target='_blank' title='Exibe imagem já inserida em uma nova aba, caso precise trocar clique em \"Escolher Arquivo\"'>Abrir imagem</a>";
                }
                else
                {
                    $this->data['image'] = "Imagem";
                }
                
                $product_categories_id = [];
                foreach (ProductCategories::find($id) as $ProductCategory) 
                {
                    $product_categories_id[] = $ProductCategory['category_id'];
                }

                $categories = '';
                foreach (Category::all() as $Category)
                {
                    $check = (in_array($Category['id'], $product_categories_id)) ? 'selected=1' : '';
                    $categories .= "<option $check value='{$Category['id']}'> [{$Category['code']}] - {$Category['name']} </option>";
                }
                $this->data['categories'] = $categories;

                Transaction::close();

            } 
            catch (Exception $e) {
                echo $e->getMessage();
            }
        }

        public function save($param)
        {
            try 
            {
                Transaction::open('loja_webjump');
                //faz o upload da imagem
                $name_image = Upload::validUpload($_FILES['image']);
                $param['image'] = $name_image;
                $product_id = Product::save($param);
                $this->data = $param;

                //deleta as categorias existentes
                ProductCategories::delete($product_id);
                
                Transaction::close();

                //insere as novas categorias selecionadas
                if(!empty($param['categories']))
                {
                    foreach ($param['categories'] as $Category)
                    {
                        Transaction::open('loja_webjump');
                        ProductCategories::save($Category, $product_id);
                        Transaction::close();
                    }
                }                
                
                header("Location: index.php?class=ProductList");
            } 
            catch (Exception $e) {
                echo $e->getMessage();
            }
        }
        
        public function show()
        {
            $this->html  = file_get_contents('assets/form_product.html');
            $this->html  = str_replace('{id}', $this->data['id'], $this->html );
            $this->html  = str_replace('{name}', $this->data['name'], $this->html );
            $this->html  = str_replace('{code}', $this->data['code'], $this->html );
            $this->html  = str_replace('{price}', $this->data['price'], $this->html );
            $this->html  = str_replace('{description}', $this->data['description'], $this->html );
            $this->html  = str_replace('{quantity}', $this->data['quantity'], $this->html );
            $this->html  = str_replace('{categories}', $this->data['categories'], $this->html);
            $this->html  = str_replace('{image}', $this->data['image'], $this->html);
            echo $this->html;
        }



    }