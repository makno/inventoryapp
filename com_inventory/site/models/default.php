<?php defined( '_JEXEC' ) or die( 'Restricted access' ); 

/**
 * @package     it+kapfenberg
 * @subpackage  com_inventory
 *
 * @copyright   Copyright (C) 2013 Mathias Knoll All rights reserved.
 * @license     GNU AFFERO GENERAL PUBLIC LICENSE Version 3; see LICENSE.txt
 */

class InventoryModelsDefault extends JModelBase
{
	protected $__state_set  = null;
	protected $_total       = null;
	protected $_pagination  = null;
	protected $_db          = null;
	protected $id           = null;
	
	var $items_total		= null;
	var $page_number		= null;
	var $limitstart   		= 0;
	var $limit       		= 1000;
	var $itemsperpage		= 10;
	
	var $registry			= null;

	var $showversion		= false;
	var $status				= '';

 
	function __construct(){
		parent::__construct(); 
		$this->registry = new JRegistry;
		$this->registry->set('limit',JRequest::getVar('limit', $this->limit, '', 'int')); 
		$this->registry->set('limitstart',JRequest::getVar('limitstart', $this->limitstart , '', 'int'));
		$this->setState($this->registry);
		
		$componentParams = JComponentHelper::getParams('com_inventory',true);
		$this->status = $componentParams->get('component_status', '');
		$this->showversion = ($componentParams->get('show_version', '0')=='1');
	}
	
	function getPagination() {
		if (empty($this->pagination)) 
		{
			$this->pagination = new JPagination( 
				$this->items_total, 
				$this->getState()->get('limitstart'), 
				$this->getState()->get('limit')
			);
		}
		return $this->pagination;
	}
	
	function getVersion(){
	
		$db = JFactory::getDBO();
	
		$query = 
			'SELECT manifest_cache'.
			' FROM #__extensions'.
			' WHERE element = "com_inventory"'.
			' LIMIT 1';
		
		$db->setQuery($query);
		$rows = $db->loadObjectList();
		$itemrow = $rows[0];
		
		$itmearray = json_decode($itemrow->manifest_cache);
			
		return $itmearray->version;
	}

	public function store($data=null){    
		$data = $data ? $data : JRequest::get('post');
		$row = JTable::getInstance($data['table'],'Table');
		$date = date("Y-m-d H:i:s");
		if (!$row->bind($data))
			return false;
		$row->modified = $date;
		if ( !$row->created )
			$row->created = $date;
		if (!$row->check())
			return false;
		if (!$row->store())
			return false;
		return $row;
	}
 
	public function set($property, $value = null){
		$previous = isset($this->$property) ? $this->$property : null;
		$this->$property = $value;
		return $previous;
	}

	public function get($property, $default = null) {
		return isset($this->$property) ? $this->$property : $default;
	}

	public function getItem($__id=null){
		$db = JFactory::getDBO();
		$query = $this->_buildQuery();
		$this->_buildWhere($query, $__id);
		$db->setQuery($query);
		$item = $db->loadObject();
		return $item;
	}
  
	public function getItemByQrcode($qrcode){
		$db = JFactory::getDBO();
		$query = $this->_buildQuerySmall();
		$this->_buildWhere($query);
		$this->_buildWhere_addQrcode($query, $qrcode);
		$db->setQuery($query);
		$item = $db->loadObject();
		return $item;
	}


	public function listItems(){
		$query = $this->_buildQuery(); 
		$query = $this->_buildWhere($query);
		$list = $this->_getList($query, $this->limitstart, $this->limit);
		$this->checkSanity($list);
		return $list;
	}
	
	public function listItemsSmall(){
		$query = $this->_buildQuerySmall();    
		$query = $this->_buildWhere($query);
		$list = $this->_getList($query, $this->limitstart, $this->limit);
		return $list;
	}

	public function listItemsSmallByUserId($lent_user_id){
		$query = $this->_buildQuerySmall();   
		$query = $this->_buildWhere($query);
		$query = $this->_buildWhere_addLentUserId($query, $lent_user_id);
		$list = $this->_getList($query, $this->limitstart, $this->limit);
		return $list;
	}
	
	public function listItemsWithNoTags(){
		$query = $this->_buildQuery();    
		$query = $this->_buildWhere($query);
		$query = $this->_buildWhereForNoTags($query);
		$list = $this->_getList($query, $this->limitstart, $this->limit);
		$this->checkSanity($list);
		return $list;
	}
 
	protected function _getList($query, $limitstart = 0, $limit = 0){
		$db = JFactory::getDBO();
		$db->setQuery($query, $limitstart, $limit);
		$result = $db->loadObjectList();
		return $result;
	}
 
	protected function _getListCount($query){
		$db = JFactory::getDBO();
		$db->setQuery($query);
		$db->query();
		return $db->getNumRows();
	}
	
	private function checkSanity(&$list){
		for($i=0, $n = count($list);$i<$n;$i++) {
			if($list[$i]->lent == 1 && $list[$i]->lent_user_id <= 0){
				$list[$i]->lent = 0;
				try {
					$result = JFactory::getDbo()->updateObject('#__inventory_devices', $list[$i], 'device_id');
				} catch (Exception $e) {
					// catch the error.
				}
			}
		}
	}
}