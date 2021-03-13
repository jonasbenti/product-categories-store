<?php
    require_once 'classes/Category.php';

    class Categoryform
    {
    private $html;
    private $data;

        public function __construct() 
        {
        $this->html = file_get_contents('assets/form_category.html');
        $this->data = [
        'id' => null,
        'name' => null,
        'code' => null
        ];
        }

        public function edit($param)
        {
            try 
            {
                Transaction::open('loja_webjump');

                $id = (int) $param['id'];
                $this->data = Category::find($id);

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

                Category::save($param);
                $this->data = $param;
                header("Location: index.php?class=CategoryList");

                Transaction::close();
            } 
            catch (Exception $e) {
                echo $e->getMessage();
            }
        }

        public function show()
        {
            $this->html  = file_get_contents('assets/form_category.html');
            $this->html  = str_replace('{id}', $this->data['id'], $this->html );
            $this->html  = str_replace('{name}', $this->data['name'], $this->html );
            $this->html  = str_replace('{code}', $this->data['code'], $this->html );
            echo $this->html;
        }
    }