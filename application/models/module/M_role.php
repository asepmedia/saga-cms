<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @name Saga Role Model
 * @author Asep Yayat
 * @version v.0.0.1
 * @since 2018
 * @email asepmedia18@gmail.com
 */

class M_role extends CI_Model
{
  static $table = 'saga_module_role';

  static $pk;

  /**
   * Has Role function
   *
   * @param [type] $module
   * @param [type] $role
   * @return boolean
   */
  public function has($module, $module_child, $role)
  {
    return $this->db
      ->select('x1.role_id, x2.module_name')
      ->join('saga_modules x2', 'x1.module_id=x2.id', 'LEFT JOIN')
      ->where('x2.module_name', $module)
      ->where('x2.module_child_name', $module_child)
      ->where('x1.role_id', $role)
      ->where('x1.group_id', 2)
      ->limit(1)
      ->get(self::$table . ' x1')
      ->num_rows();
  }

  public function module_action($module = '')
  {
    $query = $this->db
      ->where('module_name', $module)
      ->get('saga_modules')
      ->result();

    $result = array();
    foreach($query as $q) {
      $result[] = array(
        'id' => $q->id,
        'module_name' => $q->module_name,
        'module_child_name' => $q->module_child_name,
        'module_type' => $q->module_type,
        'role' => $this->role_module($q->id)
      );
    }

    return $result;
  }

  /**
   * role_module function
   *
   * @param [type] $module
   * @return void
   */
  public function role_module($module)
  {
    return $this->db
      ->select('x1.*, x2.role_name, x2.role_description')
      ->join('saga_role x2','x1.role_id=x2.id', 'LEFT JOIN')
      ->where('x1.module_id', $module)
      ->where('x1.group_id', 2)
      ->get('saga_module_role x1')
      ->result_array();
  }

	/**
	 * Create Tag from posts
	 */
	public function create_role($role, $menu) {
    $data = array();
		foreach ($role as $r) {
			$count = $this->db
        ->where('role_id', $r)
        ->where('module_id', $menu)
        ->where('group_id', 2)
				->count_all_results('saga_module_role');
			if ($count == 0 ) {
				$data[] = [
          'module_id' => $menu,
          'role_id' => $r,
          'group_id' => 2
        ];
			}
    }
    return $this->db->insert_batch('saga_module_role', $data);
  }

  /**
	 * Create Tag from posts
	 */
	public function update_role($role, $menu) {
    $data = array();
		if($this->db->where('module_id', $menu)->where('group_id', 2)->delete('saga_module_role')) {
      if(count($role) > 0) {
        foreach ($role as $r) {
          $data[] = [
            'module_id' => $menu,
            'role_id' => $r,
            'group_id' => 2
          ];
        } 
        $this->db->where('group_id', 2);
        return $this->db->insert_batch('saga_module_role', $data, 'module_id');
      }     
    }
  }

  public function role_list($keyword = '')
  {
    $query = $this->db;
    if($keyword != '') {
      $query->like('role_name', $keyword);
    }
    return $query->get('saga_role')
      ->result_array();
  }
  /**
   * Delete role
   */
  public function delete_role($menu)
  {
    return $this->db->where('module_id', $menu)->delete('saga_module_role');
  }   
}