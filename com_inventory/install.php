<?php

	/**
	 * @package     it+kapfenberg
	 * @subpackage  com_inventory
	 *
	 * @copyright   Copyright (C) 2013 Mathias Knoll All rights reserved.
	 * @license     GNU AFFERO GENERAL PUBLIC LICENSE Version 3; see LICENSE.txt
	 */

	defined( '_JEXEC' ) or die( 'Restricted access' );
	jimport('joomla.installer.installer');
	jimport('joomla.installer.helper');
	
	/**
    * Method to install the inventory component
    *
    * @param mixed $parent The class calling this method
    * @return void
    */
    function install($parent)
    {
		echo JText::_('COM_INVENTORY_INSTALL_SUCCESSFULL');
    }
	
	/**
    * Method to update the inventory component
    *
    * @param mixed $parent The class calling this method
    * @return void
    */
    function update($parent)
    {
		echo JText::_('COM_INVENTORY_UPDATE_SUCCESSFULL');
    }
	
	    /**
    * method to run before an install/update/uninstall method
    *
    * @param mixed $parent The class calling this method
    * @return void
    */
    function preflight($type, $parent)
    {
		echo "TEST _ PREFLIGHT";
    }
     
    function postflight($type, $parent)
    {
		echo "TEST _ POSTFLIGHT";
    }
	
?>