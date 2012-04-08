<?php

	/**
	 * 	Howdy!
	 
		This is a really simple example of how to use forms.
		
		If you haven't already, check out index.php first.
	 	
	 */
	 
	// Load Bonita
		require_once dirname(dirname(__FILE__)) . '/start.php';
	
	// Add this directory as an additional path
		Bon::additionalPath(dirname(__FILE__));
		
	// Instantiate template
		$t = new BonTemp();
		
	// Set the body
		$t->body = $t->draw('pages/forms');
		
	// Was the form already submitted?
		if (isset($_REQUEST['__bTa'])) {
			
			// If so, validate the form token (to prevent nefarious tomfoolery)
			if (BonForm::validateToken()) {
			
				// If the action completed, set the body to our form submission template
				$t->body = $t->draw('pages/example/formsubmitted');
			
			}
			
		}
		
	// Draw the page
		$t->__(array(
		
			'title' => 'Forms example'
			
		))->drawPage();