<?php

namespace App\Controllers;

use App\Models\ReiterModel;

class Todos extends BaseController
{
    public function index() {
        if (is_string($_SESSION['loggedin'])){
            return redirect()->to(base_url() . "/");
        }
        $reiter = new ReiterModel();
        $data['reiter'] = $reiter->get_assigned_data();
        return view('todos', $data);
    }

    public function table_stat(){
        $data['title']= 'Statische-Tabelle';
        echo view('templates/header');
        echo view('pages/table_stat', $data);
        echo view('templates/footer');
    }
}
