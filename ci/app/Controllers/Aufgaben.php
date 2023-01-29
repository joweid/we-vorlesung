<?php

namespace App\Controllers;

use App\Models\AufgabenModel;
use App\Models\ReiterModel;
use App\Models\MitgliederModel;

class Aufgaben extends BaseController
{
    public function index() {
        if (is_string($_SESSION['loggedin'])){
            return redirect()->to(base_url() . "/");
        }
        $aufgaben = new AufgabenModel();
        $reiter = new ReiterModel();
        $mitglieder = new MitgliederModel();
        $data['aufgaben'] = $aufgaben->get_assigned_data();
        $data['reiter'] = $reiter->get_assigned_data();
        $data['mitglieder'] = $mitglieder->getData();

        return view('aufgaben', $data);
    }

    public function create_aufgabe() {
        $aufgaben = new AufgabenModel();
        if (isset($_POST['bezeichnung']) && isset($_POST['beschreibung']) && isset($_POST['startdatum']) &&
         isset($_POST['enddatum']) && isset($_POST['reiter']) && isset($_POST['mitglieder'])) {
            $aufgaben->addData();
            return redirect()->to(base_url() . '/aufgaben');
        }
    }

    public function edit_aufgabe() {
        $aufgaben = new AufgabenModel();
        $reiter = new ReiterModel();
        $mitglieder = new MitgliederModel();

        if (isset( $_POST['edit_btn'])) {
            $aufgabe_to_edit = $aufgaben->get_aufgabe($_POST['edit_btn']);
            $data['aufgabe'] = $aufgabe_to_edit;
            $data['reiter'] = $reiter->get_assigned_data();
            $data['mitglieder'] = $mitglieder->getData();
            return view('edit_aufgabe', $data);
        }
        if (isset($_POST['delete_btn'])) {
            $aufgaben->delete_aufgabe_by_id($_POST['delete_btn']);
            return redirect()->to(base_url() . '/aufgaben');
        }
    }

    public function update_aufgabe() {
        $aufgaben = new AufgabenModel();
        if (isset($_POST['bezeichnung']) && isset($_POST['beschreibung']) && isset($_POST['startdatum']) &&
         isset($_POST['enddatum']) && isset($_POST['reiter']) && isset($_POST['mitglieder'])) {
            $aufgaben->update_aufgabe($_POST['aufgaben_id']);
            return redirect()->to(base_url() . '/aufgaben');
        }
        return redirect()->to(base_url() . '/aufgaben');
    }

    public function table_stat(){
        $data['title']= 'Statische-Tabelle';
        echo view('templates/header');
        echo view('pages/table_stat', $data);
        echo view('templates/footer');
    } 
}
