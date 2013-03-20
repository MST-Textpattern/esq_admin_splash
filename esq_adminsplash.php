//<?php

/*
 * CONFIG - edit values in the array below.
 */
function esq_adminsplash_config() {
	$config = array(
		'tab_name' => 'Admin Help',
		'page_title' => 'Textpattern Admin Help',
		'content_width' => '900px',
		'content_textiled' => true,
		'content' => <<<EOF
Textpattern admin help goes here.
You can use "*Textile*":http://textile.thresholdstate.com/ to style your content.
EOF
	);
	return $config;
}
/*
 * END CONFIG - do not modify anything below unless you know what you are doing.
 */

if (@txpinterface == 'admin') {
	$config = esq_adminsplash_config();
	add_privs('esq_adminsplash', '1,2,3,4,5,6');
	register_tab('extensions', 'esq_adminsplash', $config['tab_name']);
	register_callback('esq_adminsplash', 'esq_adminsplash');
}

function esq_adminsplash() {
	global $prefs;
	$config = esq_adminsplash_config();
	pagetop($config['page_title']);
	echo '<div id="esq_adminsplashWrapper" style="text-align: center;"><div id="esq_adminsplashContent" style="text-align: left; margin: 0 auto; width: '.$config['content_width'].'">';
	if ($config['content_textiled'] == true) {
		@include_once(txpath.'/lib/classTextile.php');
		if (class_exists('Textile')) {
			$textile = new Textile();
			echo $textile->TextileThis($config['content']);
			echo '</div></div>';
			return;
		} elseif ($prefs['production_status'] != 'live') {
			echo '<p><strong>Error: Textile not found on server.</strong></p>';
		}
	}
	echo $config['content'];
	echo '</div></div>';
}