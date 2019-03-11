<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class loginModel extends CI_Model {

    public function registerEmail($data) {
        $this->db->insert('acct_login', $data);
        $total = $this->db->affected_rows();
        if ($total > 0) {
            $insert_id = $this->db->insert_id();
            $data = array(
                'table' => 'acct_login',
                'col' => 'id',
                'val' => $insert_id,
            );
            $result = $this->getSingleRowData($data);
        } else {
            $result = false;
        }
        return $result;
    }

    public function login($email, $password)
    {
        $this->db->where('clientEmail', $email);
        $this->db->where('clientPassword', $password);
        $this->db->limit(1);
        $q = $this->db->get('acct_login');
        if ($q->num_rows() == 1) {
            $result = $q->row();
            return $result;
        }
    }

    public function checkemail($email) {
        $this->db->where('clientEmail', $email);
        $q = $this->db->get('acct_login');
        if ($q->num_rows() > 0) {
            $result = true;
        } else {
            $result = false;
        }
        return $result;
    }

    public function checkClientRef($clientRef) {
        $this->db->where('clientRef', $clientRef);
        $q = $this->db->get('acct_login');
        if ($q->num_rows() > 0) {
            $data = array(
                'isEmailVerified' => 2
            );
            $this->db->where('clientRef', $clientRef);
            $q1 = $this->db->update('acct_login', $data);
            $total = $this->db->affected_rows();
            $result = $q->row();
        } else {
            $result = false;
        }
        return $result;
    }

    public function insertData($table, $data) {
        $this->db->insert($table, $data);
        $total = $this->db->affected_rows();
        if ($total == 1) {
            $result = true;
        } else {
            $result = false;
        }
        return $result;
    }

    public function getSingleRowData($data) {
        $this->db->where($data['col'], $data['val']);
        $this->db->limit(1);
        $q = $this->db->get($data['table']);
        if ($q->num_rows() == 1) {
            $result = $q->row();
        } else {
            $result = false;
        }
        return $result;
    }

    public function changeForgetPassword($oldemail, $newPassword) {
        $data = array(
            'clientPassword' => md5($newPassword)
        );
        $this->db->where('clientEmail', $oldemail);
        $this->db->update("acct_login", $data);

        return TRUE;
    }

    public function checkOldPassword($id, $oldpassword) {
        $this->db->where('clientRef', $id);
        $this->db->where('clientPassword', $oldpassword);
        $q = $this->db->get('acct_login');
        if ($q->num_rows() >= 1) {
            $result = true;
        } else {
            $result = false;
        }
        return $result;
    }

    public function updatePassword($id, $password) {
        $data = array(
            'clientPassword' => $password
        );
        $this->db->where('clientRef', $id);
        $q = $this->db->update('acct_login', $data);
        $total = $this->db->affected_rows();
        if ($total > 0) {
            $result = true;
        } else {
            $result = false;
        }
        return $result;
    }

}
