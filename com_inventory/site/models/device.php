<?php defined( '_JEXEC' ) or die( 'Restricted access' ); 

/**
 * @package     it+kapfenberg
 * @subpackage  com_inventory
 *
 * @copyright   Copyright (C) 2013 Mathias Knoll All rights reserved.
 * @license     GNU AFFERO GENERAL PUBLIC LICENSE Version 3; see LICENSE.txt
 */

class InventoryModelsDevice extends InventoryModelsDefault{

	var $nameDeviceId 		= 'id';
	var $nameLentUserId 	= 'lentuserid';
	var $nameOrgUnit		= 'menu_orgunitid';
	var $nameStatusAvailable= 'statusAvailable';
	var $nameStatusLent		= 'statusLent';
	var $nameQrcode			= 'qrcode';
	var $nameNameOrder		= 'nameOrder';
	var $namePageNumber		= 'pageNumber';

	var $_has_device_id		= false;
	var $_device_id     	= null;
	
	var $_has_lent_user_id 	= false;
	var $_lent_user_id     	= null;
	
	var $_has_orgunit 		= false;
	var $_orgunit_id 		= null;
	var $_orgunit 			= null;
	
	var $_has_status_available	= true;
	var $_status_available 		= 'Available';
	
	var $_has_status_lent	= true;
	var $_status_lent 		= 'Lent';
	
	var $_has_qrcode		= false;
	var $_qrcode     		= null;

	var $_has_tags			= false;
	var $_selectionTag   	= null;	
	var $_selectionTags   	= array();
	
	var $_has_name_order	= false;
	var $_name_order		= null;
	
	var $_has_page_number	= false;
	var $_page_number		= null;
	
	var $_orgunitlist   	= array();
	

	function __construct(){
		$this->_app 				= JFactory::getApplication();	
		$this->_has_device_id 		= $this->getDeviceId();
		$this->_has_lent_user_id 	= $this->getLentUserId();
		$this->_has_orgunit		 	= $this->getOrgUnit();
		$this->_has_status_available= $this->getStatusAvailable();
		$this->_has_status_lent		= $this->getStatusLent();
		$this->_has_tags		 	= $this->getTags();
		$this->_has_page_number		= $this->getPageNumber();
		$this->_has_name_order	 	= $this->getNameOrder();
		$this->_orgunitlist			= $this->getOrgUnitList();
		
		if(!$this->_has_status_available && !$this->_has_status_lent){
			$this->_has_status_available	= true;
			$this->_status_available 		= 'Available';
			$this->_has_status_lent			= true;
			$this->_status_lent 			= 'Lent';
		}
		
		parent::__construct();       
	}
	
	private function getOrgUnitList(){
		$db = JFactory::getDBO();
		$query = $db->getQuery(TRUE);
		$query->select('o.orgunit_id, o.name, o.shortdescription');
		$query->from('#__inventory_orgunits as o');
		$query->order('o.name ASC');
		$db->setQuery($query);
		return $db->loadObjectList();
	}
 
	public function store($data=null){    
		$data = $data ? $data : JRequest::get('post');
		$dataText   = $data['qrcode'];
		$saveToFile = false;
		$svgCode = QRcode::svg($dataText, $saveToFile, QR_ECLEVEL_L, 3,1,false, 0xFFFFFF,0x000000); 
		$data['qrcodesvg'] = $svgCode;
		return parent::store($data);
	}

	public function lend($data=null){
		$data = isset($data) ? $data : JRequest::get('post');
		$date = date("Y-m-d H:i:s");
		if (isset($data['lend']) && isset($data['lent_user_id']) && $data['lend']==1)
		{
			
			$data['lent'] = 1;
			$data['lent_date'] = $date;	
			
			$history['device_id'] = $data['device_id'];
			$history['lent_user_id'] = $data['lent_user_id'];
			$history['shortdescription'] = $data['lent_description'];
			$history['lent_start_date'] = $data['lent_date'];
			
			$this->storeHistoryEntry($history);
			
		} else {
			if(!empty($data['lent_user_id']) && !empty($data['device_id']) && !empty($data['lent_date'])){
				$history = $this->getHistoryEntry($data['device_id'], $data['lent_user_id'], $data['lent_date']);
				if(!empty($history)){
					$history->lent_end_date = $date;
					$this->storeHistoryEntry($history);
				}
			}
			
			$data['lent'] = 0;
			$data['lent_date'] = NULL;
			$data['lent_user_id'] = NULL;
			$data['lent_description'] = NULL;
			
		}
		$row = parent::store($data);   
		return $row;
	}
	
