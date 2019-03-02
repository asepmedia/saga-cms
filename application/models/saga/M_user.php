<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @name Saga User Model
 * @author Asep Yayat
 * @version v.0.0.1
 * @since 2018
 * @email asepmedia18@gmail.com
 */

 class M_user extends CI_Model
 {
  public $table = 'saga_users';
  public $pk = 'id';

  /**
   * Register
   */
  public function add($data)
  {
    if($this->db->insert($this->table, $data)) {
      return 1;
    } else {
      return 0;
    }
  }

  /**
   * Login
   */
  public function login($data)
  {
    $email = $data['email'];
    $password = $data['password'];
    $check = $this->check($email);
    $result = 0;
    
    if($check->num_rows() == 1) {
      $row = $check->row();
      if(password_verify($password, $row->password)) {
        $session = array(
          'user' => $this->session($email)->row(),
        );
        $this->session->set_userdata($session);
        $result = 1;
      }
    }

    return $result;
  }

  /**
   * Check email
   */
  public function session($email)
  {
    return $this->db
      ->select('x1.id, x1.name, x1.email, x1.active, x1.avatar_path as avatar, x1.created_at, x2.role_id as role, x3.role_name')
      ->join('saga_user_role x2', 'x2.user_id=x1.id', 'LEFT JOIN')
      ->join('saga_role x3', 'x3.id=x2.role_id', 'LEFT JOIN')
      ->where('x1.email', $email)
      ->get($this->table . ' x1');
  }

  /**
   * Check email
   */
  public function check($email)
  {
    return $this->db
      ->select('x1.password')
      ->join('saga_user_role x2', 'x2.user_id=x1.id', 'LEFT JOIN')
      ->where('x1.email', $email)
      ->get($this->table . ' x1');
  }  
 }