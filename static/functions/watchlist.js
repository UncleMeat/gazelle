
function watchlist_add(user_id, reload) {
    var comm = prompt('Enter a comment for adding this user to the watchlist');
	ajax.get('ajax.php?action=watchlist_add&userid=' + user_id + '&comm=' + comm, function (response) {
        var x = json.decode(response); 
        if ( is_array(x)){
            if ( x[0] == true){
               $('#wl').html("[<a onclick=\"watchlist_remove('"+ user_id +"')\" href=\"#\">Remove from watchlist</a>]");
            }
            alert(x[1]);
            if (x[0] == true && reload) location.reload();
        } else {    // error from ajax
            alert(x);
        } 
	}); 
}

function watchlist_remove(user_id) {
	ajax.get('ajax.php?action=watchlist_remove&userid=' + user_id, function (response) {
        var x = json.decode(response); 
        if ( is_array(x)){
            if ( x[0] == true){
               $('#wl').html("[<a onclick=\"watchlist_add('"+ user_id +"')\" href=\"#\">Add to watchlist</a>]");
            }
            alert(x[1]);
        } else {    // error from ajax
            alert(x);
        } 
	}); 
}



function twatchlist_add(group_id, torrent_id, reload) {
    var comm = prompt('Enter a comment for adding this torrent to the watchlist');
	ajax.get('ajax.php?action=watchlist_add&groupid=' + group_id + '&torrentid=' + torrent_id + '&comm=' + comm, function (response) {
        var x = json.decode(response); 
        if ( is_array(x)){
            if ( x[0] == true){
               $('#wl').html("[<a onclick=\"twatchlist_remove('"+ group_id +"','"+ torrent_id +"')\" href=\"#\">Remove from watchlist</a>]");
            }
            alert(x[1]);
            if (x[0] == true && reload) location.reload();
        } else {    // error from ajax
            alert(x);
        } 
	}); 
}

function twatchlist_remove(group_id, torrent_id) {
	ajax.get('ajax.php?action=watchlist_remove&groupid=' + group_id + '&torrentid=' + torrent_id, function (response) {
        var x = json.decode(response); 
        if ( is_array(x)){
            if ( x[0] == true){
               $('#wl').html("[<a onclick=\"twatchlist_add('"+ group_id +"','"+ torrent_id +"')\" href=\"#\">Add to watchlist</a>]");
            }
            alert(x[1]);
        } else {    // error from ajax
            alert(x);
        } 
	}); 
}


