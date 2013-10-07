<?php

namespace Rida;

class RidaInfo extends \Reborn\Module\AbstractInfo
{
	/**
	 * Module name variable
	 *
	 * @var string
	 **/
	protected $name = 'Rida';

	/**
	 * Module version variable
	 *
	 * @var string
	 **/
	protected $version = '1.0';

	/**
	 * Module Display name variable.
	 *
	 * @var string
	 **/
	protected $displayName = array(
								'en' => 'Rida'
								);

	/**
	 * Module description variable
	 *
	 * @var string
	 **/
	protected $description = array(
							'en' => 'Markdown Reader (For Doc)'
							);

	/**
	 * Module author name variable
	 *
	 * @var string
	 **/
	protected $author = 'Nyan Lynn Htut';

	/**
	 * Module author URL variable
	 *
	 * @var string
	 **/
	protected $authorUrl = 'http://reborncms.com';

	/**
	 * Module author Email variable
	 *
	 * @var string
	 **/
	protected $authorEmail = 'lynnhtut87@gmail.com';

	/**
	 * Module Frontend support variable
	 *
	 * @var boolean
	 **/
	protected $frontendSupport = true;

	/**
	 * Module Backend support variable
	 *
	 * @var boolean
	 **/
	protected $backendSupport = true;

	/**
	 * Module can be use Default Module for Frontend variable
	 *
	 * @var boolean
	 **/
	protected $useAsDefaultModule = true;

	/**
	 * Module's URI Prefix variable
	 *
	 * @var string
	 **/
	protected $uriPrefix = 'docs';

	/**
	 * Variable for Allow to change the URI Prefix from user.
	 *
	 * @var boolean
	 **/
	protected $allowToChangeUriPrefix = true;

	/**
	 * Variable for Module Actions Roles list.
	 * Module Action permission will be decided on this role.
	 *
	 * @var array
	 **/
	protected $roles = array();

	/**
	 * Variable for Allow Custom Field.
	 * If you allow custom field in your module, set true
	 *
	 * @var boolean
	 **/
	protected $allow_customfield = false;

}
