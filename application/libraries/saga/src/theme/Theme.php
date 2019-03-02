<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Saga Dynamic CMS
 * @author Asep Yayat
 * @email asepmedia18@gmail.com
 * @version 0.0.1
 * @since 2018
 */
class Theme {
	/**
	* Define property
	*/
	static $current_theme = 'saga';	
	
	static $saga;

	static $title;

	static $role_args = array();
	/**
	 * __construct function
	 */
	public function __construct()
	{
		self::$saga =& get_instance();
	}
	
	/**
	 * convert function
	 *
	 * @return void
	 */
	public static function convert()
	{
		return ucfirst(self::$current_theme);
	}

	/**
	 * folder function
	 *
	 * @return void
	 */
	public static function folder()
	{
		return strtolower(self::$current_theme);
	}

	/**
	 * folder function
	 *
	 * @return void
	 */
	public static function view()
	{
		return strtolower('themes/' . self::$current_theme . '/');
	}

	/**
	 * switch function
	 *
	 * @param integer $switch
	 * @return void
	 */
	public static function switch($switch = 0)
	{
		if($switch != '') {
			self::$current_theme = $switch;
		}

		return new self();
	}

	/**
	 * asset function
	 *
	 * @return void
	 */
	public static function asset()
	{
		$path = base_url() . 'assets/themes/' . self::folder() .'/';
		return $path;
	}

	/**
	 * path function
	 *
	 * @return void
	 */
	public static function path()
	{
		$path = APPPATH . 'saga/themes/' . self::folder() . '/' . self::convert() . '_theme.php';
		return $path;
	}

	/**
	 * run function
	 *
	 * @param array $data
	 * @return void
	 */
	public static function run($data = array())
	{
		// if(in_array(32, explode(",","1,2,3")) != true) {
		// 	redirect(base_url('303'));
		// }
		$saga =& get_instance();
		$path_theme = 'themes/' . self::folder();

		if(!file_exists(APPPATH . 'views/' . $path_theme .'/' . $data['view'] . '.php')) {
			base_url('404');
		}

		self::$title = isset($data['title']) ? $data['title'] : 'Saga Dashboard';
		$saga->load->view($path_theme . '/index', $data);

		return new self();
	}

	/**
	 * partial function
	 *
	 * @param [type] $view
	 * @return void
	 */
	public static function partial($view )
	{
		$saga =& get_instance();
		$saga->load->view('themes/' . self::folder() . '/' . $view);
	}

	/**
	 * call function
	 *
	 * @return void
	 */
	public static function call()
	{
		$file =  self::convert() .'_theme';

		require_once self::path();

		$class = new $file;

		return $class;
	}

	/**
	 * title function
	 *
	 * @return void
	 */
	public static function title()
	{
		return self::$title;
	}

	/**
	 * Header function
	 *
	 * @return void
	 */
	public static function header()
	{
		$str = self::call()->css();
		$str .= self::call()->js();
		return $str;
	}

	/**
	 * css function
	 *
	 * @param [type] $css
	 * @return void
	 */
	public static function render_css($css)
	{
		$result = '';

    foreach($css as $v) {
      $result .= "\t" . '<link rel="stylesheet" href="'.base_url().'assets/themes/'. self::$current_theme . '/' .$v .'">' . PHP_EOL;
    }	
		
		return $result;
	}

	/**
	 * js function
	 *
	 * @param [type] $js
	 * @return void
	 */
	public static function render_js($js)
	{
		$result = '';
		
		foreach($js as $v) {
      $result .= "\t" .'<script src="'.base_url().'assets/themes/'. self::$current_theme . '/' . $v .'"></script>' . PHP_EOL;
		}		
		
		return $result;
	}

	/**
	 * Breadcrumbs
	 */
	public function breadcrumb($active = 'active')
	{
		$str = '';
		$data = explode("/", $this->uri->uri_string());
		foreach($data as $b) {
			$str .= '<li class="'.($b == end($data) ? $active : "").'">'.ucfirst($b).'</li>';
		}
		
		return $str;
	}
	
	public function withRole($role = 0)
	{
		$this->saga->run('role')->module($role);
	}

  public function role($role = 0)
  {
    $this->saga->run('role')->module($role);
  }

  public static function with($args = 0)
  {
    self::$role_args = $args;
    return new self();
	}	

	/**
   * Undocumented function
   *
   * @param [type] $object
   * @return void
   */
  function load($object) {
    $this->$object = load_class(ucfirst($object));
  }

  /**
   * Undocumented function
   *
   * @param [type] $var
   * @return void
   */
  function __get($var) {
      global $CI;
      return $CI->$var;
  } 	
}
