<?php
namespace gazelle\services;

use gazelle\core\Master;
use gazelle\errors\SystemError;

class OldDB extends Service {

    public $LinkID = false;
    protected $QueryID = false;
    protected $Record = array();
    protected $Row;
    protected $Errno = 0;
    protected $Error = '';

    public $Queries = array();
    public $Time = 0.0;

    public function __construct(Master $master) {
        parent::__construct($master);
        if (!extension_loaded('mysqli')) {
            throw new SystemException('Mysqli Extension not loaded.');
        }
    }

    public function halt($Msg) {
        global $LoggedUser, $Cache, $Debug, $argv;
        $DBError='MySQL: '.strval($Msg).' SQL error: '.strval($this->Errno).' ('.strval($this->Error).')';
        if ($this->Errno == 1194) {
            send_irc('PRIVMSG '.ADMIN_CHAN.' :'.$this->Error);
        }
        $Debug->analysis('!dev DB Error',$DBError,3600*24);
        if (DEBUG_MODE || check_perms('site_debug') || isset($argv[1])) {
            echo '<pre>'.display_str($DBError).'</pre>';
            if (DEBUG_MODE || check_perms('site_debug')) {
                print_r($this->Queries);
            }
            die();
        } else {
            error('-1');
        }
    }

    public function connect() {
        if (!$this->LinkID) {
            $dbc = $this->master->settings->database;
            $this->LinkID = mysqli_connect($dbc->host, $dbc->username, $dbc->password, $dbc->db, $dbc->port, $dbc->socket);
            if (!$this->LinkID) {
                $this->Errno = mysqli_connect_errno();
                $this->Error = mysqli_connect_error();
                $this->halt('Connection failed (host:'.$dbc->host.':'.$dbc->port.')');
            }
        }
    }

    public function query($Query,$AutoHandle=1)
    {
        global $LoggedUser, $Debug;
        $QueryStartTime=microtime(true);
        $this->connect();
        //In the event of a mysql deadlock, we sleep allowing mysql time to unlock then attempt again for a maximum of 5 tries
        for ($i=1; $i<6; $i++) {
            $this->QueryID = mysqli_query($this->LinkID,$Query);
            if (!in_array(mysqli_errno($this->LinkID), array(1213, 1205))) {
                break;
            }
            $Debug->analysis('Non-Fatal Deadlock:',$Query,3600*24);
            trigger_error("Database deadlock, attempt $i");
            sleep($i*rand(2, 5)); // Wait longer as attempts increase
        }
        $QueryEndTime=microtime(true);
        $this->Queries[]=array(display_str($Query),($QueryEndTime-$QueryStartTime)*1000);
        $this->Time+=($QueryEndTime-$QueryStartTime)*1000;

        if (!$this->QueryID) {
            $this->Errno = mysqli_errno($this->LinkID);
            $this->Error = mysqli_error($this->LinkID);

            if ($AutoHandle) {
                $this->halt('Invalid Query: '.$Query);
            } else {
                return $this->Errno;
            }
        }

        $QueryType = substr($Query,0, 6);
        $this->Row = 0;
        if ($AutoHandle) { return $this->QueryID; }
    }

    public function query_unb($Query)
    {
        $this->connect();
        mysqli_real_query($this->LinkID,$Query);
    }

    public function inserted_id()
    {
        if ($this->LinkID) {
            return mysqli_insert_id($this->LinkID);
        }
    }

    public function next_record($Type=MYSQLI_BOTH, $Escape = true) { // $Escape can be true, false, or an array of keys to not escape
        if ($this->LinkID) {
            $this->Record = mysqli_fetch_array($this->QueryID,$Type);
            $this->Row++;
            if (!is_array($this->Record)) {
                $this->QueryID = FALSE;
            } elseif ($Escape !== FALSE) {
                $this->Record = display_array($this->Record, $Escape);
            }

            return $this->Record;
        }
    }

    public function close()
    {
        if ($this->LinkID) {
            if (!mysqli_close($this->LinkID)) {
                $this->halt('Cannot close connection or connection did not open.');
            }
            $this->LinkID = FALSE;
        }
    }

    public function record_count()
    {
        if ($this->QueryID) {
            return mysqli_num_rows($this->QueryID);
        }
    }

    public function affected_rows()
    {
        if ($this->LinkID) {
            return mysqli_affected_rows($this->LinkID);
        }
    }

    public function info()
    {
        return mysqli_get_host_info($this->LinkID);
    }

    // You should use db_string() instead.
    public function escape_str($Str)
    {
        $this->connect(0);
        if (is_array($Str)) {
            trigger_error('Attempted to escape array.');

            return '';
        }

        return mysqli_real_escape_string($this->LinkID,$Str);
    }

    // Creates an array from a result set
    // If $Key is set, use the $Key column in the result set as the array key
    // Otherwise, use an integer
    public function to_array($Key = false, $Type = MYSQLI_BOTH, $Escape = true)
    {
        $Return = array();
        while ($Row = mysqli_fetch_array($this->QueryID,$Type)) {
            if ($Escape!==FALSE) {
                $Row = display_array($Row, $Escape);
            }
            if ($Key !== false) {
                $Return[$Row[$Key]] = $Row;
            } else {
                $Return[]=$Row;
            }
        }
        mysqli_data_seek($this->QueryID, 0);

        return $Return;
    }

    //  Loops through the result set, collecting the $Key column into an array
    public function collect($Key, $Escape = true)
    {
        $Return = array();
        while ($Row = mysqli_fetch_array($this->QueryID)) {
            $Return[] = $Escape ? display_str($Row[$Key]) : $Row[$Key];
        }
        mysqli_data_seek($this->QueryID, 0);

        return $Return;
    }

    public function set_query_id(&$ResultSet)
    {
        $this->QueryID = $ResultSet;
        $this->Row = 0;
    }

    public function beginning()
    {
        mysqli_data_seek($this->QueryID, 0);
    }

}
