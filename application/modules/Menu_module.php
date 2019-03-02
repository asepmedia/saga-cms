<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Menu_module extends Module{
  
  public function __construct()
  {
    $this->load->model('module/m_menu', 'm_menu');
  }

  public function index($module = 1) {
    $context['view'] = 'modules/menu/index';
    Theme::run($context)->withRole();	
  }

  public function location($module = 1) {
    $context['view'] = 'modules/menu/index';
    Theme::run($context)->withRole();	
  }

  public function create($module = 0) {
    $data = array(
      'name' => $this->input->post('name', TRUE),
      'icon' => $this->input->post('icon', TRUE),
      'link' => self::url($this->input->post('link', TRUE)),
      'parent' => $this->input->post('parent', TRUE),
      'location' => $this->input->post('location', TRUE),
      'type' => $this->input->post('type', TRUE),
      'position' => $this->input->post('position', TRUE)
    );

    $role = $this->input->post('role', TRUE);
    
    if(count($role) > 0) {
      if($this->db->insert('saga_menus', $data)) {
        $module = $this->db->insert_id();
  
        if($this->m_menu->create_role($role, $module)) {
          self::json(array(
            'message' => 'Success add menu' 
          ));
        }
      }
    }
  }

  public function update($module = 1) {
    $data = array(
      'name' => $this->input->post('name', TRUE),
      'icon' => $this->input->post('icon', TRUE),
      'link' => self::url($this->input->post('link', TRUE)),
      'parent' => $this->input->post('parent', TRUE),
      'location' => $this->input->post('location', TRUE),
      'type' => $this->input->post('type', TRUE),
      'position' => $this->input->post('position', TRUE)
    );

    $id = $this->input->post('id', TRUE);

    $role = $this->input->post('role', TRUE);
    
    if(count($role) >= 0) {
      if($this->db->where('id', $id)->update('saga_menus', $data)) {
        if($this->m_menu->update_role($role, $id)) {
          self::json(array(
            'message' => 'Success update menu' 
          ));
        }
      }
    }
  }

  /**
   * Detail
   */
  public function detail($module = 1)
  {
    $id = $this->input->get('id', TRUE);
    $menu = $this->m_menu->detail_menu($id);
    $data = array(
      'menu' => [
        'id' => $menu['menu']->id,
        'name' => $menu['menu']->name,
        'child_name' => $menu['menu']->child_name,
        'icon' => $menu['menu']->icon,
        'link' => str_replace(base_url(), "@", $menu['menu']->link),
        'parent' => $menu['menu']->parent,
        'location' => $menu['menu']->location,
        'type' => $menu['menu']->type,
        'system' => $menu['menu']->system,
        'position' => $menu['menu']->position,
      ],
      'role' => $menu['role']
    );
    $response = [];
    $response['growl'] = 'success';
    $response['message'] = 'Your data have been saved.';
    $response['data'] = $data;
    self::json($response);
  }
  /**
  * Save menu position
  * @return Object
  */
  public function save_position($module = 1) {
    if (null !== $this->input->post('menus')) {
        $menus = json_decode($this->input->post('menus'), true);
        $this->m_menu->update_position(0, $menus);
    }
    $response = [];
    $response['growl'] = 'success';
    $response['message'] = 'Your data have been saved.';
    self::json($response);
  }

  public function convert($parent_id, $children)
  {
    $fill_data = array();
    $data = array();
		$i = 1;
		foreach ($children as $key => $value) {
			$id = $children[$key]['id'];
      $data = array_push($fill_data, [
        'id' => $id,
				'parent' => $parent_id,
				'position' => $i
      ]);
			//$this->db->where(self::$pk, $id)->update(self::$table, $fill_data);
			if (isset($children[$key]['child'][0])) {
        $data = array_merge($fill_data, $this->convert($id, $children[$key]['child']));
			}
			$i++;
    }
    return $fill_data;
  }

  public function get()
  {
  }

  public function menu_list($menu, $parent = 0)
  {
    $result = array();

		foreach($menu as $v) {
			if($v->parent == $parent) {
				$result[] = [
					'id' => $v->id,
          'name' => $v->name,
          'icon' => $v->icon,
          'link' => $v->link,
          'parent' => $v->parent,
          'type' => $v->type,
          'location' => $v->location,
          'system' => $v->system,
					'child' => $this->menu_list($menu, $v->id)
				];
			}
    }
    
    return $result;
  }

  public function menus($action = 1) {
    $menu = $this->db
    ->select('x1.*')
    ->where('x1.location', 'admin')
    ->order_by('x1.position', 'ASC')
    ->get('saga_menus x1')
    ->result();
    
    $result = $this->menu_list($menu);
    echo json_encode($result);
  }

  // public function draw_menu($arr, $parent = 0)
  // {
  //   $str = '';
  //   foreach($arr as $menu) {
  //     $name = $menu['parent'] == 0 ? $menu['name'] . ' (Label)' : $menu['name'];
  //     $str .= '<li class="dd-item dd3-item" data-id="'.$menu['id'].'" data-name="'.$menu['name'].'">';
  //     $str .= '<div class="dd-handle dd3-handle"></div>';
  //     $str .= '<div class="dd3-content"><span>'.$name.'</span><span class="pull-right"><span class="text-right text-primary" onclick="editdata('.$menu['id'].')"><i class="fa fa-edit"></i> </span> &nbsp;&nbsp;<span class="text-right text-danger"><i class="fa fa-trash"></i> </span></span>';
  //     $str .= '</div>';
  //     if(count($menu['child']) > 0) {
  //       $str .= '<ol class="dd-list">';
  //       $str .= $this->draw_menu($menu['child'], $menu['id']);
  //       $str .= '</ol>';
  //     }
  //     $str .= '</li>'; 
  //   }

  //   return $str;
  // }

  /**
   * Draw side menu
   */
  public function draw_header_menu($arr, $parent = 0)
  {
    $str = '';
    foreach($arr as $menu) {
      $str .= '<li class="dd-item" data-id="'.$menu['id'].'" data-name="'.$menu['name'].'">';
      $str .= $this->draw_menu($menu['child']);
      $str .= "</li>";
    }
    return $str;
  }  

  public function delete($action = 0) {
    $id = $this->input->get('id');
    $response = [];

    if($this->m_menu->delete_menu($id) == 1) {
      $response['growl'] = $id;
      $response['message'] = 'Your data have been saved.';
    } else {
      $response['growl'] = 'failed';
      $response['message'] = 'Your data failed deleted.';
    }

    $this->output
    ->set_content_type('application/json', 'utf-8')
    ->set_output(json_encode($response, JSON_PRETTY_PRINT))
    ->_display();
    exit; 
  }

  public function read($module = 0) {}
  
}