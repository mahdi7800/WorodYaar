<?php

class TokenUrlDB
{
    private $db;
    private $table;

    public function __construct()
    {
        global $wpdb;
        $this->db = $wpdb;
        $this->table = $wpdb->prefix . 'wy_validate_token';
    }

    public function wy_creating_and_select_verification_token($email, $token)
    {
        $token = explode('=', $token);
        $stmt = $this->db->get_row($this->db->prepare("SELECT * FROM {$this->table} WHERE email=%s", $email));
        if ($stmt) {
            $data = ['token' => $token[1]];
            $where = ['email' => $email];
            $format = ['%s'];
            $where_format = ['%s'];
            $this->db->update($this->table, $data, $where, $format, $where_format);
        } else {
            $data = ['token' => $token[1], 'email' => $email];
            $format = ['%s', '%s'];
            $this->db->insert($this->table, $data, $format);
        }
    }

    public function wy_select_token($token)
    {

        $stmt = $this->db->get_row($this->db->prepare("SELECT token FROM {$this->table} WHERE token=%s", $token));
        return $stmt;
    }

    public function wy_check_token_get_user_ID($token){
        $stmt = $this->db->get_row($this->db->prepare("SELECT * FROM {$this->table} WHERE token = %s", $token));

        if (!$stmt || empty($stmt->email)) {
            return false;
        }

        $user = get_user_by('email', $stmt->email);

        return $user ? $user->ID : false;
    }

    public function wy_delete_token($token)
    {
        $where = ['token' => $token];
        $where_format = ['%s'];
        $this->db->delete($this->table, $where, $where_format);
    }

}