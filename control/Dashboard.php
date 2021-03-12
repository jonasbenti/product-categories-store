<?php

class Dashboard
{
    private $html;

    public function __construct()
    {
        $this->html = file_get_contents('assets/dashboard.html');
    }
       
    public function show()
    {
       
        echo $this->html;
    }
}
