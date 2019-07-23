<?php
function generateRandomString($length = 10){
	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$characterLength = strlen($characters);
	$randomString = '';
	for( $i = 0; $i < $length; $i++){
		$randomString .= $characters[rand(0, $characterLength - 1)];
	}
	return $randomString;
}
if( isset($_POST['createLink'])){
	$strRand = generateRandomString();
	file_put_contents("randomLinks.txt", $strRand . PHP_EOL, FILE_APPEND);
	header("Location: create.php");
}
$strContents = @file_get_contents("randomLinks.txt");
$arrLinks = [];
if( $strContents){
	$arrLinks = explode( PHP_EOL, $strContents);
}
if( isset($_POST['deleteLink'])){
	if( in_array($_POST['deleteLink'], $arrLinks)){
		array_splice($arrLinks, array_search($_POST['deleteLink'], $arrLinks), 1);
		$strSave = "";
		foreach ($arrLinks as $key => $value) {
			$strSave .= $value . PHP_EOL;
		}
		file_put_contents("randomLinks.txt", $strSave);
	}
	header("Location: create.php");
}
$urlPrefix = $_SERVER['REMOTE_ADDR'] . dirname( $_SERVER['REQUEST_URI']);
?>

<table>
	<?php
	foreach ($arrLinks as $key => $value) {
		if( $value == "")continue;
		?>
		<tr>
			<td><?=$urlPrefix . '/?id=' . $value?></td>
			<td onclick="deleteClicked('<?=$value?>')"><button>Delete</button></td>
		</tr>
		<?php
	}
	?>
</table>
<form method="POST">
	<input type="hidden" name="createLink" value="createLink">
	<input type="submit" name="Create Link" value="Create Link">
</form>
<form method="POST" id="deleteForm">
	<input type="hidden" name="deleteLink" value="">
</form>
<script type="text/javascript" src="toetsen_files/jquery.min.js"></script>
<script type="text/javascript">
	function deleteClicked(_value){
		console.log(_value);
		$("input[name=deleteLink]").val(_value);
		$("#deleteForm").submit();
	}
</script>