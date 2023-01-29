<?php namespace App\Models;
use CodeIgniter\Model;

class MitgliederModel extends Model {
    function getData() {
        $objects = $this->db->query('SELECT * from mitglieder');
        return $objects->getResultArray();
    }

    function login($username) {
        $personen = $this->db->table('mitglieder');
        $personen->select('passwort');
        $personen->where('mitglieder.username', $username);
        $result = $personen->get();

        return $result->getRowArray();
    }

    function addUser($username, $email, $passwort, $in_projekt) {
        $personen = $this->db->table('mitglieder');
        $mitglied_projekt = $this->db->table('mitglied_projekt');
        $personen->insert(array(
            'username' => $username,
            'email' => $email,
            'passwort' => $passwort,
            'in_projekt' => $in_projekt
            ));
        if ($in_projekt == 1) {
            $mitglied_projekt->insert(array(
                'mitglied_id' => $this->get_user_by_name($username)['id'],
                'projekt_id' => $_SESSION['chosen_projekt']
            ));
        }
    }

    function get_user($user_id) {
        $personen = $this->db->table('mitglieder');
        $personen = $personen->select('*');

        if ($user_id != NULL) {
            $personen = $personen->where('id', $user_id);
        }
        $result = $personen->get();

        if ($user_id != NULL) {
            return $result->getRowArray();
        }
        else {
            return $result->getResultArray();
        }
    }

    function get_user_by_name($username) {
        $personen = $this->db->table('mitglieder');
        $personen = $personen->select('*');

        if ($username != NULL) {
            $personen = $personen->where('username', $username);
        }
        $result = $personen->get();

        if ($username != NULL) {
            return $result->getRowArray();
        }
        else {
            return $result->getResultArray();
        }
    }

    function delete_user_by_id($user_id) {
        $personen = $this->db->table('mitglieder');
        $personen = $personen->select('*');
        $person_to_delete = $personen->where('id', $user_id);
        $person_to_delete->delete();
    }

    function update_user($user_id) {
        $personen = $this->db->table('mitglieder');
        $mitglied_projekt = $this->db->table('mitglied_projekt');
        $personen = $personen->select('*');
        $person_to_update = $personen->where('id', $user_id);
        $in_projekt = 0;
        $item = $this->db->table('mitglied_projekt');
        $item = $item->select('*');
        $item = $item->where('mitglied_id', $user_id);
        $item = $item->where('projekt_id', $_SESSION['chosen_projekt']);

        if (isset($_POST['in_projekt']) && $_POST['in_projekt'] == "on") {
            if ($item->get()->getRowArray()) {
                $item->update(array(
                    'mitglied_id' => $user_id,
                    'projekt_id' => $_SESSION['chosen_projekt']
                ));
            }
            else {
                $mitglied_projekt->insert(array(
                    'mitglied_id' => $user_id,
                    'projekt_id' => $_SESSION['chosen_projekt']
                ));
            }
            
        }
        else {
            $q = "DELETE FROM mitglied_projekt WHERE mitglied_id =".$user_id. " and projekt_id=".$_SESSION['chosen_projekt'];
            $q = $this->db->query($q);
        }
        $person_to_update->update(array(
            'username' => $_POST['username'],
            'email' => $_POST['email'],
            'in_projekt' => $in_projekt
            ));
    }

    function in_projekt($user_id, $projekt_id) {
        $q = "SELECT * FROM mitglied_projekt WHERE mitglied_id =".$user_id. " and projekt_id=".$projekt_id;
        $q = $this->db->query($q);
        return $q->getResultArray();
    }
}
