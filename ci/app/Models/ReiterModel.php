<?php namespace App\Models;
use CodeIgniter\Model;

class ReiterModel extends Model {
    function getData() {
        $objects = $this->db->query('SELECT * from reiter');
        return $objects->getResultArray();
    }

    function get_assigned_data() {
        $q = "SELECT * FROM reiter, reiter_projekt WHERE id=reiter_projekt.reiter_id and projekt_id=".$_SESSION['chosen_projekt'];
        $q = $this->db->query($q);
        return $q->getResultArray();
    }

    function addData() {
        $reiter = $this->db->table('reiter');
        $reiter_projekt = $this->db->table('reiter_projekt');
        $reiter->insert(array(
            'name' => $_POST['name'],
            'beschreibung' => $_POST['beschreibung']
        ));
        $reiter_projekt->insert(array(
            'reiter_id' => $this->get_reiter_by_name($_POST['name'])['id'],
            'projekt_id' => $_SESSION['chosen_projekt']
        ));
    }

    function delete_reiter($reiter_id) {
        $reiter = $this->db->table('reiter');
        $reiter = $reiter->select('*');
        $reiter_to_delete = $reiter->where('id', $reiter_id);
        $reiter_to_delete->delete();
    }

    function get_reiter_by_id($reiter_id) {
        $reiter = $this->db->table('reiter');
        $reiter = $reiter->select('*');
        $reiter = $reiter->where('id', $reiter_id);
        $result = $reiter->get();
        return $result->getRowArray();
    }

    function get_reiter_by_name($name) {
        $reiter = $this->db->table('reiter');
        $reiter = $reiter->select('*');

        if ($name != NULL) {
            $reiter = $reiter->where('name', $name);
        }
        $result = $reiter->get();

        if ($name != NULL) {
            return $result->getRowArray();
        }
        else {
            return $result->getResultArray();
        }
    }

    function update_reiter($reiter_id) {
        $reiter = $this->db->table('reiter');
        $reiter = $reiter->select('*');
        $reiter_to_update = $reiter->where('id', $reiter_id);
        $reiter_to_update->update(array(
            'name' => $_POST['reiter_name'],
            'beschreibung' => $_POST['beschreibung']
        ));
    }
}

