<?php

class tastywiApi {

    private $key;
    private $hostname;
    private $http;
    private $port = 2443;

    public function __construct($key, $http, $hostname, $port) {
        $this->key = $key;
        $this->http = $http;
        $this->hostname = $hostname;
        $this->port = $port;
    }

    private function doTheConnect($api_controller, $action, array $input = NULL) {
        $client = new SoapClient("{$this->http}://{$this->hostname}:{$this->port}/soap?wsdl");

        $result = $client->route($this->key, $api_controller, $action, $input);

        return $result;
    }

    private function doTheConnectSiteWorx($api_controller, $email, $password, $domain, $action, array $input = NULL) {
        $key = array(
            'email' => $email,
            'password' => $password,
            'domain' => $domain
        );
        $client = new SoapClient("{$this->http}://{$this->hostname}:{$this->port}/soap?wsdl");

        $result = $client->route($key, $api_controller, $action, $input);

        return $result;
    }

    public function connectTester() {

        $results = $this->doTheConnect("/nodeworx/users", "listWorkingUser", array("perms" => array("NODEWORXUSER")));

//        if (!empty($results->response["userid"]) && is_int($results->response["userid"])) {
//            return $this->getResponse(true);
//        }
        $object = json_decode(json_encode($results), True);
        if ($object['status'] === 0) {
            return 0;
        } else {
            return 1;
        }
    }

    public function listPackages() {

        $results = $this->doTheConnect("/nodeworx/packages", "listPackages", array());

        $object = json_decode(json_encode($results), TRUE);
        return $object;
    }

    public function listAccounts() {

        $results = $this->doTheConnect("/nodeworx/siteworx", "listAccounts", array("perms" => array("SWACCOUNTS")));

        $object = json_decode(json_encode($results), True);
        return $object;
    }

    public function makeSiteWorxLogin($domain) {

        $results = $this->doTheConnect("/nodeworx/siteworx", "siteworxLogin", array("perms" => array("SWACCOUNTS"), 'login_domain' => "{$domain}", 'siteworxLogin|edit'));

        $object = json_decode(json_encode($results), True);
        return $object;
    }

    public function listFtpAccounts($email, $password, $domain) {
        $results = $this->doTheConnectSiteWorx("/siteworx/ftp", $email, $password, $domain, "listFtpAccounts", array("perms" => array("FTP")));

        $object = json_decode(json_encode($results), True);
        return $object;
    }

    public function addFtpAccount($email, $password, $domain, $input) {
        $input = array(
            'user' => $input['user'],
            'password' => $input['password'],
            'confirm_password' => $input['password'],
            'homedir' => $input['homedir'],
            "perms" => array("FTP")
        );
        $results = $this->doTheConnectSiteWorx("/siteworx/ftp", $email, $password, $domain, "add", $input);

        $object = json_decode(json_encode($results), True);
        return $object;
    }

    public function DeleteFtpAccount($email, $password, $domain, $input) {
        $input = array(
            'user' => $input['user'],
            "perms" => array("FTP")
        );
        $results = $this->doTheConnectSiteWorx("/siteworx/ftp", $email, $password, $domain, "delete", $input);

        $object = json_decode(json_encode($results), True);
        return $object;
    }

    public function listBackups($email, $password, $domain) {
        $results = $this->doTheConnectSiteWorx("/siteworx/backup", $email, $password, $domain, "listAllBackups", array("perms" => array("BACKUP")));

        $object = json_decode(json_encode($results), True);
        return $object;
    }

    public function createBackup($email, $password, $domain, $input) {
        $input = array(
            'type' => $input['type'],
            'location' => $input['location'],
            'email_address' => $input['email_address'],
            "perms" => array("BACKUP")
        );
        $results = $this->doTheConnectSiteWorx("/siteworx/backup", $email, $password, $domain, "create", $input);

        $object = json_decode(json_encode($results), True);
        return $object;
    }

    public function restoreBackup($email, $password, $domain, $input) {
        $input = array(
            'filetype' => $input['filetype'],
            'file' => $input['file'],
            "perms" => array("BACKUP")
        );
        $results = $this->doTheConnectSiteWorx("/siteworx/backup", $email, $password, $domain, "restore", $input);

        $object = json_decode(json_encode($results), True);
        return $object;
    }

