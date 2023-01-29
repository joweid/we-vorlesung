<?php

namespace App\Controllers;

use App\Models\ProjektModel;

class Projekte extends BaseController
{
    public function index() {
        if (is_string($_SESSION['loggedin'])){
            return redirect()->to(base_url() . "/");
        }
        $projekte = new ProjektModel();
        $data['projekte'] = $projekte->getData();
        return view('projekte', $data);
    }

    public function add_projekt() {
        $projekte = new ProjektModel();
        if (isset($_POST['projekt_name']) && isset($_POST['beschreibung'])) {
            $projekte->create_projekt($_POST['projekt_name'], $_POST['beschreibung'], $_SESSION['username']);
            return redirect()->to(base_url() . '/projekte');
        }
        return redirect()->to(base_url() . '/projekte');
    }

    public function edit_projekt() {
        if (isset($_POST['choose'])) {
            $this->session->set('chosen_projekt', $_POST['choose']);
            return redirect()->to(base_url() . '/projekte');
        }

        $projekte = new ProjektModel();
        if (isset($_POST['delete_btn'])) {
            $projekte->delete_projekt_by_id($_POST['delete_btn']);
            return redirect()->to(base_url() . '/projekte');
        }
    }

    public function update_projekt() {
        $projekte = new ProjektModel();
        $projekte->update_projekt($_POST['projekt_id']);
        return redirect()->to(base_url() . '/projekte');
    }

    public function table_stat() {
        $data['title']= 'Statische-Tabelle';
        echo view('templates/header');
        echo view('pages/table_stat', $data);
        echo view('templates/footer');
    }
}
