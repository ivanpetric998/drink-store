<?php
namespace app\controllers;

use app\models\DB;
use app\models\Kategorija;
use app\models\Meni;
class Controller
{

    protected $data = null;
    protected $baza;

    public function __construct()
    {
        $this->baza=new DB(SERVER,DATABASE,USERNAME,PASSWORD);
    }

    protected function loadPage(string $page, $data = null){
        include "app/views/fixed/head.php";
        include "app/views/fixed/header.php";
        include "app/views/pages/{$page}.php";
        include "app/views/fixed/footer.php";
    }

    protected function redirect($page) {
        header("Location: " . $page);
    }

    protected function json($data = null, $statusCode = 200) {
        header("content-type: application/json");
        http_response_code($statusCode);
        echo json_encode($data);
    }

    protected function ucitajKorisnickiMeni(){
        $kategorije=new Kategorija($this->baza);
        $this->data['kategorijeMeni'] = $kategorije->getAll();

        $meni=new Meni($this->baza);
        $this->data['meniDodatno'] = $meni->getMeniDodatno();
    }

    protected function getAdminMeni(){
        $meni=new Meni($this->baza);
        $this->data['meniAdmin'] = $meni->getmeniAdmin();
    }

}