    public function deleteBackup($email, $password, $domain, $input) {
        $input = array(
            'backups' => $input['backups'],
            "perms" => array("BACKUP")
        );
        $results = $this->doTheConnectSiteWorx("/siteworx/backup", $email, $password, $domain, "delete", $input);

        $object = json_decode(json_encode($results), True);
        return $object;
    }

    public function createBackupSchedule($email, $password, $domain, $input) {
        $input = array(
            'frequency' => $input['frequency'],
            'type' => $input['type'],
            'location' => $input['location'],
            'email_address' => $input['email_address'],
            'rotate' => $input['rotate'],
            'hour' => $input['hour'],
            'day_of_week' => $input['day_of_week'],
            'day_of_month' => $input['day_of_month'],
            "perms" => array("BACKUP")
        );
        $results = $this->doTheConnectSiteWorx("/siteworx/backup/schedule", $email, $password, $domain, "create", $input);

        $object = json_decode(json_encode($results), True);
        return $object;
    }

    public function listBackupSchedule($email, $password, $domain) {
        $results = $this->doTheConnectSiteWorx("/siteworx/backup/schedule", $email, $password, $domain, "listScheduled", array("perms" => array("BACKUP")));

        $object = json_decode(json_encode($results), True);
        return $object;
    }

    public function listCron($email, $password, $domain) {
        $results = $this->doTheConnectSiteWorx("/siteworx/cron", $email, $password, $domain, "list", array("perms" => array("CRONTAB")));

        $object = json_decode(json_encode($results), True);
        return $object;
    }

    public function addCron($email, $password, $domain, $input) {
        $input = array(
            'minute' => $input['minute'],
            'hour' => $input['hour'],
            'day' => $input['day'],
            'month' => $input['month'],
            'dayofweek' => $input['dayofweek'],
            'script' => $input['script'],
            "perms" => array("CRONTAB")
        );
        $results = $this->doTheConnectSiteWorx("/siteworx/cron", $email, $password, $domain, "add", $input);

        $object = json_decode(json_encode($results), True);
        return $object;
    }

    public function deleteCron($email, $password, $domain, $input) {
        $input = array(
            'jobs' => $input['jobs'],
            "perms" => array("CRONTAB")
        );
        $results = $this->doTheConnectSiteWorx("/siteworx/cron", $email, $password, $domain, "delete", $input);

        $object = json_decode(json_encode($results), True);
        return $object;
    }

    public function listEmailBoxes($email, $password, $domain) {
        $results = $this->doTheConnectSiteWorx("/siteworx/email/box", $email, $password, $domain, "listEmailBoxes", array("perms" => array("EMAIL")));

        $object = json_decode(json_encode($results), True);
        return $object;
    }

    public function addEmailBox($email, $password, $domain, $input) {
        $input = array(
            'username' => $input['email'],
            'password' => $input['password'],
            'confirm_password' => $input['password'],
            'diskspacequota' => $input['quota'],
            "perms" => array("EMAIL")
        );
        $results = $this->doTheConnectSiteWorx("/siteworx/email/box", $email, $password, $domain, "add", $input);

        $object = json_decode(json_encode($results), True);
        return $object;
    }

    public function editEmailBox($email, $password, $domain, $input) {
        $input = array(
            'username' => $input['email'],
            'password' => $input['password'],
            'confirm_password' => $input['password'],
            "perms" => array("EMAIL")
        );
        $results = $this->doTheConnectSiteWorx("/siteworx/email/box", $email, $password, $domain, "edit", $input);

        $object = json_decode(json_encode($results), True);
        return $object;
    }

    public function deleteEmailBox($email, $password, $domain, $input) {
        $input = array(
            'username' => $input['username'],
            "perms" => array("EMAIL")
        );
        $results = $this->doTheConnectSiteWorx("/siteworx/email/box", $email, $password, $domain, "delete", $input);

        $object = json_decode(json_encode($results), True);
        return $object;
    }

    public function listEmailAlias($email, $password, $domain) {
        $results = $this->doTheConnectSiteWorx("/siteworx/email/alias", $email, $password, $domain, "listEmailAliases", array("perms" => array("EMAIL")));

        $object = json_decode(json_encode($results), True);
        return $object;
    }

