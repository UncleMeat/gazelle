<?

authorize();

if (!check_perms('admin_whitelist')) {
    error(403);
}

if ($_POST['submit'] == 'Delete') {
    if (!is_number($_POST['id']) || $_POST['id'] == '') {
        error(0);
    }

    $DB->query("SELECT peer_id FROM xbt_client_whitelist WHERE id = " . $_POST['id']);
    list($PeerID) = $DB->next_record();
    $DB->query('DELETE FROM xbt_client_whitelist WHERE id=' . $_POST['id']);
    update_tracker('remove_whitelist', array('peer_id' => $PeerID));
} else { //Edit & Create, Shared Validation
    if (empty($_POST['client']) || empty($_POST['peer_id'])) {
        //error(print_r($_POST, true)); 
        error("One or more of the fields is blank");
    }

    $Client = db_string($_POST['client']);
    $PeerID = db_string($_POST['peer_id']);

    if ($_POST['submit'] == 'Edit') { //Edit
        if (empty($_POST['id']) || !is_number($_POST['id'])) {
            error(0);
        } else {
            $DB->query("SELECT peer_id FROM xbt_client_whitelist WHERE id = " . $_POST['id']);
            list($OldPeerID) = $DB->next_record();
            $DB->query("UPDATE xbt_client_whitelist SET
				vstring='" . $Client . "',
				peer_id='" . $PeerID . "'
				WHERE ID=" . $_POST['id']);
            update_tracker('edit_whitelist', array('old_peer_id' => $OldPeerID, 'new_peer_id' => $PeerID));
        }
    } else { //Create
        $DB->query("SELECT id FROM xbt_client_whitelist WHERE peer_id = '$PeerID'" );
        if ($DB->record_count()>0) error("There is already an entry in the whitelist with peer_id=$PeerID");

        $DB->query("INSERT INTO xbt_client_whitelist
			(vstring, peer_id) 
		VALUES
			('" . $Client . "','" . $PeerID . "')");
        update_tracker('add_whitelist', array('peer_id' => $PeerID));
    }
}

$Cache->delete('whitelisted_clients');

// Go back
header('Location: tools.php?action=whitelist')
?>
