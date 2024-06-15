// php code.


$mdebug=1;

function debug_to_console($data) {
$output = $data;
if (is_array($output))
$output = implode(',', $output);

echo "
<script>console.log('Debug Objects: " . $output . "');</script>";
}

$site_url=get_site_url();
$actionPage="$site_url/sample-page"; //form name and call itself
echo " <form style='margin: 0; padding: 0;' id='book_form' method='post' action='$actionPage'>";
	echo "<input type='hidden' name='update_book_id' id='book_id' value='' />";
	echo "ISBN: <input type='text' name='isbn' id='isbn' value='' /> <br>";
	echo "Title: <input type='text' name='title' id='title' value='' /> <br>";
	echo "Price: <input type='number' step='0.01' name='price' id='price' value='' /> <br>";
	echo "Stock: <input type='number' name='stock' id='stock' value='' /> <br>";
	$author_options = "<option>Select an authors.</option>\n";
	$authors = get_authors(db_connection(), $mdebug);
	if($authors==null)
	{
	echo "No record found in query: $qstr <br>";
	}else {
	//$option = "<option value="
		$value=" author_id"; $display="name" ; foreach($authors as $row){ $value_data=$row->$value;
		$display_data=$row->$display;
		$author_options = $author_options."
	<option value='" . $value_data . "'>" . $display_data . "</option>";


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
		$value=" store_id"; $display="address" ; foreach($stores as $row){ $value_data=$row->$value;
		$display_data=$row->$display;
		$store_options = $store_options."
	<option value='" . $value_data . "'>" . $display_data . "</option>";


	}
	}
	echo " <label for='stores'>Choose store address:</label>
	<select name='store' id='stores'>
		$store_options
	</select><br><br>";


	$random_n=rand(0,100000); //submitted form has a different random number
	echo "<input type='hidden' name='random_n' value='$random_n' /> ";
	$_update = update_book();
	echo "<button id='insert' style='padding:0; vertical-align:middle; height:33px; width:110px;' type=submit> Insert
	</button> "; echo "<button id='update' style='padding:0; vertical-align:middle; height:33px; width:110px;'
		type='button' onclick='$_update'>Update</button>";
	echo "
</form>";
echo "<br>";
insert_function($random_n, $mdebug); // This function will submitted the form.
delete_book();
update_book();




function db_connection()
{
/*database connection */
$server="localhost"; $username="root"; $password="root"; $db="group_project";
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
// $server="localhost"; $username="root"; $password="ForgEt123#"; $db="sbs_database";
// $companydb = new wpdb($username,$password,$db,$server);
$companydb = db_connection();

$hasDelete = $_POST["delete_store_id"];
$hasUpdate = $_POST["update_book_id"];
debug_to_console("Has delete $hasDelete");
debug_to_console("Has update $hasUpdate");

if (!$_POST["delete_store_id"] && !$_POST["update_book_id"]) {
return; // Exit function if deleting or updating
}
debug_to_console("Reached insert");
/*
$isbn = $_POST["isbn"];
debug_to_console($isbn);
$title = $_POST["title"];
$price = $_POST["price"];
$stock = $_POST["stock"];
$author = $_POST["author"];
$store = $_POST["store"];
debug_to_console("Stored insert data");

// Check if delete_store_id or update_book_id is present in POST data
if (!empty($_POST["delete_store_id"]) || !empty($_POST["update_book_id"])) {
return; // Exit function if deleting or updating
}
debug_to_console("Reached insert");

$isbn = $_POST["isbn"];
debug_to_console($isbn);
$title = $_POST["title"];
$price = $_POST["price"];
$stock = $_POST["stock"];
$author = $_POST["author"];
$store = $_POST["store"];
debug_to_console("Reached insert");

$qstr = $companydb->prepare("INSERT INTO book (isbn, title, price, stock, author, store) VALUES (%s, %s, %f, %d, %d,
%d)", $isbn, $title,$price,$stock,$author,$store);

debug_to_console("Query String");
$result = $companydb->query($qstr);
debug_to_console("Insert query");



if (!$result) {
// Handle query error here if needed
echo "Error: " . $companydb->last_error;
} else {
// Query executed successfully
echo "Book inserted successfully!";
}
*/

select_display($companydb,$mdebug);

}




function update_book()
{
// code implementation
}

function delete_book()
{
// code implementation
debug_to_console("Reached delete");

$delete_isbn=$_POST["delete_isbn"];

debug_to_console($delete_isbn);
if(!$delete_isbn) return;


$storeId = $_POST["delete_store_id"];
debug_to_console($storeId);
$companydb = db_connection();
// Prepare the query with placeholders
$query = $companydb->prepare("DELETE FROM book WHERE isbn = %s AND store_id = %d", $delete_isbn, $storeId);

// Execute the query
$result = $companydb->query($query);

debug_to_console("Result");
debug_to_console($result);


if (!$result) {
// Handle query error here if needed
echo "Error: " . $companydb->last_error;
} else {
// Query executed successfully
echo "Book deleted successfully!";
}
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
$qstr="select b.isbn,b.store_id, b.title, b.price, b.stock, s.address as store_address, a.name as author from book as b
join store as s on b.store_id = s.store_id join author as a on b.author_id = a.author_id;";
$rows = $companydb->get_results($qstr);

if($rows==null) echo "No record found in query: $qstr <br>";
else{
$columns = array("isbn", "title","price", "stock", "store_address", "author");
$field_num=sizeof($columns);
$field_names=$columns;
$display_names=array("ISBN", "Title", "Price", "Stock", "Store Address", "Author");

echo "<table>
	<tr>";
		for($i=0;$i<$field_num;$i++) echo "<th>$display_names[$i] </th>" ; echo "<th>Action</th>" ; echo "</tr>" ;
			foreach ($rows as $row) { echo "<tr>" ; for($i=0;$i<$field_num;$i++) { $field_name=$field_names[$i];
			$field_data=$row->$field_name;
			echo "<td>$field_data </td>";
			}
			echo "<td>
				<button onclick=editBook(this)>Edit</button>
				<form method='post' class='deleteForm' action='$actionPage'>
					<input type='hidden' name='delete_isbn' value='{$row->isbn}' />
					<input type='hidden' name='delete_store_id' value='{$row->store_id}' />
					<button type='submit' class='deleteBtn' onclick=\"return confirm('Are you sure you want to delete
						this record?')\">Delete</button>
				</form>
			</td>";
			echo "</tr>";
	}
	}
	echo "
</table>";


}