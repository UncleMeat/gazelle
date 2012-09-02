<?
if (!check_perms('admin_whitelist')) {
    error(403);
}

show_header('Whitelist Management');
$DB->query('SELECT id, vstring, peer_id FROM xbt_client_whitelist ORDER BY peer_id ASC');
?>
<div class="thin">
    <h2>Allowed Clients</h2>
    <table class="wid740">
        <tr class="head">
            <td colspan="3">Add a client</td>
        </tr>
        <tr class="colhead">
            <td width="40%">Client</td>
            <td width="40%">Peer ID</td>
            <td width="20%">Submit</td>
        </tr> 
        <tr class="rowa">	 
        <form action="" method="post"> 
            <td>
                <input type="hidden" name="action" value="whitelist_alter" />
                <input type="hidden" name="auth" value="<?= $LoggedUser['AuthKey'] ?>" /> 
                <input class="long" type="text" name="client" />
            </td>
            <td>
                <input class="long" type="text" size="10" name="peer_id" />
            </td>
            <td>
                <input type="submit" value="Create" />
            </td>
        </form>
        </tr>
    </table>
    <br />
    <table class="wid740">
        <tr class="head">
            <td colspan="3">Mange whitelist</td>
        </tr>
        <tr class="colhead">
            <td width="40%">Client</td>
            <td width="40%">Peer ID</td>
            <td width="20%">Submit</td>
        </tr> 
        <?
        $Row = 'b';
        while (list($ID, $Client, $Peer_ID) = $DB->next_record()) {
            $Row = ($Row === 'a' ? 'b' : 'a');
            ?>
            <tr class="row<?= $Row ?>">
            <form action="" method="post">
                <td>
                    <input type="hidden" name="action" value="whitelist_alter" />
                    <input type="hidden" name="auth" value="<?= $LoggedUser['AuthKey'] ?>" />
                    <input type="hidden" name="id" value="<?= $ID ?>" />
                    <input class="long" type="text" name="client" value="<?= $Client ?>" />
                </td>
                <td>
                    <input class="long" type="text" size="10" name="peer_id" value="<?= $Peer_ID ?>" />
                </td>
                <td>
                    <input type="submit" name="submit" value="Edit" />
                    <input type="submit" name="submit" value="Delete" />
                </td>
            </form>
            </tr>
<? } ?>
    </table>
</div>
<? show_footer(); ?>
