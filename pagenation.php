<?php include('db.php') ?>
<?php 

global $connection;

if (!$connection) :
	
	echo "DB failed" OR $connection->error;
endif;

function query($sql){

	global $connection;

	return $connection->query($sql);
}


$sql = "CREATE TABLE IF NOT EXISTS Posts (

 id int(9) NOT NULL AUTO_INCREMENT PRIMARY KEY,
 post_title varchar(255) NOT NULL,
 post_content varchar(255) NOT NULL,
 post_author varchar(255) NOT NULL
)";

$result_set = query($sql);

global  $connection;

if (!$result_set == true) {
	
$sql = "INSERT INTO Posts (post_title, post_content, post_author)
 VALUES ('post_ttile', 'post_content', 'post_ashfaq');";

 $result_inert = query($sql);

 if ($result_inert) {
 	
 	echo "iNSERTED";
 }

}

 ?>

 <!DOCTYPE html>
 <html lang="en">
 <head>
 	<meta charset="UTF-8">
 	<title>FORM</title>
 </head>
 <body>

       <?php 	

       function insert_query($post_title, $post_content, $post_author){

			$sql = "INSERT INTO Posts (post_title, post_content, post_author)
 VALUES ('{$post_title}', '{$post_content}', '{$post_author}')";

			$result_set  = query($sql);

			return $result_set;

		}


		// function print_query(){

		// 	global $this_page;
		// 	global $per_page;

		// 	$sql = 'SELECT * FROM Posts LIMIT'  . $this_page . ',' .  $per_page;

		// 	$result_set = query($sql);

		// 	return $result_set;
		// }
		        
        if (isset($_POST['submit'])) {
    
			 $post_title = $_POST['post_title'];
			  $post_content =  $_POST['post_content'];
			  $post_author = $_POST['post_author'];


            $result_set = insert_query($post_title, $post_content, $post_author);
            
			if ($result_set == TRUE) {

					echo "DATA inserted";
					# code...
				} 

				else{
					echo "failed";
				}

        }

        
    
       ?>
 	<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
 		<label for="#">Post Title</label>
 		 <input name="post_title" type="text">
 		 <br>
 		 <label for="#">Post content</label>
 		 <input type="text" name="post_content">
 		 <br>
 		 <label for="#">Post Author</label>
 		 <input type="text" name="post_author">
 		 <input type="submit" name="submit">
 		 <br>
 	</form>

 	<table>
 		<thead>
 			<th>ID</th>
 			<th>Post Title</th>
 			<th>Post content</th>
 			<th>Post Auhtor</th>
 			<th>Delete</th>
 			<th>Edit</th>
 		</thead>


<?php 

  $per_page = 3;


   if (!isset($_GET['page'])) {

       $page  =  1;
      # code...
    } else{
      
      $page = $_GET['page'];

    }

     $this_page  = ($page - 1) * $per_page;

   ?>

    <?php

    global  $connection;
   
    $sql = "SELECT * FROM Posts";

    $result_quer = query($sql);

    $result_row  = mysqli_num_rows($result_quer);

     $count =  ceil($result_row / $per_page);

     for ($i=1; $i <$count ; $i++) { 
      
      echo "<a href='pagenation.php?page={$i}'>{$i}</a>";

     }
 
   ?>



<?php 

$sql = "SELECT * FROM Posts LIMIT  $this_page, $per_page";

$result_set = query($sql);

while ($have = mysqli_fetch_array($result_set)) :
	
	$post_id =  $have['id'];
	$post_title =  $have['post_title'];
	$post_content =  $have['post_content'];
	$post_author =  $have['post_author'];

 ?>
 		<tbody>
 			<td><?php echo $post_id ?></td>
 			<td><?php echo $post_title; ?></td>
 			<td><?php echo $post_content; ?></td>
 			<td><?php echo $post_author?></td>
 			<td><a href="pagenation.php?delete=<?php echo $post_id ?>">Delete</a></td>
 			<td><a href="pagenation.php?edit=<?php echo $post_id ?>">Edit</a></td>
 		</tbody>
 	<?php endwhile; ?>

 <?php 

  if (isset($_GET['delete'])) {
     
     $post_id = $_GET['delete'];

    $sql = "DELETE FROM Posts WHERE id = {$post_id}";

    $del_result = query($sql);

    if ($del_result == TRUE) {
    	
    	echo "Deleted";

    	header("Location: pagenation.php");
    }

    else{
    	echo "Query failed";
    }

  }

  ?>
 	</table>

 	
 </body>
 </html>