    public function addEmailAlias($email, $password, $domain, $input) {
        $input = array(
            'username' => $input['email'],
            'forwardsto' => $input['destination'],
            "perms" => array("EMAIL")
        );
        $results = $this->doTheConnectSiteWorx("/siteworx/email/alias", $email, $password, $domain, "add", $input);

        $object = json_decode(json_encode($results), True);
        return $object;
    }

    public function deleteEmailAlias($email, $password, $domain, $input) {
        $input = array(
            'username' => $input['username'],
            "perms" => array("EMAIL")
        );
        $results = $this->doTheConnectSiteWorx("/siteworx/email/alias", $email, $password, $domain, "delete", $input);

        $object = json_decode(json_encode($results), True);
        return $object;
    }

    public function listAddonDomains($email, $password, $domain) {
        $results = $this->doTheConnectSiteWorx("/siteworx/domains/slave", $email, $password, $domain, "listSecondaryDomains", array("perms" => array("SLAVEDOMS")));

        $object = json_decode(json_encode($results), True);
        return $object;
    }

    public function addAddonDomains($email, $password, $domain, $input) {
        $input = array(
            'domain' => $input['domain'],
            "perms" => array("SLAVEDOMS")
        );
        $results = $this->doTheConnectSiteWorx("/siteworx/domains/slave", $email, $password, $domain, "add", $input);

        $object = json_decode(json_encode($results), True);
        return $object;
    }

    public function deleteAddonDomains($email, $password, $domain, $input) {
        $input = array(
            'domain' => $input['domain'],
            "perms" => array("SLAVEDOMS")
        );
        $results = $this->doTheConnectSiteWorx("/siteworx/domains/slave", $email, $password, $domain, "delete", $input);

        $object = json_decode(json_encode($results), True);
        return $object;
    }

    public function listSubDomains($email, $password, $domain) {
        $results = $this->doTheConnectSiteWorx("/siteworx/domains/sub", $email, $password, $domain, "listSubdomains", array("perms" => array("SUBDOMAINS")));

        $object = json_decode(json_encode($results), True);
        return $object;
    }

    public function addSubDomains($email, $password, $domain, $input) {
        $input = array(
            'prefix' => $input['prefix'],
            "perms" => array("SUBDOMAINS")
        );
        $results = $this->doTheConnectSiteWorx("/siteworx/domains/sub", $email, $password, $domain, "add", $input);

        $object = json_decode(json_encode($results), True);
        return $object;
    }

    public function deleteSubDomains($email, $password, $domain, $input) {
        $input = array(
            'prefix' => $input['prefix'],
            "perms" => array("SUBDOMAINS")
        );
        $results = $this->doTheConnectSiteWorx("/siteworx/domains/sub", $email, $password, $domain, "delete", $input);

        $object = json_decode(json_encode($results), True);
        return $object;
    }

    public function listDomainsRedirects($email, $password, $domain) {
        $results = $this->doTheConnectSiteWorx("/siteworx/domains/pointer", $email, $password, $domain, "listPointerDomains", array("perms" => array("POINTERDOMS")));

        $object = json_decode(json_encode($results), True);
        return $object;
    }

    public function addDomainsRedirects($email, $password, $domain, $input) {
        $input = array(
            'domain' => $input['domain'],
            'redir_type' => $input['redir_type'],
            'points_to' => $input['points_to'],
            "perms" => array("POINTERDOMS")
        );
        $results = $this->doTheConnectSiteWorx("/siteworx/domains/pointer", $email, $password, $domain, "add", $input);

        $object = json_decode(json_encode($results), True);
        return $object;
    }

    public function deleteDomainsRedirects($email, $password, $domain, $input) {
        $input = array(
            'domain' => $input['domain'],
            "perms" => array("POINTERDOMS")
        );
        $results = $this->doTheConnectSiteWorx("/siteworx/domains/pointer", $email, $password, $domain, "delete", $input);

        $object = json_decode(json_encode($results), True);
        return $object;
    }

