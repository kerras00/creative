<?php

/**
 * ------------------------------------------------------------------------
 * Class Managerment Controller
 * ------------------------------------------------------------------------
 * Provides an interface to manage system users of both the Backend and 
 * Frontend, user profiles, Lists of access controls to your application
 * 
 * 
 * Provee de una interfaz para gestionar usuarios del sistema tanto del 
 * Backend como del Frontend, perfiles de usuarios, Listas de controles 
 * de acceso a su aplicación * 
 * 
 * @copyright   © 2017 Brayan Rincon
 * @version     1.0.2
 * @author      Brayan Rincon <brayan262@gmail.com>
 */
class managementController extends backendController {
	
	private $_filters = array( 
		'Todos'		=> 'all',
		'Nombre'	=> 'name',
		'Módulo de inicio'	=> 'default_module',
	);
	
	private $_actions = array(
		'aprobar-transferencias'	=> 'Aprobar transferencias de dinero',
		'pagar-transferencias'		=> 'Pagar transferencias de dinero',
		'verficar-transferencias'	=> 'Verficar Transferencia pagada',
		'enviar-confirmacion'		=> 'Enviar confirmación de pago',
	);
	
	public function __construct() {
		parent::__construct();
		$this->no_cache();
		//$this->view->template = 'template.back';
		//$this->module = __CLASS__;
		$this->module_name = str_ireplace('controller', '',  __CLASS__);		
		$this->model_profiles = $this->load_model('profiles');
		
		$this->_fields_db = $this->database();
		
	}
	
	public function index(){
		
	}
	

