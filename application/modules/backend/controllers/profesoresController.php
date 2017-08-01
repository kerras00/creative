<?php

if( !defined('CREATIVE') ) die('Can not access from here');

class profesoresController extends backendController {
	
	private $_filters = array( 
		'Todos'		=> 'all',
		'Cedula'	=> 'cedula',
		'Nombre'	=> 'profesor_nombre',
		'Sede'		=> 'sede_id',
		'Estado'	=> 'estado',
		'Ciudad'	=> 'ciudad',
		'Parroquia'	=> 'parroquia',
	);
	
	
	public function __construct() {
		parent::__construct();
		$this->no_cache();
		$this->view->template = 'template.back';
		$this->module = __CLASS__;
		$this->module_name = str_ireplace('controller', '',  __CLASS__);
		$this->model_module_view = $this->load_model('view_' . $this->module_name);
		$this->model_module = $this->load_model($this->module_name);
	}
	
	
	/**
	* 
	* 
	* @return
	*/
	public function index() {
		
		$ds_sedes = Creative::get( 'Components' )
			->render('DataSource')
			->create('carreras_simplelist', array(
				'source'=> 'sedes',
				'key'	=> 'id',
				'value'	=>'nombre'
			));
			
		//Crear Modal
		$ModalRecord = Creative::get( 'Components' )->render('ModalRecord', array(
			'allow_save'		=> TRUE,
			'controller_delete'	=> '/api/v1/'.$this->module_name.'.json/',
			'controller_save' 	=> '/api/v1/'.$this->module_name.'.json/',
			'controller_load'	=> '/api/v1/'.$this->module_name.'.json/',
			'size' 				=> 'lg'
			,'text' => $this->module_name
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
		
		
		//Cédula
		$ModalRecord->add_field(array(
			'col'	=> array('md'=>3),
			'id'	=> 'cedula',
			'type'	=> 'text',
			'label'	=> 'Cédula',
			'required'=> TRUE,
		));
		
		
		//Nombre
		$ModalRecord->add_field(array(
			'col'	=> array('md'=>3),
			'id'	=> 'name',
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
		
		//Email
		$ModalRecord->add_field(array(
			'col'	=> array('md'=>3),
			'id'	=> 'email',
			'type'	=> 'email',
			'label'	=> 'Email',
		));
		
		
		//Tel. Móvil
		$ModalRecord->add_field(array(
			'col'	=> array('md'=>3),
			'id'	=> 'tel_movil',
			'type'	=> 'tel',
			'label'	=> 'Tel. Móvil',
		));
		
		//Tel. Habitación
		$ModalRecord->add_field(array(
			'col'	=> array('md'=>3),
			'id'	=> 'tel_habitacion',
			'type'	=> 'tel',
			'label'	=> 'Tel. Habitación',
		));
		
	
		
		
		//Estado
		$ModalRecord->add_field(array(
			'col'	=> array('md'=>3),
			'id'	=> 'estado',
			'type'	=> 'text',
			'label'	=> 'Estado',
		));
		
		//Ciudad
		$ModalRecord->add_field(array(
			'col'	=> array('md'=>3),
			'id'	=> 'ciudad',
			'type'	=> 'text',
			'label'	=> 'Ciudad',
		));
		
		//Parroquia
		$ModalRecord->add_field(array(
			'col'	=> array('md'=>3),
			'id'	=> 'parroquia',
			'type'	=> 'text',
			'label'	=> 'Parroquia',
		));
		
		//Dirección
		$ModalRecord->add_field(array(
			'col'	=> array('md'=>6),
			'id'	=> 'direccion',
			'type'	=> 'text',
			'label'	=> 'Direccion de habitación',
		));
		
		//Nivel de profesión
		$ModalRecord->add_field(array(
			'col'	=> array('md'=>3),
			'id'	=> 'sede_id',
			'type'	=> 'select',
			'label'	=> 'Sede',
			'required'=> TRUE,
			'datasource'	=> $ds_sedes
		));
		
		
		
		//Nivel de profesión
		$ModalRecord->add_field(array(
			'col'	=> array('md'=>3),
			'id'	=> 'nivel_profesion',
			'type'	=> 'select',
			'label'	=> 'Nivel de profesión',
			'required'=> TRUE,
			'items'	=> array(
				'-1' => 'Seleccione',
				'1' => 'Técnico medio',
				'2' => 'TSU',
				'3' => 'Superior universitario',
				'4' => 'Postgrado',
				'5' => 'Magister',
				'6' => 'Doctorado',
				'7' => 'Post Doctorado',
			)
		));
		
		//Área Profesional
		$ModalRecord->add_field(array(
			'col'	=> array('md'=>6),
			'id'	=> 'area_profesional',
			'type'	=> 'select',
			'label'	=> 'Área Profesional',
			'multiple'=>TRUE,
			'required'=> TRUE,
			'items'	=> array(
				'1' => 'Licenciatura',
				'1' => 'Ingeniería',
				'2' => 'Arquitectura',
				'3' => 'Veterinaria',
				'4' => 'Medicina',
			)
		));
		
		
		
		//Escribe el componente
		$ModalRecord->write();
		
		$data = $this->model_module_view->all();
		$this->view->assign('data'	, $data);
		
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
					'field' 	=> 'profesor_nombre',
				),	
				'Sede'	=> array(
					'field' 	=> 'sede_nombre',
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
				
		
		$this->view->render('index', 'index');
	}
	
}

