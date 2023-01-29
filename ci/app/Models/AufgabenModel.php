<?php namespace App\Models;
use CodeIgniter\Model;

class AufgabenModel extends Model {
    function getData() {
        $objects = $this->db->query('SELECT * from aufgaben');
        return $objects->getResultArray();
    }

    function get_assigned_data() {
        $q = "SELECT * FROM aufgaben, aufgaben_projekt WHERE aufgaben.id=aufgaben_projekt.aufgaben_id and aufgaben_projekt.projekt_id=".$_SESSION['chosen_projekt'];
        $q = $this->db->query($q);
        return $q->getResultArray();
    }

    function addData() {
        $aufgaben = $this->db->table('aufgaben');
        $hat_aufgabe = $this->db->table('hat_aufgabe');
        $aufgaben_projekt = $this->db->table('aufgaben_projekt');
        $aufgaben->insert(array(
            'name' => $_POST['bezeichnung'],
            'beschreibung' => trim($_POST['beschreibung']),
            'erstellungsdatum' => $_POST['startdatum'],
            'faelligkeitsdatum' => $_POST['enddatum'],
            'reiter' => $_POST['reiter']
            ));
        
        $aufgaben_id = $this->get_aufgabe_by_name($_POST['bezeichnung'])['id']; 
        foreach($_POST['mitglieder'] as $mitglied_id) {
            $hat_aufgabe->insert(array(
                'mitglied' => $mitglied_id,
                'aufgabe' => $aufgaben_id
            ));
        }

        $aufgaben_projekt->insert(array(
            'aufgaben_id' => $this->get_aufgabe_by_name($_POST['bezeichnung'])['id'],
            'projekt_id' => $_SESSION['chosen_projekt']
        ));
    }

    function get_aufgabe($aufgaben_id) {
        $aufgaben = $this->db->table('aufgaben');
        $aufgaben = $aufgaben->select('*');
        $aufgaben = $aufgaben->where('id', $aufgaben_id);
        $result = $aufgaben->get();

        if ($aufgaben_id != NULL) {
            return $result->getRowArray();
        }
        else {
            return $result->getResultArray();
        }
    }

    function delete_aufgabe_by_id ($aufgaben_id) {
        $aufgaben = $this->db->table('aufgaben');
        $aufgaben = $aufgaben->select('*');
        $aufgabe_to_delete = $aufgaben->where('id', $aufgaben_id);
        $aufgabe_to_delete->delete();

        $this->delete_assigned_mitglieder($aufgaben_id);
    }

    function delete_assigned_mitglieder($aufgaben_id) {
        $q = "DELETE FROM hat_aufgabe WHERE aufgabe =".$aufgaben_id;
        $q = $this->db->query($q);
    }

    function get_aufgabe_by_name($bezeichnung) {
        $aufgaben = $this->db->table('aufgaben');
        $aufgaben = $aufgaben->select('*');

        if ($bezeichnung != NULL) {
            $aufgaben = $aufgaben->where('name', $bezeichnung);
        }
        $result = $aufgaben->get();

        if ($bezeichnung != NULL) {
            return $result->getRowArray();
        }
        else {
            return $result->getResultArray();
        }
    }

    function get_assigned_mitglieder($aufgaben_id) {
        $q =  "SELECT mitglied FROM hat_aufgabe WHERE aufgabe =".$aufgaben_id;
        $q = $this->db->query($q);
        return $q->getResultArray();
    }

    function update_aufgabe($aufgaben_id) {
        $aufgaben = $this->db->table('aufgaben');
        $aufgaben = $aufgaben->select('*');
        $aufgabe_to_update = $aufgaben->where('id', $aufgaben_id);
        
        $aufgabe_to_update->update(array(
            'name' => $_POST['bezeichnung'],
            'beschreibung' => trim($_POST['beschreibung']),
            'erstellungsdatum' => $_POST['startdatum'],
            'faelligkeitsdatum' => $_POST['enddatum'],
            'reiter' => $_POST['reiter']
            ));
        
        $hat_aufgabe = $this->db->table('hat_aufgabe');
        $this->delete_assigned_mitglieder($aufgaben_id);
        foreach($_POST['mitglieder'] as $mitglied_id) {
            $hat_aufgabe->insert(array(
                'mitglied' => $mitglied_id,
                'aufgabe' => $aufgaben_id
            ));
        }
    }

    function get_aufgaben_of_reiter($reiter_id) {
        $q = "SELECT * FROM aufgaben WHERE reiter =".$reiter_id;
        $q = $this->db->query($q);
        return $q->getResultArray();
    }
}
