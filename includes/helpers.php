<?php

if ( ! function_exists( 'is_login_page' ) ) {

	/**
	 * Function to found the login page.
	 *
	 * @since  0.1.0
	 *
	 * @return boolean   IF login page it's found, return true, else, return false.
	 */
	function is_login_page() {
    	return in_array( $GLOBALS['pagenow'], array( 'wp-login.php', 'wp-register.php' ) );
	}

}
