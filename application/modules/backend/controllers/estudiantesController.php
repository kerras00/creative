<?php

if( !defined('CREATIVE') ) die('Can not access from here');

class estudiantesController extends backendController {
	
	private $_filters = array( 
		'Todos'		=> 'all',
		'Cédula'	=> 'cedula',
		'Nombre'	=> 'name',
		'Apellido'	=> 'last_name',
		'Matrícula'	=> 'matricula_id',
		'Carrera'	=> 'carrera_id',
	);
	
	public function __construct() {
		parent::__construct();
		$this->no_cache();
		$this->view->template = 'template.back';
		$this->module = __CLASS__;
		$this->module_name = str_ireplace('controller', '',  __CLASS__);
		$this->model_module = $this->load_model($this->module_name);
		$this->model_carrera = $this->load_model('carreras');
	}
	
	
	/**
	* 
	* 
	* @return
	*/
	public function index() {
		
		$ds_carreras = Creative::get( 'Components' )
			->render('DataSource')
			->create('carreras_simplelist', array(
				'source'=> $this->model_carrera,
				'key'	=> 'id',
				'value'	=>'nombre'
			));
			
			
		$ModalRecord = Creative::get( 'Components' )->render('ModalRecord', array(
			'allow_save'		=> TRUE,
			'controller_delete'	=> '/api/v1/'.$this->module_name.'.json/',
			'controller_save' 	=> '/api/v1/'.$this->module_name.'.json/',
			'controller_load'	=> '/api/v1/'.$this->module_name.'.json/',
			'size' 				=> 'lg'
			,'text' => $this->module_name
		));
		
		
		//Cédula
		$ModalRecord->add_field(array(
			'col'	=> array('md'=>3),
			'id'	=> 'cedula',
			'type'	=> 'text',
			'label'	=> 'Cédula',
			'required'=> TRUE,
		));
		
		//Matrícula
		$ModalRecord->add_field(array(
			'col'	=> array('md'=>3),
			'id'	=> 'sexo',
			'type'	=> 'select',
			'label'	=> 'Matrícula',
			'items'	=> array(
				
			)
		));
		
		//Carrera
		$ModalRecord->add_field(array(
			'col'	=> array('md'=>3),
			'id'	=> 'carrera_id',
			'type'	=> 'select',
			'label'	=> 'Carrera',
			'datasource'=> $ds_carreras
		));
		
		//Estatus
		$ModalRecord->add_field(array(
			'col'	=> array('md'=>3),
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
		
		
		//Nombre
		$ModalRecord->add_field(array(
			'col'	=> array('md'=>3),
			'id'	=> 'nombre',
			'type'	=> 'text',
			'label'	=> 'Nombre',
			'required'=> TRUE,
		));
		
		//Apellido
		$ModalRecord->add_field(array(
			'col'	=> array('md'=>3),
			'id'	=> 'last_name',
			'type'	=> 'text',
			'label'	=> 'Apellido',
			'required'=> TRUE,
		));
		
		//Sexo
		$ModalRecord->add_field(array(
			'col'	=> array('md'=>3),
			'id'	=> 'sexo',
			'type'	=> 'select',
			'label'	=> 'Sexo',
			'items'	=> array(
				'-1' => 'Seleccione',
				'm' => 'Masculino',
				'f' => 'Femenido',
			)
		));
		
		
		
		
		//Fecha de Nac
		$ModalRecord->add_field(array(
			'col'	=> array('md'=>3),
			'id'	=> 'fecha_nac',
			'type'	=> 'date',
			'label'	=> 'Fecha de Nac.',
		));
		
		
		//E-mail
		$ModalRecord->add_field(array(
			'col'	=> array('md'=>3),
			'id'	=> 'email',
			'type'	=> 'email',
			'label'	=> 'E-mail',
		));
		
		
		//País
		$ModalRecord->add_field(array(
			'col'	=> array('md'=>3),
			'id'	=> 'pais',
			'type'	=> 'select',
			'label'	=> 'País',
			'items'	=> array(
				'-1' => 'Seleccione',
				'm' => 'Masculino',
				'f' => 'Femenido',
			)
		));
		
		//Estado
		$ModalRecord->add_field(array(
			'col'	=> array('md'=>3),
			'id'	=> 'estado',
			'type'	=> 'select',
			'label'	=> 'Estado',
			'items'	=> array()
		));
		
		//Ciudad
		$ModalRecord->add_field(array(
			'col'	=> array('md'=>3),
			'id'	=> 'ciudad',
			'type'	=> 'select',
			'label'	=> 'Ciudad',
			'items'	=> array()
		));
		
		//Ciudad
		$ModalRecord->add_field(array(
			'col'	=> array('md'=>3),
			'id'	=> 'municipio',
			'type'	=> 'text',
			'label'	=> 'Municipio',
			'items'	=> array()
		));
		
		//Parroquia
		$ModalRecord->add_field(array(
			'col'	=> array('md'=>3),
			'id'	=> 'parroquia',
			'type'	=> 'text',
			'label'	=> 'Parroquia',
			'items'	=> array()
		));
		
		//Dirección
		$ModalRecord->add_field(array(
			'col'	=> array('md'=>6),
			'id'	=> 'direccion',
			'type'	=> 'text',
			'label'	=> 'Dirección',
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
				'Cédula'		=> array(
					'field' 	=> 'cedula',
					'primary'	=> TRUE,
				),
				'Nombre'	=> array(
					'field' 	=> 'name',
					
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
		
		
		$this->add_btn_action_datatable('before', 
			array(			
				'color'=> 'success',
				'onclick' => "detalle_estudiante_handler(this)",
				'tooltip' => 'Prueba',
				'icon' => 'info-circle',
			)
		);
		
		$this->view->render('index', 'index');
	}
	
}

