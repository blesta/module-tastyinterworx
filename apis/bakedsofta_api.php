<?php

class bakedSoftaAPI {

    private $curl_error;
    private $curl_error_2;
    private $loginparams;
    private $https;
    private $hostname;
    private $port;
    var $error = array();

    public function __construct(array $loginparams, $https, $hostname, $port) {
        $this->loginparams = $loginparams;
        $this->https = $https;
        $this->hostname = $hostname;
        $this->port = $port;
    }

    private function makeTheConnection($softa_action, $data = NULL) {
        $parsed_parms = array(
            'email' => $this->loginparams['email'],
            'password' => $this->loginparams['password'],
            'domain' => $this->loginparams['domain'],
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "{$this->https}://{$this->hostname}:{$this->port}/siteworx/?action=login");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $parsed_parms);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_COOKIESESSION, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_COOKIEJAR, '');
        curl_setopt($ch, CURLOPT_COOKIEFILE, '');
        $answer = curl_exec($ch);
        if (curl_error($ch)) {
            $this->curl_error = curl_error($ch);
        }

        curl_setopt($ch, CURLOPT_URL, "{$this->https}://{$this->hostname}:{$this->port}/siteworx/softaculous?api=json&{$softa_action}");
        if (empty($data)) {
            curl_setopt($ch, CURLOPT_POST, false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, "");
        } else {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        }
        $snww = curl_exec($ch);
        if (curl_error($ch)) {
            $this->curl_error_2 = curl_error($ch);
        }
        $response = json_decode($snww, true);

        return $response;
    }

    public function list_backups() {
        return $this->makeTheConnection("act=backups");
    }

    public function remove_backup($backup_file) {
        return $this->makeTheConnection("act=backups&remove={$backup_file}");
    }

    public function backup($insid, $data = array()) {
        $data['backupins'] = 1;
        return $this->makeTheConnection("act=backup&insid={$insid}", $data);
    }

    public function restoreBackup($name, $data = array()) {
        $data['restore_ins'] = 1;
        return $this->makeTheConnection("act=restore&restore={$name}", $data);
    }

    public function list_scripts() {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => 'http://api.softaculous.com/scripts.php?in=serialize'
        ));
        $resp = curl_exec($curl);
        curl_close($curl);
        $scripts = unserialize($resp);

        if (empty($scripts)) {
            return false;
        } else {
            return $scripts;
        }
    }

    public function list_installed_apps() {
        return $this->makeTheConnection("act=installations");
    }

    public function install($sid, $data = array(), $autoinstall = array()) {

        $get_scripts = $this->list_scripts();

        if ($get_scripts[$sid]['type'] == 'js') {
            $act = 'act=js&soft=' . $sid;
        } elseif ($get_scripts[$sid]['type'] == 'perl') {
            $act = 'act=perl&soft=' . $sid;
        } elseif ($get_scripts[$sid]['type'] == 'java') {
            $act = 'act=java&soft=' . $sid;
        } else {
            $act = 'act=software&soft=' . $sid;
        }
        if (!empty($autoinstall)) {
            $act = $act . '&autoinstall=' . rawurlencode(base64_encode(serialize($autoinstall)));
        }
        $data['softsubmit'] = 1;
        return $this->makeTheConnection($act, $data);
    }

    function removeInstall($insid, $data = array()) {
        $data['removeins'] = 1;
        return $this->makeTheConnection("act=remove&insid={$insid}", $data);
    }

    public function upgradeInstall($insid, $data = array()) {
        if (!empty($data)) {
            $data['softsubmit'] = 1;
        }
        return $this->makeTheConnection("act=upgrade&insid={$insid}", $data);
    }

}
