<?php


namespace app\controllers;


class StraniceGreskeKontroler extends Controller
{
    public function strana403(){
        $this->loadPage("greske/403");
    }
    public function strana404(){
        $this->loadPage("greske/404");
    }
    public function strana400(){
        $this->loadPage("greske/400");
    }
}