	/**
	 * ------------------------------------------------------------------------
	 * Class Managerment Controller
	 * ------------------------------------------------------------------------
	 * Provides an interface to manage system users of both the Backend and 
	 * Frontend, user profiles, Lists of access controls to your application
	 * 
	 * 
	 * Provee de una interfaz para gestionar usuarios del sistema tanto del 
	 * Backend como del Frontend, perfiles de usuarios, Listas de controles 
	 * de acceso a su aplicación * 
	 * 
	 * @copyright   © 2017 Brayan Rincon
	 * @version     1.0.2
	 * @author      Brayan Rincon <brayan262@gmail.com>
	 */
	public function users() {

		$this->model = $this->load_model('users');
		$this->model_profiles = $this->load_model('profiles');
		
		$ModalRecord = Creative::get( 'Components' )->render('ModalRecord', array(
			//'allow_save'		=> TRUE,
			//'controller_delete'	=> '/api/v1/'.$this->module_name.'.json/',
			//'controller_save' 	=> '/api/v1/'.$this->module_name.'.json/',
			//'controller_load'	=> '/api/v1/'.$this->module_name.'.json/',
			 'size' 	=> 'lg'
			,'text'		=> Lang::get('dashboard.users')
		));
		
		//Nombre
		$ModalRecord->add_field(array(
			'col'	=> array('sm'=>6,'md'=>3),
			'id'	=> 'name',
			'type'	=> 'text',
			'label'	=> l('personal_attr.name'),
			'required'=> TRUE,
		));
		
		//Apellido
		$ModalRecord->add_field(array(
			'col'	=> array('sm'=>6,'md'=>3),
			'id'	=> 'last_name',
			'type'	=> 'text',
			'label'	=> l('personal_attr.last_name'),
			'required'=> TRUE,
		));
		
		
		//Email
		$ModalRecord->add_field(array(
			'col'	=> array('sm'=>6,'md'=>3),
			'id'	=> 'email',
			'type'	=> 'text',
			'label'	=> l('personal_attr.email'),
			'required'=> TRUE,
		));
		
		$perfil = [];
		foreach ($this->model_profiles->all() as $key => $value) {
			$perfil[$value['id']] = $value['name'];
		}
		//Perfil
		$ModalRecord->add_field(array(
			'col'	=> array('sm'=>6,'md'=>3),
			'id'	=> 'profile_id',
			'type'	=> 'select',
			'label'	=> l('personal_attr.profile'),
			'items'	=>  $perfil,
			'required'=> TRUE,
		));
		
		//pass
		$ModalRecord->add_field(array(
			'col'	=> array('sm'=>6,'md'=>3),
			'id'	=> 'pass1',
			'type'	=> 'password',
			'label'	=> l('personal_attr.pass'),
			//'required'=> TRUE,
		));
		
		//pass
		$ModalRecord->add_field(array(
			'col'	=> array('sm'=>6,'md'=>3),
			'id'	=> 'pass2',
			'type'	=> 'password',
			'label'	=> l('personal_attr.repeat_pass'),
			//'required'=> TRUE,
		));
		
		//Alias
		$ModalRecord->add_field(array(
			'col'	=> array('sm'=>6,'md'=>3),
			'id'	=> 'nicname',
			'type'	=> 'text',
			'label'	=> l('personal_attr.alias'),
		));
		
		
		
		
		//Estatus
		$ModalRecord->add_field(array(
			'col'	=> array('sm'=>6,'md'=>3),
			'id'	=> 'status',
			'type'	=> 'select',
			'label'	=> l('personal_attr.status'),			
			'required'=> TRUE,
			'items'	=> array(
				'-1' => l('selection'),
				'1' => l('user_status.active'),
				'0' => l('user_status.inactive'),
			)
		));
		
		
		$source = $this->get_source_view( 'permissions', 'management', 'backend');
		$ModalRecord->add_field(array(
			'col'	=> array('sm'=>12),
			'type'	=> 'source',
			'source'=> $source,
		));
		
		
		//Escribe el componente
		$ModalRecord->write();
		
		
		$this->view->assign('data', $this->model->all(array(
			"user_decp" =>
				"CONCAT(name, ' ', last_name)",
			"status_text" =>
				"CASE 
					WHEN status = 0 THEN 'Inactiva' 
					WHEN status = 1 THEN 'Activa' 
				END",
			"status_class" =>
				"CASE 
					WHEN status = 0 THEN 'danger' 
					WHEN status = 1 THEN 'success' 
				END",
			"status_info" => 
				"CASE 
					WHEN status = 0 THEN 'Carrera inactiva' 
					WHEN status = 1 THEN 'Carrera activa' 
				END",
			)
		)
		);
		$this->view->assign('title'		, Lang::get('dashboard.users') ); //Título de la Vista
		$this->view->assign('module'	, $this->module_name ); //Título de la Vista
		$this->view->assign('filters'	, Registry::get('management')['module']['users']['filters']);
		$this->view->assign('fields_db'	, $this->_fields_db);
		
		//$fields = $this->database();
		//$this->view->assign('fields'	, $fields);
		
		//Prepara la tabla
		$this->view->assign('table', array(
			'columns'		=> array(
				'user_decp'	=> array(
					'label' 	=> l('personal_attr.name'),
					'primary'	=> TRUE,
				),
				'email'	=> array(
					'label' 	=> l('personal_attr.email'),
				),
				'status_text'	=> array(
					'label' => l('personal_attr.status'),
					'align' => 'center',
					'type'	=> 'label',
					'labelclass' => 'status_class',
					'tooltips' => 'status_info',								
				),
			), //Indica las columnas que se mostrarán
			
			'view'		=> TRUE, //Indica si se mostrará la columna de Visualizar
			'edit'		=> TRUE, //Indica si se mostrará la columna de Editar
			'delete'	=> TRUE  //Indica si se mostrará la columna de Eliminar
		));
		
		$this->view->assign('btn_add', TRUE);				//Indica si se mostrará el botón de Agregar
		$this->view->assign('btn_add_text', TRUE);			//Indica si se mostrará el texto del botón Agregar
		$this->view->assign('btn_print', TRUE);				//Indica si se mostrará el botón de Imprimir
		$this->view->assign('btn_shared', FALSE);			//Indica si se mostrará el botón de Compartir
		$this->view->assign('btn_search_avanced', TRUE);	//Indica si se mostrará el botón de Busqueda Avanzada
		$this->view->assign('search', TRUE);				//Indica si se mostrará las Opciones de busqueda
				
		$this->view->template ( 'default' );        
        $this->view->theme( BACKEND );

		$this->view->render(__FUNCTION__, 'index');
	}
	
	


