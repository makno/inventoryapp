<?php

/**
 * @package     it+kapfenberg
 * @subpackage  com_inventory
 *
 * @copyright   Copyright (C) 2013 Mathias Knoll All rights reserved.
 * @license     GNU AFFERO GENERAL PUBLIC LICENSE Version 3; see LICENSE.txt
 
 * 17.01.2014 - changed to version 3.2.1 authentication structure 
 * 19.02.2014 - Added LDAP support
 * 20.10.2014 - Added fall-back to native and fixed a bug where id didn't show up
 
 */
function onAuthenticate( &$credentials ){
	jimport('joomla.user.helper');
	jimport('joomla.user.authentication');
 	JLoader::register('JAuthenticationResponse', JPATH_PLATFORM .'/joomla/user/authentication.php')    ;
	$componentParams = JComponentHelper::getParams('com_inventory',true);
	$loginmethod = $componentParams->get('required_login_method', '');

	$response = new JAuthenticationResponse;
	$response->status = JAuthentication::STATUS_FAILURE;
 	$response->error_message = 'Unknown Error during Login';

	// If LDAP,
	if($loginmethod == 'LDAP'){
		$response = onAuthenticateLDAP($credentials);
	}

	if($loginmethod != 'LDAP' || (isset($response)&&$response->status==JAuthentication::STATUS_FAILURE)){
		$response = onAuthenticateNative($credentials);
	}
	return $response;
}
 
function onAuthenticateNative( &$credentials ){ 

	jimport('joomla.user.helper');
	jimport('joomla.user.authentication');
	JLoader::register('JAuthenticationResponse', JPATH_PLATFORM .'/joomla/user/authentication.php'); 

	$response = new JAuthenticationResponse;
	$response->type = 'Native Joomla';

	if (empty($credentials['password'])){
		$response->status = JAuthentication::STATUS_FAILURE;
		$response->error_message = JText::_('JGLOBAL_AUTH_PASS_BLANK');
		return $response;
	}

	// Initialize variables
	$conditions = '';

	// Get a database object
	$db = JFactory::getDBO();

	$query = $db->getQuery(true)
			->select('id, password')
			->from('#__users')
			->where('username=' . $db->quote($credentials['username']));
	$db->setQuery( $query );
	$result = $db->loadObject();

	if($result){
	
		$credentials['id'] = $result->id;
		$match = JUserHelper::verifyPassword($credentials['password'], $result->password, $result->id);

		if ($match === true) {
			$user = JUser::getInstance($result->id); 
			$response->email = $user->email;
			$response->fullname = $user->name;
			$response->status = JAuthentication::STATUS_SUCCESS;
			$response->error_message = '';
			$response->id = $result->id;
		} else {
			$response->status = JAuthentication::STATUS_FAILURE;
			$response->error_message = 'Invalid password';
		}
	}
	else{
		$response->status = JAuthentication::STATUS_FAILURE;
		$response->error_message = 'User does not exist';
	}

	return $response;
}
 
function onAuthenticateLDAP( &$credentials ){
	
	jimport('joomla.user.helper');
	jimport('joomla.user.authentication');
	JLoader::register('JAuthenticationResponse', JPATH_PLATFORM .'/joomla/user/authentication.php');
	
	$response = new JAuthenticationResponse;
	$response->type = 'LDAP';
	
	if (empty($credentials['password'])){
		$response->status = JAuthentication::STATUS_FAILURE;
		$response->error_message = JText::_('JGLOBAL_AUTH_PASS_BLANK');
		return $response;
	}
	
	$userdetails = null;
	$success = 0;
	$userdetails = array();
	
	$plugin = JPluginHelper::getPlugin('authentication', 'ldap');
	$params = new JRegistry($plugin->params);
	
	// Load plugin params info
	$ldap_email		= $params->get('ldap_email');
	$ldap_fullname	= $params->get('ldap_fullname');
	$ldap_uid		= $params->get('ldap_uid');
	$auth_method	= $params->get('auth_method');

	$ldap = new JClientLdap($params);

	if (!$ldap->connect())
	{
		$response->status = JAuthentication::STATUS_FAILURE;
		$response->error_message = JText::_('JGLOBAL_AUTH_NO_CONNECT');
		return $response;
	}

	switch ($auth_method)
	{
		case 'search':
			{
				// Bind using Connect Username/password
				// Force anon bind to mitigate misconfiguration like [#7119]
				if (strlen($params->get('username')))
				{
					$bindtest = $ldap->bind();
				}
				else
				{
					$bindtest = $ldap->anonymous_bind();
				}

				if ($bindtest)
				{
					// Search for users DN
					$binddata = $ldap->simple_search(str_replace("[search]", $credentials['username'], $params->get('search_string')));

					if (isset($binddata[0]) && isset($binddata[0]['dn']))
					{
						// Verify Users Credentials
						$success = $ldap->bind($binddata[0]['dn'], $credentials['password'], 1);

						// Get users details
						$userdetails = $binddata;
					}
					else
					{
						$response->status = JAuthentication::STATUS_FAILURE;
						$response->error_message = JText::_('JGLOBAL_AUTH_USER_NOT_FOUND');
					}
				}
				else
				{
					$response->status = JAuthentication::STATUS_FAILURE;
					$response->error_message = JText::_('JGLOBAL_AUTH_NO_BIND');
				}
			}	break;

		case 'bind':
			{
				// We just accept the result here
				$success = $ldap->bind($credentials['username'], $credentials['password']);

				if ($success)
				{
					$userdetails = $ldap->simple_search(str_replace("[search]", $credentials['username'], $params->get('search_string')));
				}
				else
				{
					$response->status = JAuthentication::STATUS_FAILURE;
					$response->error_message = JText::_('JGLOBAL_AUTH_BIND_FAILED');
				}
			}	break;
	}

	if (!$success)
	{

		$response->status = JAuthentication::STATUS_FAILURE;

		if (!strlen($response->error_message))
		{
			$response->error_message = JText::_('JGLOBAL_AUTH_INCORRECT');
		}
	}
	else
	{
		// SOF

	        // Get a database object
        	$db = JFactory::getDBO();

        	$query = $db->getQuery(true)
                        ->select('id, password')
                        ->from('#__users')
                        ->where('username=' . $db->quote($credentials['username']));
        	$db->setQuery( $query );
        	$result = $db->loadObject();

        	if($result){
			if(isset($userdetails[0][$ldap_uid][0])){
                		$credentials['id'] = $result->id;
                        	$user = JUser::getInstance($result->id);
				$response->username = $userdetails[0][$ldap_uid][0];
                        	$response->email = $user->email;
                        	$response->fullname = $user->name;
                        	$response->status = JAuthentication::STATUS_SUCCESS;
                        	$response->error_message = '';
                        	$response->id = $result->id;
			}else{
				$response->status = JAuthentication::STATUS_FAILURE;
                        	$response->error_message = 'Could not fetch data from ldap result!';
			}
                } else {
                       	$response->status = JAuthentication::STATUS_FAILURE;
                       	$response->error_message = 'User could not be fetched from database- ldap import failed!';
                }

		// EOF
	
	}

	$ldap->close();
	
	return $response;
}


 ?>