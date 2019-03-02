<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Role_module extends Module {
  
  public function __construct()
  {
    $this->load->model('module/m_role', 'role');
    $this->withRole();
  }
  
  /**
   * Role Menu
   */
  public function management($module = 0) {
    $context['view'] = 'modules/role/management';
    $this->saga->theme->run($context);
  }

  /**
   * Role Module
   */
  public function module($module = 0) {
    $context['view'] = 'modules/role/module';
    $this->saga->theme->run($context);	
  }

  /**
   * Role Menu
   */
  public function menu($module = 0) {
    $context['view'] = 'modules/role/module';
    $this->saga->theme->run($context);
  }
  
  public function role_list($module = 0)
  {
    $query = $this->input->get('q', TRUE);
    $role = $this->role->role_list($query);
    self::json(array(
      'results' => $role
    ));
  }
  /**
   * Role Module
   */
  public function action_list($module = 0) {
    $module = $this->input->get('module') ?? 'role';
    $data = $this->role->module_action($module);
    self::json(array(
      'data' => $data
    ));
  }

  public function update_role_module($module = 0)
  {
    $id = $this->input->post('id', TRUE);

    $role = $this->input->post('role', TRUE);
    
    if(count($role) >= 0) {
      if($this->role->update_role($role, $id)) {
        self::json(
          array(
            'status' => 1,
            'message' => 'Success update role'
          )
        );
      }
    }    
  }

  public function add_role_action_module($module = 0)
  {
    $data = array(
      'module_name' => $this->input->post('module_name'),
      'module_child_name' => $this->input->post('module_child_name'),
      'module_type' => 'module'
    );

    $role = $this->input->post('role', TRUE);

    if(count($role) > 0) {
      if($this->db->insert('saga_modules', $data)) {
        $module = $this->db->insert_id();
  
        if($this->role->create_role($role, $module)) {
          self::json(array(
            'message' => 'Success add module' 
          ));
        }
      }
    }   
  }  
}