    public function listDatabases($email, $password, $domain) {
        $results = $this->doTheConnectSiteWorx("/siteworx/mysql/db", $email, $password, $domain, "listMysqlDatabases", array("perms" => array("MYSQL")));

        $object = json_decode(json_encode($results), True);
        return $object;
    }

    public function addDatabases($email, $password, $domain, $input) {
        $input = array(
            'name' => $input['name']
        );
        $results = $this->doTheConnectSiteWorx("/siteworx/mysql/db", $email, $password, $domain, "add", $input);

        $object = json_decode(json_encode($results), True);
        return $object;
    }

    public function deleteDatabases($email, $password, $domain, $input) {
        $input = array(
            'name' => $input['name']
        );
        $results = $this->doTheConnectSiteWorx("/siteworx/mysql/db", $email, $password, $domain, "delete", $input);

        $object = json_decode(json_encode($results), True);
        return $object;
    }

    public function listDBUser($email, $password, $domain) {
        $results = $this->doTheConnectSiteWorx("/siteworx/mysql/user", $email, $password, $domain, "listMysqlUsers", array("perms" => array("MYSQL")));

        $object = json_decode(json_encode($results), True);
        return $object;
    }

    public function addDBUser($email, $password, $domain, $input) {
        $input = array(
            'name' => $input['name'],
            'password' => $input['password'],
            'confirm_password' => $input['password'],
            "perms" => array("MYSQL")
        );
        $results = $this->doTheConnectSiteWorx("/siteworx/mysql/user", $email, $password, $domain, "add", $input);

        $object = json_decode(json_encode($results), True);
        return $object;
    }

    public function editDBUser($email, $password, $domain, $input) {
        $input = array(
            'name' => $input['name'],
            'password' => $input['password'],
            'confirm_password' => $input['password'],
            "perms" => array("MYSQL")
        );
        $results = $this->doTheConnectSiteWorx("/siteworx/mysql/user", $email, $password, $domain, "edit", $input);

        $object = json_decode(json_encode($results), True);
        return $object;
    }

    public function deleteDBUser($email, $password, $domain, $input) {
        $input = array(
            'name' => $input['name'],
            "perms" => array("MYSQL")
        );
        $results = $this->doTheConnectSiteWorx("/siteworx/mysql/user", $email, $password, $domain, "delete", $input);

        $object = json_decode(json_encode($results), True);
        return $object;
    }

    public function addUserPerm($email, $password, $domain, $input) {
        $input = array(
            'name' => $input['name'],
            'user' => $input['user']
        );
        $results = $this->doTheConnectSiteWorx("/siteworx/mysql/perms", $email, $password, $domain, "add", $input);

        $object = json_decode(json_encode($results), True);
        return $object;
    }

    public function getSiteworxAccountInfo($domain) {

        $results = $this->doTheConnect("/nodeworx/siteworx", "querySiteworxAccountDetails", array("perms" => array("SWACCOUNTS"), 'domain' => "{$domain}"));

        $object = json_decode(json_encode($results), True);
        return $object;
    }

    public function getResellerAccountInfo($domain) {

        $results = $this->doTheConnect("/nodeworx/reseller", "queryResellerDetails", array("perms" => array("RESELLER"), 'reseller' => "{$domain}"));

        $object = json_decode(json_encode($results), True);
        return $object;
    }

    public function listResellerPackages() {

        $results = $this->doTheConnect("/nodeworx/reseller/packages", "listResellerPackages", array("perms" => array("RESELLER")));

        $object = json_decode(json_encode($results), true);
        return $object;
    }

    public function listResellerAccounts() {

        $results = $this->doTheConnect("/nodeworx/reseller", "listResellers", array("perms" => array("RESELLER")));

        $object = json_decode(json_encode($results), true);
        return $object;
    }