	private function getHistoryEntry($device_id, $Lent_user_id, $date){
		$db = JFactory::getDBO();
		$dateJoomla = JFactory::getDate($date);
		$query = $db->getQuery(TRUE);
		$query->select('h.history_id, h.device_id, h.lent_user_id, h.shortdescription, h.lent_start_date, h.lent_end_date');
		$query->from('#__inventory_history as h');
		$query->where('h.device_id='.$device_id);
		$query->where('h.lent_user_id='.$Lent_user_id);
		$query->where('h.lent_start_date="'.$dateJoomla->toSql().'"');
		$db->setQuery($query);
		return $db->loadObject();
	}
	
	private function storeHistoryEntry($history){
		if(empty($history)){
			return false;
		}
		$row = JTable::getInstance('history','Table');
		if (!$row->bind($history))
			return false;
		if (!$row->check())
			return false;
		if (!$row->store())
			return false;
			
		return $row;
	}
	
	public function deactivate($id = null, $active = true){
		$isOK = false;
		$id   = $id ? $id : $this->_app->input->get('device_id');
		$device = JTable::getInstance('Device','Table');
		$device->load($id);
		if($device->device_id){
			$device->active = ($active)?0:1;
			$isOK = $device->store();
		}
		return $isOK;
	}

	public function delete($id=null){
		$id   = $id ? $id : $this->_app->input->get('device_id');
		$device = JTable::getInstance('Device','Table');
		$device->load($id);
		if($device->delete()) 
		{
			return true;
		} else {
			return false;
		}
	} 

	protected function _buildQuery(){
		$db = JFactory::getDBO();
		$query = $db->getQuery(TRUE);
		$query->select(
			'b.device_id, 
			 b.devicename, 
			 b.snumber, 
			 b.shortdescription, 
			 b.description, 
			 b.location, 
			 b.orgunit_id, 
			 b.imageurl, 
			 b.qrcode, 
			 b.qrcodesvg, 
			 b.tags, 
			 b.lent_user_id, 
			 b.lent_description, 
			 b.lent, 
			 b.lent_date, 
			 b.lent_due_date,
			 b.locked,
			 b.active,
			 b.created,
			 b.modified'
		);
		$query->from('#__inventory_devices as b');
		$query->select('o.name as orgunit');
		$query->leftjoin('#__inventory_orgunits as o on o.orgunit_id = b.orgunit_id');
		$query->select('u.username as lent_user_name');
		$query->leftjoin('#__users as u on u.id = b.lent_user_id');
		return $query;
	}
  
	protected function _buildQuerySmall(){
		$db = JFactory::getDBO();
		$query = $db->getQuery(TRUE);
		$query->select(
			'b.device_id, 
			 b.devicename, 
			 b.snumber, 
			 b.shortdescription, 
			 b.location, 
			 b.orgunit_id, 			 
			 b.imageurl, 
			 b.qrcode, 
			 b.tags, 
			 b.lent_user_id, 
			 b.lent_description, 
			 b.lent, 
			 b.lent_date, 
			 b.lent_due_date'
		);
		$query->from('#__inventory_devices as b');
		$query->select('o.name as orgunit');
		$query->leftjoin('#__inventory_orgunits as o on o.orgunit_id = b.orgunit_id');
		$query->select('u.username as lent_user_name');
		$query->leftjoin('#__users as u on u.id = b.lent_user_id');
		return $query;
	}

	public function getItem($__id=null){
		$device = parent::getItem($__id);
		return $device;
	}
  
	public function getItemByQrcode($__qrcode){
		$device = parent::getItemByQrcode($__qrcode);
		return $device;
	}
  
	protected function _buildWhere(&$query, $__id=null)
	{
		if(!is_null($__id)){
			$query->where('b.device_id = '.(int) $__id);
		}else if($this->hasDeviceId()){
			$query->where('b.device_id = '.(int) $this->_device_id);
		}
		if($this->hasLentUserId()){
			$query->where('b.lent_user_id = '.(int) $this->_lent_user_id);
		}
		if($this->hasOrgUnit()){
			$query->where('b.orgunit_id = "'.$this->_orgunit_id.'"');
		}
		if(!$this->_has_status_available && $this->_has_status_lent){
			$query->where('b.lent = 1');
		}
		if($this->_has_status_available && !$this->_has_status_lent){
			$query->where('b.lent <> 1');
		}
		if($this->hasTags()){
			foreach( $this->_selectionTags as $value){
				$query->where('b.tags LIKE "%'.$value.'%"');
			}
		}
		if($this->hasNameOrder()&&strtolower($this->_name_order)=='desc'){
			$query->order('b.devicename DESC');
		}else{
			$query->order('b.devicename ASC');
			$this->_name_order = 'asc';
			$this->_has_name_order = true;
		}
		
		$query->where('b.active = 1');
		
		return $query;
	}
	
