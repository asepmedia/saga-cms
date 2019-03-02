<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @name Saga Helper Model
 * @author Asep Yayat
 * @version v.0.0.1
 * @since 2018
 * @email asepmedia18@gmail.com
 */

 class M_helper extends CI_Model
 {
  /**
  * Insert
  * @return bool
  */
  public function insert($table, $data)
  {
    return $this->db->insert($table, $data);
  }
  
  /**
  * Insert batch
  */
  public function insert_batch($table, $data)
  {
  return $this->db->insert_batch($table, $data);
  }

  /**
  * Read
  */
  public function read($table, $pk, $data)
  {
  return $this->db->where($pk, $data)->get($table)->row();
  }

  /**
   * Update
   */
  public function update($table, $pk, $data)
  {
  return $this->db->where($pk)->update($table, $data);
  }

  /**
   * Batch
   */
  public function update_batch($table, $pk, $data)
  {
  return $this->db->update_batch($table, $data, $pk);
  }

  /**
   * Transaction
   */
  public function transaction($table)
  {
    if(!is_array($table)) {
      return 0;
    }
    $this->db->trans_start(); # Starting Transaction

    foreach($table as $t) {
      eval($t);
    }

    $this->db->trans_complete(); # Completing transaction

    if ($this->db->trans_status() === FALSE) {
      $this->db->trans_rollback();
      return 0;
    } 
    else {
      $this->db->trans_commit();
      return 1;
    }
  }
 }