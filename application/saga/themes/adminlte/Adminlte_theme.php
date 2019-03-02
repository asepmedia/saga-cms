<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @name Si_cms Core
 * @author Asep Yayat
 * @version v.0.0.1
 * @since 2018
 * @email asepmedia18@gmail.com
 */

 class Adminlte_theme extends Theme
 {

  /**
   * Css List
   */
  public function css()
  {
    $result = '';

    $css = array(
      'bower_components/bootstrap/dist/css/bootstrap.min.css',
      'bower_components/select2/dist/css/select2.min.css',
      // 'bower_components/font-awesome/css/font-awesome.min.css',
      'plugins/fontawesome-5/css/all.min.css',
      'bower_components/Ionicons/css/ionicons.min.css',
      'dist/css/AdminLTE.min.css',
      'dist/css/skins/_all-skins.min.css',
      // 'bower_components/morris.js/morris.css',
      // 'bower_components/jvectormap/jquery-jvectormap.css',
      // 'bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css',
      // 'bower_components/bootstrap-daterangepicker/daterangepicker.css',
      // 'plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css'
    );
    
    $result = self::render_css($css);

    return $result;
  }

  /**
   *  list
   */
  public function js()
  {
    $js = array(
      'bower_components/jquery/dist/jquery.min.js',
      'bower_components/jquery-ui/jquery-ui.min.js',
      'bower_components/bootstrap/dist/js/bootstrap.min.js',
      'bower_components/select2/dist/js/select2.full.min.js',
      // 'bower_components/raphael/raphael.min.js',
      // 'bower_components/morris.js/morris.min.js',
      // 'bower_components/jquery-sparkline/dist/jquery.sparkline.min.js',
      // 'plugins/jvectormap/jquery-jvectormap-1.2.2.min.js',
      // 'plugins/jvectormap/jquery-jvectormap-world-mill-en.js',
      // 'bower_components/jquery-knob/dist/jquery.knob.min.js',
      // 'bower_components/moment/min/moment.min.js',
      // 'bower_components/bootstrap-daterangepicker/daterangepicker.js',
      // 'bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js',
      // 'plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js',
      // 'bower_components/jquery-slimscroll/jquery.slimscroll.min.js',
      // 'bower_components/fastclick/lib/fastclick.js',
       'dist/js/adminlte.min.js',
      // 'dist/js/pages/dashboard.js',
      // 'dist/js/demo.js'
    );

    $result = self::render_js($js);

    return $result;
  } 

   /**
   * Draw side menu
   */
  public function draw_side_menu($arr, $parent = 0)
  {
    $str = '';
    foreach($arr as $menu) {
      $class = count($menu['child']) ? "treeview " : "";
      $str .= '<li class="'.$class.'">';
      $str .= '<a href="'.$menu['link'].'"><i class="'.$menu['icon'].'"></i> ';
      $str .= '<span>'.$menu['name'].'</span>';
      if(count($menu['child']) > 0){
        $str .= '<span class="pull-right-container">';
        $str .= '<i class="fas fa-angle-left pull-right"></i>';
        $str .= '</span>';
      }
      $str .= "</a>";
      if(count($menu['child']) > 0) {
        $str .= '<ul class="treeview-menu">';
        $str .= $this->draw_side_menu($menu['child'], $menu['id']);
        $str .= '</ul>';
      }
      $str .= '</li>';
    }
    return $str;
  }  

   /**
   * Draw side menu
   */
  public function draw_side_menu_header($arr, $parent = 0)
  {
    $str = '';
    foreach($arr as $menu) {
      $str .= '<li class="header">';
      $str .= $menu['name'];
      $str .= "</li>";
      $str .= $this->draw_side_menu($menu['child']);
    }
    return $str;
  }  

  /**
   * list menu from database
   */
	public function menu_list($menu, $parent = 0, $module = 0)
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
					'child' => $this->menu_list($menu, $v->id, $module)
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
    self::$saga->load->model('module/m_menu', 'm_menu');
    $list = self::$saga->m_menu->side_menu();
    return $this->draw_side_menu_header($list);
  }
  
 }