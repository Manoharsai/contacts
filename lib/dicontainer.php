<?php
/**
 * @author Thomas Tanghus
 * Copyright (c) 2013 Thomas Tanghus (thomas@tanghus.net)
 * This file is licensed under the Affero General Public License version 3 or
 * later.
 * See the COPYING-README file.
 */

namespace OCA\Contacts;

use OCA\AppFramework\DependencyInjection\DIContainer as BaseContainer;
use OCA\AppFramework\Middleware\MiddlewareDispatcher;
use OCA\AppFramework\Middleware\Security\SecurityMiddleware;
use OCA\Contacts\Middleware\Http as HttpMiddleware;
use OCA\Contacts\Controller\AddressBookController;
use OCA\Contacts\Controller\GroupController;
use OCA\Contacts\Controller\ContactController;
use OCA\Contacts\Controller\SettingsController;
use OCA\Contacts\Controller\ImportController;

class DIContainer extends BaseContainer {


	/**
	 * Define your dependencies in here
	 */
	public function __construct(){
		// tell parent container about the app name
		parent::__construct('contacts');

		$this['HttpMiddleware'] = $this->share(function($c){
			return new HttpMiddleware($c['API']);
		});

		$this['MiddlewareDispatcher'] = $this->share(function($c){
			$dispatcher = new MiddlewareDispatcher();
			$dispatcher->registerMiddleware($c['HttpMiddleware']);
			$dispatcher->registerMiddleware($c['SecurityMiddleware']);

			return $dispatcher;
		});

		/**
		 * CONTROLLERS
		 */
		$this['AddressBookController'] = $this->share(function($c){
			return new AddressBookController($c['API'], $c['Request']);
		});

		$this['GroupController'] = $this->share(function($c){
			return new GroupController($c['API'], $c['Request']);
		});

		$this['ContactController'] = $this->share(function($c){
			return new ContactController($c['API'], $c['Request']);
		});

		$this['SettingsController'] = $this->share(function($c){
			return new SettingsController($c['API'], $c['Request']);
		});

		$this['ImportController'] = $this->share(function($c){
			return new ImportController($c['API'], $c['Request']);
		});

	}
}