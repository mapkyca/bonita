<?php

	/**
	
		Bonita form handling class.
		
		Uses the templating class and some extra helpers to provide a safe form handler. See
		examples/forms.php for more.
		
		@package Bonita
		@subpackage Forms
	
	 */
	 
	 	class BonForm extends BonTemp {
	 	
			/**
			 *  Attaches a target URL to the form.
			 *  @param string $targetURL URL for the form to point to
			 */
	 	
		 		public function setTarget($targetURL) {
		 			$this->targetURL = $targetURL;
		 		}
		 		
		 		public function draw($templateName, $returnBlank = true) {
		 		
		 			$this->token = sha1($this->targetURL . $time . Bon::getSiteSecret());
		 			$this->time = time();
		 			$parent::draw($templateName, $returnBlank);
		 		
		 		}
		 		
			/**
			 *  Gatekeeper function that validates input forms and prevents csrf attacks.
			 *  Call this from your form action code.
			 *
			 *  @param string $targetURL The URL of the form action that brought us here.
			 *  @param boolean $haltExecutionOnBadRequest If set to true, the function halts all execution if the form doesn't validate. (True by default.)
			 *  @return true|false
			 */
		 		public static function validateToken($action = '', $haltExecutionOnBadRequest = true) {
		 		
		 			$time = 	$_REQUEST['__bTs'];
		 			$token = 	$_REQUEST['__bTk'];
		 			if (empty($action))
		 				$action = $_REQUEST['__bTa'];
		 			
		 			if (abs(time() - $time) < 3600)
			 			if (self::token($action, $time) == $token) {
			 				return true;
			 			}
		 			
		 			if ($haltExecutionOnBadRequest) exit;
		 			return false;
		 		
		 		}
		 		
		 	/**
		 	 * 	Generate a token based on a given action and UNIX timestamp.
		 	 *
		 	 *	@param string $targetURL The URL of the form action we're using.
		 	 * 	@param int $time The current timestamp.
		 	 *
		 	 *	@return true|false
		 	 */
		 		public static function token($action, $time) {
		 			return sha1($action . $time . Bon::getSiteSecret());
		 		}
	 	
	 	}