	protected function _buildWhere_addLentUserId(&$query, $lent_user_id=null)
	{
		if(!is_null($lent_user_id)||$this->_has_lent_user_id){
			$query->where( 'b.lent_user_id = '. ((!is_null($lent_user_id))?$lent_user_id:$this->_lent_user_id));
			$query->where( 'b.lent = 1' );
		}
		return $query;
	}
  
	protected function _buildWhere_addQrcode(&$query, $qrcode=null)
	{
		if(!is_null($qrcode)||$this->hasQrcode()){
			$query->where('b.qrcode = "'.((!is_null($qrcode))?$qrcode:$this->_qrcode).'"');
		}
		return $query;
	}
	
	protected function _buildWhereForNoTags(&$query)
	{
		$query->where('b.tags IS NULL OR b.tags = ""');
		return $query;
	}

	/////////////////////
	// VARIABLE CHECKS //
	/////////////////////
	
	private function getDeviceId(){
		$this->_device_id = $this->_app->input->get($this->nameDeviceId, $this->_device_id);
		if(!empty($this->_device_id)&&is_numeric($this->_device_id)){
			return true;
		}
		return false;
	}
	
	private function hasDeviceId(){
		return $this->getDeviceId();
	}
	
	private function getLentUserId(){
		$this->_lent_user_id = $this->_app->input->get($this->nameLentUserId, $this->_lent_user_id);
		if(!empty($this->_lent_user_id)&&is_numeric($this->_lent_user_id)){
			return true;
		}
		return false;
	}
	
	private function hasLentUserId(){
		return $this->getLentUserId();
	}
	
	private function getOrgUnit(){
		$this->_orgunit_id = $this->_app->input->get($this->nameOrgUnit, $this->_orgunit_id);
		if(!empty($this->_orgunit_id)&&is_numeric($this->_orgunit_id)&&($this->_orgunit_id) != '-1'){	
			$db = JFactory::getDBO();
			$query = $db->getQuery(TRUE);
			$query->select('o.orgunit_id, o.name, o.shortdescription');
			$query->from('#__inventory_orgunits as o');
			$query->where('o.orgunit_id = ' . $this->_orgunit_id);
			$db->setQuery($query);
			$this->_orgunit = $db->loadObject();		
			return true;
		}
		return false;
	}
	
	private function hasOrgUnit(){
		return $this->getOrgUnit();
	}
	
	private function getStatusAvailable(){
		$this->_status_available = $this->_app->input->get($this->nameStatusAvailable, $this->_status_available);
		if(!empty($this->_status_available)&&is_string($this->_status_available)){
			if(strtolower($this->_status_available)=='available')
				return true;
		}
		return false;
	}
	
	private function hasStatusAvailable(){
		return $this->getStatusAvailable();
	}
	
	private function getStatusLent(){
		$this->_status_lent = $this->_app->input->get($this->nameStatusLent, $this->_status_lent);
		if(!empty($this->_status_lent)&&is_string($this->_status_lent)){
			if(strtolower($this->_status_lent)=='lent')
				return true;
		}
		return false;
	}
	
	private function hasStatusLent(){
		return $this->getStatusLent();
	}
	
	private function getQrcode(){
		$this->_qrcode = $this->_app->input->get($this->nameQrcode, $this->_qrcode);
		if(!empty($this->_qrcode)&&is_string($this->_qrcode)){
			return true;
		}
		return false;
	}
	
	private function hasQrcode(){
		return $this->getQrcode();
	}
	
	private function getTags(){
		if(gettype($this->_selectionTags)=='array'){
			return true;
		}
		return false;
	}
	
	private function hasTags(){
		return $this->getTags();
	}
	
	private function getPageNumber(){
		$this->_page_number = $this->_app->input->get($this->namePageNumber, $this->_page_number);
		if(!empty($this->_page_number)&&is_numeric($this->_page_number)){
			return true;
		}
		return false;
	}
	
	private function hasPageNumber(){
		return $this->getPageNumber();
	}
	
	private function getNameOrder(){
		$this->_name_order = $this->_app->input->get($this->nameNameOrder, $this->_name_order);
		if(!empty($this->_name_order)&&is_string($this->_name_order)){
			return true;
		}
		return false;
	}
		
	private function hasNameOrder(){
		return $this->getNameOrder();
	}
}