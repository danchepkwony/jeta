<?php

/**
 * Create a table in the database to store attendees
 */

function attendees_table(){
    global $wpdb;
    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    $table_name = $wpdb->prefix . "program_attendees"; 
	$charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
      id int(10) unsigned NOT NULL AUTO_INCREMENT,
	  program varchar(255) NOT NULL,
	  program_date varchar(255) NOT NULL,
      name varchar(255) NOT NULL,
      email varchar(255) NOT NULL,
      comment text NOT NULL,
	  time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
      PRIMARY KEY  (id)
    ) $charset_collate";

    dbDelta( $sql );
}

add_action("after_switch_theme", "attendees_table");

/**
 * Store attendee information from form
 */

function add_attendee(){
	global $wpdb;
	$programTitle = sanitize_text_field($_POST['program']);
	$programDate = sanitize_text_field($_POST['program-date']);
	$name = sanitize_text_field($_POST['name']);
	$email = sanitize_email($_POST['email']);
	$comment = '';
	if($_POST['comment']){
		$comment = sanitize_text_field($_POST['comment']);
	}

    $headers = array('Content-Type: text/plain; charset=UTF-8');

	$table_name = $wpdb->prefix . 'program_attendees';

	$wpdb->insert( 
		$table_name, 
		array( 
			'program' => $programTitle, 
			'program_date' => $programDate, 
			'name' => $name, 
			'email' => $email, 
			'comment' => $comment,
			'time' => current_time( 'mysql' )
		) 
	);
}

add_action("wp_ajax_add_attendee", "add_attendee");
add_action("wp_ajax_nopriv_add_attendee", "add_attendee");

/**
 * Set up attendee admin page
 */

function attendee_admin_page(){
	if ( !current_user_can( 'edit_posts' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
    global $wpdb;
    $table_name = $wpdb->prefix . 'program_attendees';

    $query = "SELECT * FROM $table_name";
    $results = $wpdb->get_results($query);
	$groupedResults = [];

	// Group by date then by program title
	foreach($results as $row){
		if(!array_key_exists($row->program_date, $groupedResults)){
			$groupedResults[$row->program_date] = [];
		}

		if(!array_key_exists($row->program, $groupedResults[$row->program_date])){
			$groupedResults[$row->program_date][$row->program] = [];
		}

		array_push($groupedResults[$row->program_date][$row->program], $row);
	}

	?> 
		<h1>Attendees</h1>
		<?php foreach($groupedResults as $date => $programs):?>
			<div class="date-group">
				<h2><?php echo $date ?></h2>
				<div class="program-group">
					<?php foreach($programs as $programTitle => $programAttendees):?>
						<h3><?php echo $programTitle ?></h3>
						<table>
						<tr>
							<th>Name</th>
							<th>Email</th>
							<th>Comment</th>
						</tr>
						<?php foreach($programAttendees as $attendee): ?>
							<tr>
								<td><?php echo $attendee->name ?></td>
								<td><?php echo $attendee->email ?></td>
								<td><?php echo $attendee->comment ?></td>
							</tr>
						<?php endforeach; ?>
						</table>
					<?php endforeach; ?>
				</div>
			</div>
		<?php endforeach; ?>
	<?php
}

/**
 * Create attendee admin page
 */

function attendees_page() { 

	add_menu_page( 
		'Program Attendees', 
		'Attendees', 
		'edit_posts', 
		'attendees', 
		'attendee_admin_page', 
		'dashicons-groups',
		2
	   );
}

add_action('admin_menu', 'attendees_page');

function register_attendees_page_styles( $hook ) {
	if ( 'toplevel_page_attendees' != $hook ) {
        return;
    }
	wp_enqueue_style( 'attendees_page_style', get_template_directory_uri() . '/assets/css/admin/style.css', [], '1.0.0');
}
	
add_action('admin_enqueue_scripts', 'register_attendees_page_styles' );	