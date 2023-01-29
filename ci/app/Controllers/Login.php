<?php

namespace App\Controllers;

use App\Models\MitgliederModel;

class Login extends BaseController
{
    public function index() {
        $this->session->set('loggedin', 'not_yet');
        return view('login');
    }

    public function login_user() {
        $mitglieder = new MitgliederModel();
        if ($this->validation->run($_POST, 'login')){
            if (isset($_POST['username']) && isset($_POST['passwort'])) {
                if ($mitglieder->login($_POST['username']) != NULL) {
                    $passwort = $mitglieder->login($_POST['username'])['passwort'];
                    if (password_verify($_POST['passwort'], $passwort)) {
                        $this->session->set('username', $_POST['username']);
                        $this->session->set('loggedin', TRUE);
                        unset($_SESSION['chosen_projekt']);
                        return redirect()->to(base_url() . '/projekte');
                    }
                }
                else {
                    return view('login');
                }
            }
            return view('login');
        }
        else {
            $data['errors'] = $this->validation->getErrors();
            return view('login', $data);
        }

    }

    public function logout() {
        $this->session->set('loggedin', FALSE);
        unset($_SESSION['chosen_projekt']);
        return redirect()->to(base_url() . "/");
    }

    public function table_stat(){
        $data['title']= 'Statische-Tabelle';
        echo view('templates/header');
        echo view('pages/table_stat', $data);
        echo view('templates/footer');
    }
}
