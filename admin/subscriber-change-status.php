<?php require_once('header.php'); ?>

<?php
// Preventing the direct access of this page.
if(!isset($_REQUEST['id'])) {
	header('location: logout.php');
	exit;
} else {
	// Check the id is valid or not
	$statement = $pdo->prepare("SELECT * FROM tbl_subscriber WHERE subs_id=?");
	$statement->execute(array($_REQUEST['id']));
	$total = $statement->rowCount();
	if( $total == 0 ) {
		header('location: logout.php');
		exit;
	}
}
?>

<?php

	// update from tbl_subscriber
    $fetch = $statement->fetch(PDO::FETCH_ASSOC);
    if($fetch['subs_active'] == '1') {
        $statement = $pdo->prepare("UPDATE `tbl_subscriber` SET `subs_active` = '0' WHERE `tbl_subscriber`.`subs_id` = ?");
	$statement->execute(array($_REQUEST['id']));
    } else {
        $statement = $pdo->prepare("UPDATE `tbl_subscriber` SET `subs_active` = '1' WHERE `tbl_subscriber`.`subs_id` = ?");
	$statement->execute(array($_REQUEST['id']));
    }
	

	header('location: subscriber.php');
?>