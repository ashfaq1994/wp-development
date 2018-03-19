<?php
/**
 * @package Student Studio
 */
/*
Plugin Name: Student Studio
Plugin URI: https://studentstudio.com/
Description: Student Datatbase studio.
Version: 4.0.2
Author: Ashfaq
Author URI: https://apks.net/
License: GPLv2 or later
Text Domain: akismet
*/


// Creating Table for student Studio

function student_db_setup(){


	global $wpdb;

	$table = $wpdb->prefix . 'Student_Data_Form';

	$charset_collate = $wpdb->get_charset_collate();

	$sql = "CREATE TABLE $table (
 
     id int(9) NOT NULL AUTO_INCREMENT,

     name varchar(255) NOT NULL,

     email varchar(255) NOT NULL,

     phone varchar(255) NOT NULL,

     grade varchar(255) NOT NULL,

     PRIMARY KEY(id)

     ) $charset_collate; ";


    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

     dbDelta($sql);

}


add_action('init', 'student_db_setup');


// Submit the Data to the Student Studio


function student_data_submit(){

	if (isset($_POST['student_from']) && $_POST['hidden'] == "1") :

		 global $wpdb;

     $name =  sanitize_text_field($_POST['contactname']);
     $email = sanitize_text_field($_POST['contactemail']);
     $phone = sanitize_text_field($_POST['contactphone']);
     $grade = sanitize_text_field($_POST['contactgrade']);


     $table = $wpdb->prefix . 'Student_Data_Form';

     $data = array(

     	'name' => $name,
     	 'email' => $email,
     	 'phone' => $phone,
     	 'grade' => $grade
     );

     $format = array(

     	'%s','%s','%s','%s'
     );

     $wpdb->insert($table, $data, $format );

	
	endif;

}

add_action('init', 'student_data_submit');


// Creating a Admin Menu 

function student_page_menu(){

	add_menu_page( 

		'Student Studio', 
		'Student', 
		'administrator', 
		'studnet_studio_page', 
		'student_page_menu_callback', 
		'dashicons-universal-access-alt', 
		20 
	);

}

add_action('admin_menu', 'student_page_menu');


?>

<!-- printing a Student Studio -->

<?php function student_page_menu_callback(){?>
	
	<div class="wrap">
		<h1>Student Studio</h1>

		<table class="wp-list-table widefat striped">
			<thead>
				  <tr>
                  <th class="manage-column">ID</th>
                  <th class="manage-column">Name</th>
                  <th class="manage-column">E-mail</th>
                  <th class="manage-column">Phone</th>
                  <th class="manage-column">Grade</th>
              </tr>
			</thead>

			<tbody>
				<?php 
                
                global $wpdb;
                $table = $wpdb->prefix . 'Student_Data_Form';
                $sql = "SELECT * FROM $table";
                $student_result = $wpdb->get_results($sql, ARRAY_A);

                foreach ($student_result as $student_results) : ?>

                <tr>
                	<td><?php echo  $student_results['id'] ?></td>
                	<td><?php echo  $student_results['name'] ?></td>
                	<td><?php echo  $student_results['email'] ?></td>
                	<td><?php echo  $student_results['phone'] ?></td>
                	<td><?php echo  $student_results['grade'] ?></td>
                </tr>


            <?php endforeach; ?>
			</tbody>
		</table>
	</div>

<?php } ?>


<?php 

function form_short_code(){?>
<div class="container">
	<form method="POST">
		<div class="row">
			<div class="col-md-6">
				<label class="text-left text-warning display-4"  for="name">You'r Name</label>
				<div class="form-group">
					<input name="contactname" class="form-control form-control-lg" placeholder="Name" type="text" required>
				</div>
			</div>
			<div class="col-md-6">
				<label class="text-left text-warning display-4" for="name">You'r E-Mail</label>
				<div class="form-group">
					<input name="contactemail" class="form-control form-control-lg" placeholder="E-mail" type="text" required>
				</div>
			</div>
			<div class="col-md-6">
				<label class="text-left text-warning display-4" for="name">You'r Phone</label>
				<div class="form-group">
					<input name="contactphone" class="form-control form-control-lg" placeholder="Phone" type="text" required>
				</div>
			</div>
			<div class="col-md-6">
				<label class="text-left text-warning display-4" for="name">You'r Grade</label>
				<div class="form-group">
					<input name="contactgrade" class="form-control form-control-lg" placeholder="Grade" type="text" required>
				</div>
			</div>
			<div class="col-md-12">
				<button class="btn btn-lg btn-info btn-block mt-2" type="submit" name="student_from">Submit Student Form!</button>
			</div>

			<input type="hidden" name="hidden" value="1">
		</div>
	</form>
</div>

<?php } ?>
