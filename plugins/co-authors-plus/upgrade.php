<?php
function coauthors_plus_upgrade( $from ) {
	// TODO: handle upgrade failures
	
	//if( $from < 2.0 ) coauthors_plus_upgrade_20();
	
	if( $from < 3.0 ) coauthors_plus_upgrade_30();
	
	
	// Update to the current global version
	coauthors_plus_update_version(COAUTHORS_PLUS_VERSION);
}

/** 
 * Upgrade to 2.0
 * Updates coauthors from old meta-based storage to taxonomy-based
 */
function coauthors_plus_upgrade_20 () {
	global $coauthors_plus;
	
	// Get all posts with meta_key _coauthor
	$all_posts = get_posts(array('numberposts' => '-1'));
	
	if(is_array($all_posts)) {
		foreach($all_posts as $single_post) {
			
			// reset execution time limit
			set_time_limit( 60 );
			
			// create new array
			$coauthors = array();
			// get author id -- try to use get_profile
			$coauthors[] = get_profile_by_id('user_login', (int)$single_post->post_author);
			// get coauthors id
			$legacy_coauthors = get_post_meta($single_post->ID, '_coauthor'); 
			
			if(is_array($legacy_coauthors)) {
				//echo '<p>Has Legacy coauthors';
				foreach($legacy_coauthors as $legacy_coauthor) {
					$legacy_coauthor_login = get_profile_by_id('user_login', (int)$legacy_coauthor);
					if($legacy_coauthor_login) $coauthors[] = $legacy_coauthor_login;
				}
			} else {
				// No Legacy coauthors
			}
			$coauthors_plus->add_coauthors($single_post->ID, $coauthors);
			
		}
	}
	coauthors_plus_update_version( '2.0' );
}

/** 
 * Upgrade to 2.0
 * Updates coauthors from old meta-based storage to taxonomy-based
 */
function coauthors_plus_upgrade_20 () {
	global $coauthors_plus;
	
	// Get all posts with meta_key _coauthor
	$all_posts = get_posts(array('numberposts' => '-1'));

	// get_coauthors
	// add_coauthor

	coauthors_plus_update_version( '3.0' );
}

function coauthors_plus_update_version( $version ) {
	global $coauthors_plus;
	update_option($co_authors_plus->get_plugin_option_fullname('version'), $version);
}

?>