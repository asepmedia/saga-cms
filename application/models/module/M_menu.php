<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @name Saga User Model
 * @author Asep Yayat
 * @version v.0.0.1
 * @since 2018
 * @email asepmedia18@gmail.com
 */

 class M_menu extends CI_Model
 {
  static $table = 'saga_menus';

  static $pk = 'id';

	/**
	 * Recursive function for save menu position
	 * @return Void
	 */
	public function update_position($parent_id, $children) {
		$i = 1;
		foreach ($children as $key => $value) {
			$id = $children[$key]['id'];
			$fill_data = [
				'parent' => $parent_id,
        'position' => $i
			];
			$this->db->where(self::$pk, $id)->update(self::$table, $fill_data);
			if (isset($children[$key]['children'][0])) {
				$this->update_position($id, $children[$key]['children']);
			}
			$i++;
		}
  }
  
  /**
   * EDit
   */
  public function detail_menu($id)
  {
    $menu = $this->db
      ->select('x1.*')
      //->join('saga_module_role x2','x1.id=x2.module_id', 'LEFT JOIN')
      ->where('x1.id', $id)
      //->where('x2.role_id', 1)
      ->where('x1.location', 'admin')
      ->order_by('x1.position', 'ASC')
      ->get(self::$table .' x1')
      ->row();

    $data = array(
      'menu' => $menu,
      'role' => $this->role_menu($id)
    );      

    return $data;
  }

	/**
	 * Check if child exist
	 * @param Int
	 * @return Boolean
	 */
	public function is_child_exist($parent) {
		$query = $this->db
			->where('parent', $parent)
			->count_all_results(self::$table);
		return $query > 0;
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
        ->where('group_id', 1)
				->count_all_results('saga_module_role');
			if ($count == 0 ) {
				$data[] = [
          'module_id' => $menu,
          'role_id' => $r,
          'group_id' => 1
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
		if($this->db->where('module_id', $menu)->delete('saga_module_role')) {
      if(count($role) > 0) {
        foreach ($role as $r) {
          $data[] = [
            'module_id' => $menu,
            'role_id' => $r
          ];
        } 
        $this->db->where('group_id', 2);
        return $this->db->insert_batch('saga_module_role', $data, 'module_id');
      }     
    }
  }

  /**
   * Delete role
   */
  public function delete_role($menu)
  {
    return $this->db->where('module_id', $menu)->delete('saga_module_role');
  }
  
  /**
   * Delete menu
   */
  public function delete_menu($id) {
    if(!$this->is_child_exist($id)) {
      $query = $this->db
      ->where('id', $id)
      ->delete('saga_menus');
      if($query && $this->delete_role($id)) {
        return 1;
      }
    }

    return 0;
  }
  /**
   * EDit
   */
  public function role_menu($menu)
  {
    return $this->db
      ->select('x1.*, x2.role_name, x2.role_description')
      ->join('saga_role x2','x1.role_id=x2.id', 'LEFT JOIN')
      ->where('x1.module_id', $menu)
      ->get('saga_module_role x1')
      ->result_array();
  }  

	public function side_menu_list($menu, $parent = 0, $module = 0)
	{
		$result = array();

		foreach($menu as $v) {
			if($v->parent == $parent) {
				$result[] = [
					'id' => $v->id,
          'name' => $v->name,
          'icon' => $v->icon,
          'link' => $v->type == 'local' ? base_url() . $v->link : $v->link,
          'parent' => $v->parent,
          'type' => $v->type,
					'child' => $this->side_menu_list($menu, $v->id, $module)
				];
			}
		}
		return $result;
  }

  /**
   * Side menu
   */
  public function side_menu()
  {
    $role = $this->session->userdata('user')->role;
    $menu = $this->db
      ->select('x1.*')
      ->join('saga_module_role x2','x1.id=x2.module_id', 'LEFT JOIN')
      ->where('x2.role_id', $role)
      ->where('x2.group_id', 1)
      ->where('x1.location', 'admin')
      ->order_by('x1.position', 'ASC')
      ->get('saga_menus x1')
      ->result();
    $list = $this->side_menu_list($menu);
    return $list;
  }    
 }