<?php  
/* 
Plugin Name: BolsterDynamics
Plugin URI: https://bolsterdynamics.com/
Description: Add BolsterDynamics to your website
Version: 1.0
Author: BolsterDynamics
Author URI: http://www.bolsterdynamics.com
Author Email: admin@bolsterdynamics.com 
License: 
 
  Copyright 2018 BolsterDynamics Ltd (admin@bolsterdynamics.com) 
 
  This program is free software; you can redistribute it and/or modify 
  it under the terms of the GNU General Public License, version 2, as 
  published by the Free Software Foundation. 
 
  This program is distributed in the hope that it will be useful, 
  but WITHOUT ANY WARRANTY; without even the implied warranty of 
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the 
  GNU General Public License for more details. 
 
  You should have received a copy of the GNU General Public License 
  along with this program; if not, write to the Free Software 
  Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA 
*/  
if (!class_exists("BolsterDynamics")) {
	class BolsterDynamics {
	
		function __construct() {
			add_action('wp_enqueue_scripts', array($this, 'bolsterdynamics')); // wp_enqueue_scripts here means that admin pages dont receive the script
			add_action('admin_init', array($this, 'admin_ignore_notice'));
			add_action('admin_notices', array($this, 'admin_activation_notice'));
		}
		
		function bolsterdynamics() {
			wp_enqueue_script('bolsterdynamics', 'https://static.bolsterdynamics.com/bolsterdynamics.min.js', false, '1.0', true); 
		}
		
		function admin_activation_notice() {
			global $current_user;
			global $pagenow;
			$user_id = $current_user->ID;
			if( !get_user_meta($user_id, 'bolsterdynamics_ignore_notice') ) {
				echo '<div class="updated"><strong><p>That\'s it! The BolsterDynamics plugin is now active.</strong> If you haven\'t already done so, you will need to go to <a href="https://bolsterdynamics.com/signup/" target="_new">our free account sign-up page</a> to register for an account. There are no configuration options here it\'s as simple as that.';
				printf(__('<a href="%1$s" style="float:right">Hide</a>'), '?bolsterdynamics-ignore-notice=0');
				echo '</p></div>';
			}
		}
		
		function admin_ignore_notice() {
			global $current_user;
			$user_id = $current_user->ID;
			if( isset($_GET['bolsterdynamics-ignore-notice']) ) {
				add_user_meta($user_id, 'bolsterdynamics_ignore_notice', 'true', true);
			}
		}

	}
}

new BolsterDynamics();

?>
