<?php
ob_start(); 
header('Content-Type: application/json'); 

$action = $_GET['action'];
include 'admin_class.php';
$crud = new Action();

$response = array('success' => false, 'message' => 'Unknown error'); 

if ($action == 'login') {
    $response = $crud->login();
} elseif ($action == 'login2') {
    $response = $crud->login2();
} elseif ($action == 'logout') {
    $response = $crud->logout();
} elseif ($action == 'logout2') {
    $response = $crud->logout2();
} elseif ($action == 'save_user') {
    $save = $crud->save_user();
    if ($save) {
        $response = array('success' => true, 'message' => 'User saved successfully');
    } else {
        $response = array('success' => false, 'message' => 'Failed to save user');
    }
} elseif ($action == 'delete_user') {

	$id = isset($_POST['id']) ? $_POST['id'] : null;
	$response = $crud->delete_user($id);
    if($response){
		$response = array('success' => true, 'message' => 'User deleted successfully');
	} else {
		$response = array('success' => false, 'message' => 'An Error occured');
	}

} elseif ($action == 'signup') {
    $response = $crud->signup();
} elseif ($action == "save_settings") {
    $response = $crud->save_settings();
} elseif ($action == "save_loan_type") {
    $response = $crud->save_loan_type();
} elseif ($action == "delete_loan_type") {
	$id = isset($_POST['id']) ? $_POST['id'] : null;
    $resp = $crud->delete_loan_type($id);
	if($resp == 1){
		$response = array('success' => true, 'message' => 'Loan Type deleted successfully');
	} else {
		$response = array('success' => false, 'message' => 'An Error occurred');
	}

} elseif ($action == "save_plan") {
    $response = $crud->save_plan();
} elseif ($action == "delete_plan") {
    $response = $crud->delete_plan();
} elseif ($action == "save_borrower") {
    $response = $crud->save_borrower();
} elseif ($action == "delete_borrower") {
    $response = $crud->delete_borrower();
} elseif ($action == "save_loan") {
    $response = $crud->save_loan();
} elseif ($action == "delete_loan") {
    $response = $crud->delete_loan();
} elseif ($action == "save_payment") {
    // if($resp == 1){
	// 	$response = array('success' => true, 'message' => 'Payment saved');
	// } else {
	// 	$response = array('success' => false, 'message' => $resp);
	// }
    $response = $crud->save_payment();
    // echo $response;
} elseif ($action == "delete_payment") {
    $response = $crud->delete_payment();
}


ob_end_clean();

if (is_array($response)) {
    echo json_encode($response);
} else {
    echo $response;
}
?>
