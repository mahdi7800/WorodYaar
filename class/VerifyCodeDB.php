<?php

class VerifyCodeDB
{
    private $db;
    private $table;
  public function __construct()
  {
      global $wpdb;
      $this->db = $wpdb;
      $this->table = $wpdb->prefix . 'wy_verify_code';
  }
  public function wy_creating_and_select_verification_code($phone_number, $verification_code)
  {
      $stmt = $this->db->get_row($this->db->prepare("SELECT * FROM {$this->table} WHERE phone=%s",$phone_number));
      if($stmt !== null){
          $data = ['verification_code'=>$verification_code];
          $format=['%s'];
          $where = ['phone'=>$phone_number];
          $where_format = ['%s'];
          $this->db->update($this->table,$data,$where,$format,$where_format);
      }else{
          $data =
          [
              'phone'=>$phone_number,
              'verification_code'=>$verification_code
          ];
          $format=['%s','%s'];
          $this->db->insert($this->table,$data,$format);
      }
  }

  public function wy_select_verification_code_check($verification_code)
  {
     $stmt = $this->db->get_row($this->db->prepare("SELECT * FROM {$this->table} WHERE verification_code=%s",$verification_code));
      if ($stmt) {
          wp_send_json(['success' => true, 'message' => 'کد تاییدیه معتبر است!'], 200);
         $this->wp_wy_verification_code_to_db_delete($verification_code);
      } else {
          wp_send_json(['error' => true, 'message' => 'کد تاییدیه معتبر نمی‌باشد!'], 403);
      }
  }
  public function wp_wy_verification_code_to_db_delete($verification_code){
      $where = ['verification_code'=>$verification_code];
      $where_format = ['%s'];
      return $this->db->delete($this->table,$where,$where_format);
  }
}