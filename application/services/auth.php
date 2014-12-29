<?php
namespace gazelle\services;

use gazelle\core\Master;
use gazelle\errors\ConfigurationError;

class Auth extends Service {

    protected $encryption_key;
    protected $UserID = null;
    protected $SessionID = null;
    protected $UserSessions = null;

    public function __construct(Master $master) {
        parent::__construct($master);
        if (!extension_loaded('mcrypt')) {
            throw new SystemError('Mcrypt Extension not loaded.');
        }
        $this->cache = $this->master->cache;
        $this->olddb = $this->master->olddb;
        $this->encryption_key = $this->master->settings->keys->enckey;
        if (!strlen($this->encryption_key)) {
            throw new ConfigurationError('No encryption key set!');
        }
    }

    public function encrypt($Str,$Key=null) {
        if (is_null($Key)) {
            $Key = $this->encryption_key;
        }
        srand();
        $Str=str_pad($Str, 32-strlen($Str));
        $IVSize=mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
        $IV=mcrypt_create_iv($IVSize, MCRYPT_RAND);
        $CryptStr=mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $Key, $Str, MCRYPT_MODE_CBC, $IV);

        return base64_encode($IV.$CryptStr);
    }

    public function decrypt($CryptStr,$Key=null) {
        if (is_null($Key)) {
            $Key = $this->encryption_key;
        }
        if ($CryptStr!='') {
            $IV=substr(base64_decode($CryptStr),0,16);
            $CryptStr=substr(base64_decode($CryptStr),16);

            return trim(mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $Key, $CryptStr, MCRYPT_MODE_CBC,$IV));
        } else {
            return '';
        }
    }

    protected function get_user_sessions($UserID) {
        $UserSessions = $this->cache->get_value('users_sessions_' . $UserID);
        if (!is_array($UserSessions)) {
            $this->olddb->query("SELECT
                SessionID,
                Browser,
                OperatingSystem,
                IP,
                LastUpdate
                FROM users_sessions
                WHERE UserID='{$UserID}'
                AND Active = 1
                ORDER BY LastUpdate DESC");
            $UserSessions = $this->olddb->to_array('SessionID', MYSQLI_ASSOC);
            $this->cache->cache_value('users_sessions_' . $UserID, $UserSessions, 0);
        }
        return $UserSessions;
    }

    protected function get_enabled($UserID) {
            $Enabled = $this->cache->get_value('enabled_' . $UserID);
            if ($Enabled === false) {
                $this->olddb->query("SELECT Enabled FROM users_main WHERE ID='{$UserID}'");
                list($Enabled) = $this->olddb->next_record();
                $this->cache->cache_value('enabled_' . $UserID, $Enabled, 0);
            }
            return $Enabled;
    }

    public function load_session() {
        if (isset($this->master->cookie['session'])) {
            $LoginCookie = $this->decrypt($this->master->cookie['session']);
        }
        if (isset($LoginCookie)) {
            list($this->SessionID, $UserID) = explode("|~|", $this->decrypt($LoginCookie));
            $this->UserID = intval($UserID);
            
            if (!$this->UserID || !$this->SessionID) {
                $this->logout();
            }

            $this->UserSessions = $this->get_user_sessions($this->UserID);
            if (!array_key_exists($this->SessionID, $this->UserSessions)) {
                $this->logout();
            }

            $Enabled = $this->get_enabled($this->UserID);
            if ($Enabled == 2) {
                $this->logout();
            }
        }
        return array($this->UserID, $this->SessionID, $this->UserSessions, $this->Enabled);
    }

    public function session_update($ip, $browser, $operating_system) {
        if (strtotime($this->UserSessions[$this->SessionID]['LastUpdate']) + 600 < time()) {
            $this->olddb->query("UPDATE users_main SET LastAccess='" . sqltime() . "' WHERE ID='{$this->UserID}'");
            $this->olddb->query("UPDATE users_sessions SET IP='{$ip}', Browser='{$browser}', OperatingSystem='{$operating_system}', LastUpdate='" . sqltime() . "' WHERE UserID='{$this->UserID}' AND SessionID='" . db_string($this->SessionID) . "'");
            $this->cache->begin_transaction('users_sessions_' . $this->UserID);
            $this->cache->delete_row($this->SessionID);
            $this->cache->insert_front($this->SessionID, array(
                'SessionID' => $this->SessionID,
                'Browser' => $browser,
                'OperatingSystem' => $operating_system,
                'IP' => $ip,
                'LastUpdate' => sqltime()
            ));
            $this->cache->commit_transaction(0);
        }
    }

    public function logout() {
        setcookie('session', '', time() - 60 * 60 * 24 * 365, '/', '', false);
        setcookie('keeplogged', '', time() - 60 * 60 * 24 * 365, '/', '', false);
        setcookie('session', '', time() - 60 * 60 * 24 * 365, '/', '', false);
        if ($this->SessionID) {
            $this->olddb->query("DELETE FROM users_sessions WHERE UserID='{$this->UserID}' AND SessionID='" . db_string($this->SessionID) . "'");
            $this->cache->begin_transaction('users_sessions_' . $this->UserID);
            $this->cache->delete_row($this->SessionID);
            $this->cache->commit_transaction(0);
        }
        $this->cache->delete_value('user_info_' . $this->UserID);
        $this->cache->delete_value('user_stats_' . $this->UserID);
        $this->cache->delete_value('user_info_heavy_' . $this->UserID);

        header('Location: login.php');

        die();
    }

}
