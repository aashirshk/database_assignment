// php code.


$mdebug=1;

	$site_url=get_site_url();
	$actionPage="$site_url?page_id=257&preview=true";  //form name and call itself
	echo " <form style='margin: 0; padding: 0;' id='book_form' method='post'action='$actionPage' >";	
	echo "ISBN: <input type='text'  name='isbn' id='isbn' value='' /> <br>";
	echo "Title: <input type='text'  name='title' id='title' value='' /> <br>";
	echo "Price: <input type='number' step='0.01' name='price' id='price' value='' /> <br>";
	echo "Stock: <input type='number'  name='stock' id='stock' value='' /> <br>";
	$author_options = "<option>Select an authors.</option>\n";
	$authors = get_authors(db_connection(), $mdebug);
	if($authors==null)
	{ 
		echo "No record found in query: $qstr <br>";
	}else {
		//$option = "<option value="
		$value="author_id";
		$display="name";
		foreach($authors as $row){
			$value_data=$row->$value;
			$display_data=$row->$display;
			$author_options = $author_options."<option value='" . $value_data . "'>" . $display_data . "</option>";
				
			
		}
	}
	echo " <label for='authors'>Choose an author:</label>
        <select name='author' id='authors'>
			$author_options
		</select><br>";

	$store_options = "<option>Select store address.</option>\n";
	$stores = get_store(db_connection(), $mdebug);
	if($stores==null)
	{ 
		echo "No record found in query: $qstr <br>";
	}else {
		//$option = "<option value="
		$value="store_id";
		$display="address";
		foreach($stores as $row){
			$value_data=$row->$value;
			$display_data=$row->$display;
			$store_options = $store_options."<option value='" . $value_data . "'>" . $display_data . "</option>";
				
			
		}
	}
	echo " <label for='stores'>Choose store address:</label>
        <select name='store' id='stores'>
			$store_options
		</select><br><br>";


	$random_n=rand(0,100000);  //submitted form has a different random number            
	echo "<input type='hidden'  name='random_n' value='$random_n' /> ";
	$_update = update_book();
	echo "<button  id='insert' style='padding:0; vertical-align:middle; height:33px; width:110px;' type=submit> Insert </button> ";	   echo "<button id='update' style='padding:0; vertical-align:middle; height:33px; width:110px;' type='button' onclick='$_update'>Update</button>";	
	echo "</form>";
	echo "<br>";
	insert_function($random_n, $mdebug);  // This function will submitted the form. 


function db_connection()
{
	/*database connection */
	$server="localhost";   	$username="root";  	$password="";  $db="";
	$companydb = new wpdb($username,$password,$db,$server);
	
	if ($companydb==null)
		echo "DB Connection failed. Check your database connection account.<br>";
	else
	{
		return $companydb;
	}
}


function insert_function($random_n, $mdebug)
{
	/*database connection */
	// $server="localhost";   	$username="root";  	$password="ForgEt123#";  $db="sbs_database";
	// $companydb = new wpdb($username,$password,$db,$server);
	$companydb = db_connection();
	$request=$_SERVER['REQUEST_METHOD'];
	select_display($companydb,$mdebug);
	
}

function update_book()
{	
    // code implementation
}

function delete_book()
{
    // code implementation
}

function get_authors($companydb, $mdebug)	
{
	$qstr = "SELECT author_id, name FROM author;";
	$result = $companydb->get_results($qstr);	
	return $result;
}

function get_store($companydb, $mdebug)	
{
	$qstr = "SELECT distinct(address), store_id from store;";
	$result = $companydb->get_results($qstr);	
	return $result;
}



function select_display($companydb, $mdebug)
{
	$qstr="select b.isbn, b.title, b.price, b.stock, s.address as store_address, a.name as author from book as b join store as s on b.store_id = s.store_id join author as a on b.author_id = a.author_id;";
	$rows = $companydb->get_results($qstr);
	
	if($rows==null) 	echo "No record found in query: $qstr <br>";
	else{
		$columns = array("isbn", "title","price", "stock", "store_address", "author");
		$field_num=sizeof($columns);
		$field_names=$columns;
		$display_names=array("ISBN", "Title", "Price", "Stock", "Store Address", "Author");
		
		echo "<table><tr>";
		for($i=0;$i<$field_num;$i++)
			echo "<th>$display_names[$i] </th>";
		echo "<th>Action</th>";
		echo "</tr>";
		
		
		foreach ($rows as $row)
		{
			echo "<tr>";		
			for($i=0;$i<$field_num;$i++)
			{
				$field_name=$field_names[$i];
				$field_data=$row->$field_name;
				echo "<td>$field_data </td>";
			}
			echo "<td>
						<button onclick=editBook(this)>Edit</button>
						<button>Delete</button>
				  </td>";
			echo "</tr>";
		}
	}	
	echo "</table>";
	
	
}