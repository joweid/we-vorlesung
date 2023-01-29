<?php

namespace App\Controllers;

use App\Models\ReiterModel;

class Reiter extends BaseController
{
    public function index() {
        if (is_string($_SESSION['loggedin'])){
            return redirect()->to(base_url() . "/");
        }
        $reiter = new ReiterModel();
        $data['reiter'] = $reiter->get_assigned_data();
        return view('reiter', $data);
    }

    public function create_reiter() {
        $reiter = new ReiterModel();
        if (isset($_POST['name']) && isset($_POST['beschreibung'])) {
            $reiter->addData();
            return redirect()->to(base_url() . '/reiter');
        }
    }

    public function edit_reiter() {
        $reiter = new ReiterModel();

        if (isset($_POST['delete_btn'])) {
            $reiter->delete_reiter($_POST['delete_btn']);
            return redirect()->to(base_url() . '/reiter');
        }
    }

    public function update_reiter() {
        $reiter = new ReiterModel();
        $reiter->update_reiter($_POST['reiter_id']);
        return redirect()->to(base_url() . '/reiter');
    }

    public function table_stat(){
        $data['title']= 'Statische-Tabelle';
        echo view('templates/header');
        echo view('pages/table_stat', $data);
        echo view('templates/footer');
    }
}
