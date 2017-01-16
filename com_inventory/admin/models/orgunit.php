<?php // no direct access

/**
 * @package     it+kapfenberg
 * @subpackage  com_inventory
 *
 * @copyright   Copyright (C) 2013 Mathias Knoll All rights reserved.
 * @license     GNU AFFERO GENERAL PUBLIC LICENSE Version 3; see LICENSE.txt
 */

defined( '_JEXEC' ) or die( 'Restricted access' ); 
 
class InventoryModelOrgunit extends JModelAdmin{

	protected $text_prefix = 'COM_INVENTORY_ORGUNIT';

	public $typeAlias = 'com_inventory.orgunit';

	public function getTable($type = 'Orgunit', $prefix = 'InventoryTable', $config = array()){
		return JTable::getInstance($type, $prefix, $config);
	}

	public function getForm($data = array(), $loadData = true){
		
		$form = $this->loadForm('com_inventory.orgunit', 'orgunit', array('control' => 'jform', 'load_data' => $loadData));

		if (empty($form)){
			return false;
		}

		return $form;
	}

	protected function loadFormData(){
		$app = JFactory::getApplication();
		$data = $app->getUserState('com_orgunit.edit.orgunit.data', array());

		if (empty($data)){
			$data = $this->getItem();

			if ($this->getState('orgunit.id') == 0){
				$filters = (array) $app->getUserState('com_inventory.orgunits.filter');
			}
		}

		$this->preprocessData('com_inventory.orgunit', $data);

		return $data;
	}

	public function save($data){
		$app = JFactory::getApplication();

		if (parent::save($data)){
			return true;
		}

		return false;
	}
}