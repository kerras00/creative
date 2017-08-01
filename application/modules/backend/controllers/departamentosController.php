<?php

if( !defined('CREATIVE') ) die('Can not access from here');

class departamentosController extends backendController {
	
	private $_filters = array( 
		'Todos'		=> 'all',
		'Código'	=> 'codigo',
		'Nombre'	=> 'nombre',
	);
	
	
	public function __construct() {
		parent::__construct();
		$this->no_cache();
		$this->view->template = 'template.back';
		$this->module = __CLASS__;
		$this->module_name = str_ireplace('controller', '',  __CLASS__);		
		$this->model_module = $this->load_model($this->module_name);
	}
	
	
	/**
	* 
	* 
	* @return
	*/
	public function index() {
		
		$ds_materias = Creative::get( 'Components' )
			->render('DataSource')
			->create('materias_simplelist', array(
				'source'=> 'materias',
				'key'	=> 'id',
				'value'	=>'nombre'
			));
			
			
		$ModalRecord = Creative::get( 'Components' )->render('ModalRecord', array(
			'allow_save'		=> TRUE,
			'controller_delete'	=> '/api/v1/'.$this->module_name.'.json/',
			'controller_save' 	=> '/api/v1/'.$this->module_name.'.json/',
			'controller_load'	=> '/api/v1/'.$this->module_name.'.json/',
			'size' 				=> 'sm'
			,'text' => $this->module_name
		));
		
		
		
		
		//Nombre
		$ModalRecord->add_field(array(
			'col'	=> array('md'=>12),
			'id'	=> 'nombre',
			'type'	=> 'text',
			'label'	=> 'Nombre',
			'required'=> TRUE,
		));
		
		//Estatus
		$ModalRecord->add_field(array(
			'col'	=> array('md'=>12),
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
		
		
		//Escribe el componente
		$ModalRecord->write();
		
		
		$this->view->assign('data'	, $this->model_module->all(array(
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
		
		$this->view->assign('title'		, ucfirst($this->module_name) ); //Título de la Vista
		$this->view->assign('module'	, $this->module_name ); //Título de la Vista
		$this->view->assign('filters'	, $this->_filters);
		
		//Prepara la tabla
		$this->view->assign('table', array(
			'columns'		=> array(
				'Nombre'	=> array(
					'field' 	=> 'nombre',
				),
				'Encargado'	=> array(
					'field' 	=> 'users_id',					
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
		
		$this->view->render( __FUNCTION__ , 'index');
	}

}