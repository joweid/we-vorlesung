<?php namespace App\Models;
use CodeIgniter\Model;

class ProjektModel extends Model {
    function getData() {
        $objects = $this->db->query('SELECT * from projekte');
        return $objects->getResultArray();
    }

    function get_projekt($projekt_id) {
        $projekte = $this->db->table('projekte');
        $projekte = $projekte->select('*');

        if ($projekt_id != NULL) {
            $projekte = $projekte->where('id', $projekt_id);
        }
        $result = $projekte->get();

        if ($projekt_id != NULL) {
            return $result->getRowArray();
        }
        else {
            return $result->getResultArray();
        }
    }

    function delete_projekt_by_id($projekt_id) {
        $projekte = $this->db->table('projekte');
        $projekte = $projekte->select('*');
        $projekt_to_delete = $projekte->where('id', $projekt_id);
        $projekt_to_delete->delete();

        $q = "DELETE FROM aufgaben
        WHERE EXISTS (SELECT *
                      FROM aufgaben_projekt
                      WHERE aufgaben.id = aufgaben_projekt.aufgaben_id
                        AND aufgaben_projekt.projekt_id = ". $projekt_id. ")";
        $q = $this->db->query($q);
        $q = "DELETE FROM aufgaben_projekt WHERE projekt_id =".$projekt_id;
        $q = $this->db->query($q);
        $q = "DELETE FROM mitglieder
        WHERE EXISTS (SELECT *
                      FROM mitglied_projekt
                      WHERE mitglieder.id = mitglied_projekt.mitglied_id
                        AND mitglied_projekt.projekt_id = ". $projekt_id. ")";
        $q = $this->db->query($q);
        $q = "DELETE FROM mitglied_projekt WHERE projekt_id =".$projekt_id;
        $q = $this->db->query($q);
        $q = "DELETE FROM reiter
        WHERE EXISTS (SELECT *
                      FROM reiter_projekt
                      WHERE reiter.id = reiter_projekt.reiter_id
                        AND reiter_projekt.projekt_id = ". $projekt_id. ")";
        $q = $this->db->query($q);
        $qu = "DELETE FROM reiter_projekt WHERE projekt_id =".$projekt_id;
        $qu = $this->db->query($qu);
        unset($_SESSION['chosen_projekt']);
    }

    function create_projekt($name, $beschreibung, $ersteller_name) {
        $mitglieder = new MitgliederModel();
        $projekte = $this->db->table('projekte');
        $ersteller = $mitglieder->get_user_by_name($ersteller_name);
        $projekte->insert(array(
            'name' => $name,
            'beschreibung' => $beschreibung,
            'ersteller' => $ersteller['id']
        ));
    }

    function update_projekt($projekt_id) {
        $projekte = $this->db->table('projekte');
        $projekte = $projekte->select('*');
        $projekt_to_update = $projekte->where('id', $projekt_id);
        $projekt_to_update->update(array(
            'name' => $_POST['projekt_name'],
            'beschreibung' => $_POST['beschreibung']
        ));
    }
}