	/**
	* 
	* 
	* @return
	*/
	public function profiles() {
		
		$this->module = __FUNCTION__;
		$this->module_name = str_ireplace('controller', '',  __FUNCTION__);
		$this->module_title = 'Perfiles';
		$this->model_profiles = $this->load_model($this->module_name);
		
		$ModalRecord = Creative::get( 'Components' )->render('ModalRecord', array(
			//'allow_save'		=> TRUE,
			//'controller_delete'	=> '/api/v1/'.$this->module_name.'.json/',
			//'controller_save' 	=> '/api/v1/'.$this->module_name.'.json/',
			//'controller_load'	=> '/api/v1/'.$this->module_name.'.json/',
			 'size' 	=> 'lg'
			,'text'		=> 'Perfiles'
		));
		
		
		
		//Nombre
		$ModalRecord->add_field(array(
			'col'	=> array('md'=>8),
			'id'	=> 'name',
			'type'	=> 'text',
			'label'	=> 'Nombre',
			'required'=> TRUE,
		));
		
		
		//Modulo por defecto
		$menu = [];
		foreach( Creative::get( 'Menus' )->get_menu() as $key => $value){
			$menu[$value['table']] = $value['title'];
		}
		
		$ModalRecord->add_field(array(
			'col'	=> array('md'=>4),
			'id'	=> 'default_module',
			'type'	=> 'select',
			'default'	=> 'inicio',
			'label'	=> 'Módulo por defecto',
			'items'	=>  $menu,
			'required'=> TRUE,
		));
		
				
		//Descripción
		$ModalRecord->add_field(array(
			'col'	=> array('md'=>8),
			'id'	=> 'description',
			'type'	=> 'text',
			'label'	=> 'Descripción',
		));
		
		//Estatus
		$ModalRecord->add_field(array(
			'col'	=> array('md'=>4),
			'id'	=> 'status',
			'type'	=> 'select',
			'label'	=> 'Estatus',
			'required'=> TRUE,
			'items'	=> array(
				'-1' => 'Seleccione',
				'1' => 'Activo',
				'0' => 'Inactiva',
			)
		));
		
		
		$source = $this->get_source_view( 'permissions', 'management', 'backend');
		$ModalRecord->add_field(array(
			'col'	=> array('md'=>12),
			'type'	=> 'source',
			'source'=> $source,
		));
		
		
		//Escribe el componente
		$ModalRecord->write();
		
		
		$this->view->assign('data'	, $this->model_profiles->all(array(
			"status_text" =>
				"CASE 
					WHEN status = 0 THEN 'Inactiva' 
					WHEN status = 1 THEN 'Activa' 
				END",
			"status_class" =>
				"CASE 
					WHEN status = 0 THEN 'danger' 
					WHEN status = 1 THEN 'success' 
				END",
			"status_info" => 
				"CASE 
					WHEN status = 0 THEN 'Carrera inactiva' 
					WHEN status = 1 THEN 'Carrera activa' 
				END",
			)
		));
		
		$this->view->assign('title'		, ucfirst($this->module_title) ); //Título de la Vista
		$this->view->assign('module'	, $this->module_name ); //Título de la Vista
		$this->view->assign('filters'	, $this->_filters);
		$this->view->assign('fields_db'	, $this->_fields_db);
		
		//$fields = $this->database();
		//$this->view->assign('fields'	, $fields);
		
		//Prepara la tabla
		$this->view->assign('table', array(
			'columns'		=> array(
				'Nombre'	=> array(
					'field' 	=> 'name',
					'primary'	=> TRUE,
				),	
				'Estatus'	=> array(
					'field' => 'status_text',
					'align' => 'center',
					'type'	=> 'label',					
					'class' => 'status_class',
					'tooltips' => 'status_info'
				),
			), //Indica las columnas que se mostrarán
			
			'view'		=> TRUE, //Indica si se mostrará la columna de Visualizar
			'edit'		=> TRUE, //Indica si se mostrará la columna de Editar
			'delete'	=> TRUE  //Indica si se mostrará la columna de Eliminar
		));
		
		$this->view->assign('btn_add', TRUE);				//Indica si se mostrará el botón de Agregar
		$this->view->assign('btn_add_text', TRUE);			//Indica si se mostrará el texto del botón Agregar
		$this->view->assign('btn_print', TRUE);				//Indica si se mostrará el botón de Imprimir
		$this->view->assign('btn_shared', FALSE);			//Indica si se mostrará el botón de Compartir
		$this->view->assign('btn_search_avanced', TRUE);	//Indica si se mostrará el botón de Busqueda Avanzada
		$this->view->assign('search', TRUE);				//Indica si se mostrará las Opciones de busqueda
				
		
		$this->view->render(__FUNCTION__, 'index');
	}
	

	
	private function database(){
		
		$this->model_generic = $this->load_model('profiles');
		$data_db = $this->model_generic->exec('SHOW TABLES FROM '. DB_DATABASE);
		
		foreach( $data_db as $key => $value){
			$tables[] = $value['Tables_in_'.DB_DATABASE];
		}
		
		
		foreach( $tables as $key => $tabla){
			if( $tabla == 'configuration' OR
				$tabla == 'fields' OR
				$tabla == 'pages' OR
				$tabla == 'pages_meta' OR
				$tabla == 'profiles' OR
				$tabla == 'profiles_permissions' OR
				$tabla == 'sessions' OR
				$tabla == 'users' OR
				strpos($tabla, 'view_') !== FALSE OR
				$tabla == 'users_meta'){
				continue ;
			}
			$col = [];
			foreach( $this->model_generic->exec('SHOW COLUMNS FROM '. $tabla ) as $row => $attr){
				$col[$row] = $attr;
				$col[$row]['label'] = $this->replace_field($attr['Field']);
				$col[$row]['info'] = '';
			}
			$estrucura[$tabla] = $col; ;
		}
		
		return $estrucura;
		
		$structure_db = [];
		$str = "\$structure = array (\n";
		
		$_table = "
			array(
				'table' => '',
				'fields' => array(
					array('field' => '','description' => ''),
				)
			),";
		
		
		foreach( $data_db as $key => $value){
			$data_colums = $this->model_generic->exec('SHOW COLUMNS FROM '. $value['Tables_in_'.DB_DATABASE]);
			$structure_db[$value['Tables_in_'.DB_DATABASE]] = array(
				'field'			=> $value['Tables_in_'.DB_DATABASE],
				'description'	=> '',
				'columns' 		=> $data_colums,
			);
			
			/*
			$str .= "\tarray(\n";
			$str .= "\t\t'table' => '".$value['Tables_in_'.DB_DATABASE]."',\n";
			$str .= "\t\t'description' => '',\n";
			$str .= "\t\t'fields' => array(\n";
			 $str .= "\t\t\tarray(\n";
			 $str .= "\t\t\tarray(\n'field' => ''\n";
			 $str .= "\t\t\t'description' => ''\n";
			$str .= "\t\t\t),\n";
			$str .= "\t\t)\n";
			$str .= "\t),\n";	*/		
		}
		
		$str .= "array('','')";
		return $structure_db;
		
		$structure = array (
			'table' => array(
				array('field' => '','description' => ''),
			),
		);
	}
	
	
	private function replace_field( $text ){
		$patrones = array(
			'status'=>'Estatus',
			'user'=>'Usuario',
			'cion'=>'ción',
			'_id'=>'',
			'_'=>' ',
		);
		
		foreach($patrones as $key => $value){
			$p[] = $key;
			$r[] = $value;
		}
		
		return str_ireplace($p, $r, $text);
	}
	
}