    public function userIsReseller() {

        $input = array("perms" => array("NODEWORXUSER"));
        $results = $this->doTheConnect("/nodeworx/users", "isReseller", $input);
        $object = json_decode(json_encode($results), True);

        if ($object['status'] !== TRUE) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function createSiteWorxAccount(array $input = NULL) {
        $fields = array(
            'domainname' => $input['domain'],
            'ipaddress' => $this->listIps(),
            'uniqname' => $input['username'],
            'nickname' => $input['username'],
            'email' => $input['email'],
            'password' => $input['password'],
            'confirm_password' => $input['password'],
            'packagetemplate' => $input['plan'],
            'perms' => "SWACCOUNTS"
        );
        $results = $this->doTheConnect("/nodeworx/siteworx", "add", $fields);
        $object = json_decode(json_encode($results), True);
        return $object;
    }

    public function suspendedSiteWorxAccount($input = NULL) {
        $fields = array(
            'domain' => $input,
            'perms' => "SWACCOUNTS"
        );
        $results = $this->doTheConnect("/nodeworx/siteworx", "suspend", $fields);
        $object = json_decode(json_encode($results), True);
        return $object;
    }

    public function unsuspendSiteWorxAccount($input = NULL) {
        $fields = array(
            'domain' => $input,
            'perms' => "SWACCOUNTS"
        );
        $results = $this->doTheConnect("/nodeworx/siteworx", "unsuspend", $fields);
        $object = json_decode(json_encode($results), True);
        return $object;
    }

    public function deleteSiteWorxAccount($input = NULL) {
        $fields = array(
            'domain' => $input,
            'perms' => "SWACCOUNTS"
        );
        $results = $this->doTheConnect("/nodeworx/siteworx", "delete", $fields);
        $object = json_decode(json_encode($results), True);
        return $object;
    }

    public function editSiteWorxAccount(array $input = NULL) {
        $fields = array(
            'domain' => $input['domain'],
            'nickname' => $input['nickname'],
            'email' => $input['email'],
            'password' => $input['password'],
            'confirm_password' => $input['password'],
            'perms' => "SWACCOUNTS"
        );
        $results = $this->doTheConnect("/nodeworx/siteworx", "edit", $fields);
        $object = json_decode(json_encode($results), True);
        return $object;
    }

    public function createResellerAccount(array $input = NULL) {
        $fields = array(
            'ips' => $this->listIps(),
            'uniqname' => $input['username'],
            'nickname' => $input['username'],
            'email' => $input['email'],
            'password' => $input['password'],
            'confirm_password' => $input['password'],
            'packagetemplate' => $input['plan'],
            "status" => "active",
            'perms' => "RESELLER"
        );
        $results = $this->doTheConnect("/nodeworx/reseller", "add", $fields);
        $object = json_decode(json_encode($results), True);
        return $object;
    }

    public function suspendedResellerAccount($input = NULL) {
        $fields = array(
            'reseller_id' => $input,
            'status' => "inactive",
            'perms' => "RESELLER"
        );
        $results = $this->doTheConnect("/nodeworx/reseller", "edit", $fields);
        $object = json_decode(json_encode($results), True);
        return $object;
    }

    public function unsuspendResellerAccount($input = NULL) {
        $fields = array(
            'reseller_id' => $input,
            'status' => "active",
            'perms' => "RESELLER"
        );
        $results = $this->doTheConnect("/nodeworx/reseller", "edit", $fields);
        $object = json_decode(json_encode($results), True);
        return $object;
    }

    public function deleteResellerAccount($input = NULL) {
        $fields = array(
            'reseller_id' => $input,
            'perms' => "RESELLER"
        );
        $results = $this->doTheConnect("/nodeworx/reseller", "delete", $fields);
        $object = json_decode(json_encode($results), True);
        return $object;
    }

    public function editResellerAccount(array $input = NULL) {
        $fields = array(
            'reseller_id' => $input['reseller_id'],
            'nickname' => $input['nickname'],
            'email' => $input['email'],
            'password' => $input['password'],
            'confirm_password' => $input['password'],
            'perms' => "RESELLER"
        );
        $results = $this->doTheConnect("/nodeworx/reseller", "edit", $fields);
        $object = json_decode(json_encode($results), True);
        return $object;
    }

    public function listIps() {
        $ips = $this->doTheConnect("/nodeworx/siteworx", "listFreeIps", array("perms" => array("SWACCOUNTS")));
        $object = json_decode(json_encode($ips), True);
        foreach ($object['payload'] as $ip) {
            if (isset($ip[1]) && strpos(strtolower($ip[1]), "shared")) {
                $return_ip = $ip[0];
                break;
            } else {
                $return_ip = NULL;
            }
        }
        return $return_ip;
    }

}
