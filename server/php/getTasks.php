<?php
require_once('mysql_credentials.php');

$query = "SELECT * from tasks";

if(!empty($_GET['id'])){
    $_GET['id'] = addslashes($_GET['id']);
    $query .= " WHERE ID ='{$_GET['id']}'";
}

$result = mysqli_query( $conn, $query);
$output = ['success' => false,
            'tasks' => [], 
            'user' => [],
            'errors' => []
        ];

if ($result){
    //query was fine
    if(mysqli_num_rows($result)> 0){
        //query returns data
        $output['success'] = true;
        while($row = mysqli_fetch_assoc($result)){
            $output['tasks'][] = $row;
        }
    }else{
        //there was no data in the query
        $output['errors'][] = 'no data available';
    }
}else{
    //mysql problem
    $output['errors'][] = 'error with query';
}
$json_output = json_encode($output);

print($json_output);

?>