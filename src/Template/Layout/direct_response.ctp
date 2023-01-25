
<?php 

if (is_array($response)){
	echo json_encode($response);
}else{
	echo $response;
}
?>