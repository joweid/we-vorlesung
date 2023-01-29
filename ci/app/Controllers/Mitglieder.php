<?php

namespace App\Controllers;

use App\Models\MitgliederModel;
use App\Models\person;

class Mitglieder extends BaseController
{
    public function index() {
        if (is_string($_SESSION['loggedin'])){
            return redirect()->to(base_url() . "/");
        }
        $mitglieder = new MitgliederModel();
        $data['persons'] = $mitglieder->getData();
        return view('mitglieder', $data);
    }

    public function create_user() {
        $mitglieder = new MitgliederModel();
        if (isset($_POST['username']) && isset($_POST['email']) && isset($_POST['passwort'])) {
            $in_projekt = 0;
            if (isset($_POST['in_projekt'] )) {
                $in_projekt = 1;
            }
            $mitglieder->addUser($_POST['username'], $_POST['email'], password_hash($_POST['passwort'], PASSWORD_BCRYPT), $in_projekt);
            return redirect()->to(base_url() . '/mitglieder');
        }
    }

    public function edit_user() {
        $mitglieder = new MitgliederModel();
        if (isset( $_POST['edit_btn'])) {
            $user_to_edit = $mitglieder->get_user($_POST['edit_btn']);
            $data['user'] = $user_to_edit;
            return view('edit_user', $data);
        }
        if (isset($_POST['delete_btn'])) {
            $mitglieder->delete_user_by_id($_POST['delete_btn']);
            return redirect()->to(base_url() . '/mitglieder');
        }
    }

    public function update_user() {
        $mitglieder = new MitgliederModel();
        $mitglieder->update_user($_POST['user_id']);
        return redirect()->to(base_url() . '/mitglieder');
    }

    public function show_user_properties() {
        $mitglieder = new MitgliederModel();
        return redirect()->to(base_url() . '/mitglieder');
    }

    public function table_stat()
    {
        $data['title'] = 'Statische-Tabelle';
        echo view('templates/header');
        echo view('pages/table_stat', $data);
        echo view('templates/footer');
    }
}
