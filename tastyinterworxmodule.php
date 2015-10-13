<?php

class Tastyinterworxmodule extends Module {

    private static $version = "1.2.2";
    private static $authors = array(array('name' => "ModulesBakery.com.", 'url' => "http://www.modulesbakery.com"));

    public function __construct() {
        Loader::loadComponents($this, array("Input"));
        Language::loadLang("tastyinterworx_lang", null, dirname(__FILE__) . DS . "language" . DS);
        Loader::loadHelpers($this, array("Html"));
    }

    public function getName() {
        return Language::_("tastyinterworx.name", true);
    }

    public function getVersion() {
        return self::$version;
    }

    public function getAuthors() {
        return self::$authors;
    }

    public function getAdminTabs($package) {
        return array();
    }

    public function customStyleJS() {
        $webdir = WEBDIR;
        return "\n<script type='text/javascript' src='{$webdir}components/modules/tastyinterworxmodule/views/default/main.js'></script>
            \n<link href='{$webdir}components/modules/tastyinterworxmodule/views/default/style.css' rel='stylesheet' type='text/css' />
            ";
    }

    public function getClientTabs($package) {
        if ($package->meta->accountusage === "true") {
            $clienttabs['accountusage'] = array(
                "name" => Language::_("tastyinterworx.accountusage", true),
                "icon" => "fa fa-bar-chart",
            );
        }
        if ($package->meta->changepassword === "true") {
            $clienttabs['changepassword'] = array(
                "name" => Language::_("tastyinterworx.changepassword", true),
                "icon" => "fa fa-key",
            );
        }
        if ($package->meta->type === "standard") {
            if ($package->meta->email === "true") {
                $clienttabs['email'] = array(
                    "name" => Language::_("tastyinterworx.email", true),
                    "icon" => "fa fa-at",
                );
            }
            if ($package->meta->emailalias === "true") {
                $clienttabs['emailalias'] = array(
                    "name" => Language::_("tastyinterworx.emailalias", true),
                    "icon" => "fa fa-share",
                );
            }
            if ($package->meta->ftpaccounts === "true") {
                $clienttabs['ftpaccounts'] = array(
                    "name" => Language::_("tastyinterworx.ftpaccounts", true),
                    "icon" => "fa fa-upload",
                );
            }
            if ($package->meta->subdomains === "true") {
                $clienttabs['subdomains'] = array(
                    "name" => Language::_("tastyinterworx.subdomains", true),
                    "icon" => "fa fa-globe",
                );
            }
            if ($package->meta->secondarydomains === "true") {
                $clienttabs['secondarydomains'] = array(
                    "name" => Language::_("tastyinterworx.secondarydomains", true),
                    "icon" => "fa fa-globe",
                );
            }
            if ($package->meta->pointerdomains === "true") {
                $clienttabs['pointerdomains'] = array(
                    "name" => Language::_("tastyinterworx.pointerdomains", true),
                    "icon" => "fa fa-globe",
                );
            }
            if ($package->meta->databases === "true") {
                $clienttabs['databases'] = array(
                    "name" => Language::_("tastyinterworx.databases", true),
                    "icon" => "fa fa-database",
                );
            }
            if ($package->meta->cronjobs === "true") {
                $clienttabs['cronjobs'] = array(
                    "name" => Language::_("tastyinterworx.cronjobs", true),
                    "icon" => "fa fa-list-alt",
                );
            }
            if ($package->meta->backups === "true") {
                $clienttabs['backups'] = array(
                    "name" => Language::_("tastyinterworx.backups", true),
                    "icon" => "fa fa-hdd-o",
                );
            }
            if ($package->meta->manageapps !== "false") {
                $clienttabs['manageapps'] = array(
                    "name" => Language::_("tastyinterworx.manageapps", true),
                    "icon" => "fa fa-cogs",
                );
            }
        }
        return $clienttabs;
    }

    public function databases($package, $service, array $get = null, array $post = null, array $files = null) {
        if ($package->meta->databases === "true") {
            if (isset($get[2])) {
                if ($get[2] === "addnewdb") {
                    return $this->databasesaddnewdb($package, $service, $get, $post, $files);
                } else if ($get[2] === "addnewdbuser") {
                    return $this->databasesaddnewdbuser($package, $service, $get, $post, $files);
                } else if ($get[2] === "changepass") {
                    return $this->databaseschangepass($package, $service, $get, $post, $files);
                } else if ($get[2] === "addusertodb") {
                    return $this->databasesaddusertodb($package, $service, $get, $post, $files);
                }
            } else {
                return $this->databasesmain($package, $service, $get, $post, $files);
            }
        }
    }

    public function manageapps($package, $service, array $get = null, array $post = null, array $files = null) {
        if ($package->meta->manageapps !== "false") {
            if (isset($get[2])) {
                if ($get[2] === "installapps") {
                    return $this->manageappsaddnew($package, $service, $get, $post, $files);
                }
            } else {
                return $this->manageappsmain($package, $service, $get, $post, $files);
            }
        }
    }

    public function backups($package, $service, array $get = null, array $post = null, array $files = null) {
        if ($package->meta->backups === "true") {
            if (isset($get[2])) {
                if ($get[2] === "addnew") {
                    return $this->backupsaddnew($package, $service, $get, $post, $files);
                } else if ($get[2] === "addnewsch") {
                    return $this->backupsaddnewsch($package, $service, $get, $post, $files);
                }
            } else {
                return $this->backupsmain($package, $service, $get, $post, $files);
            }
        }
    }

    public function cronjobs($package, $service, array $get = null, array $post = null, array $files = null) {
        if ($package->meta->cronjobs === "true") {
            if (isset($get[2])) {
                if ($get[2] === "addnew") {
                    return $this->cronjobsaddnew($package, $service, $get, $post, $files);
                }
            } else {
                return $this->cronjobsmain($package, $service, $get, $post, $files);
            }
        }
    }

    public function pointerdomains($package, $service, array $get = null, array $post = null, array $files = null) {
        if ($package->meta->pointerdomains === "true") {
            if (isset($get[2])) {
                if ($get[2] === "addnew") {
                    return $this->pointerdomainsaddnew($package, $service, $get, $post, $files);
                }
            } else {
                return $this->pointerdomainsmain($package, $service, $get, $post, $files);
            }
        }
    }

    public function secondarydomains($package, $service, array $get = null, array $post = null, array $files = null) {
        if ($package->meta->secondarydomains === "true") {
            if (isset($get[2])) {
                if ($get[2] === "addnew") {
                    return $this->secondarydomainsaddnew($package, $service, $get, $post, $files);
                }
            } else {
                return $this->secondarydomainsmain($package, $service, $get, $post, $files);
            }
        }
    }

    public function subdomains($package, $service, array $get = null, array $post = null, array $files = null) {
        if ($package->meta->subdomains === "true") {
            if (isset($get[2])) {
                if ($get[2] === "addnew") {
                    return $this->subdomainsaddnew($package, $service, $get, $post, $files);
                }
            } else {
                return $this->subdomainsmain($package, $service, $get, $post, $files);
            }
        }
    }

    public function ftpaccounts($package, $service, array $get = null, array $post = null, array $files = null) {
        if ($package->meta->ftpaccounts === "true") {
            if (isset($get[2])) {
                if ($get[2] === "addnew") {
                    return $this->ftpaccountsaddnew($package, $service, $get, $post, $files);
                }
            } else {
                return $this->ftpaccountsmain($package, $service, $get, $post, $files);
            }
        }
    }

    public function emailalias($package, $service, array $get = null, array $post = null, array $files = null) {
        if ($package->meta->emailalias === "true") {
            if (isset($get[2])) {
                if ($get[2] === "addnew") {
                    return $this->emailaliasaddnew($package, $service, $get, $post, $files);
                }
            } else {
                return $this->emailaliasmain($package, $service, $get, $post, $files);
            }
        }
    }

    public function email($package, $service, array $get = null, array $post = null, array $files = null) {
        if ($package->meta->email === "true") {
            if (isset($get[2])) {
                if ($get[2] === "changepassword") {
                    return $this->emailchangepassword($package, $service, $get, $post, $files);
                } else if ($get[2] === "addnew") {
                    return $this->emailaddnew($package, $service, $get, $post, $files);
                }
            } else {
                return $this->emailmain($package, $service, $get, $post, $files);
            }
        }
    }

    public function databasesaddusertodb($package, $service, array $get = null, array $post = null, array $files = null) {

        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            if (isset($get["user"])) {
                Loader::loadHelpers($this, array("Form", "Html"));
                $service_fields = $this->serviceFieldsToObject($service->fields);
                $module_row = $this->getModuleRow($package->module_row);
                $api = $this->getApi($module_row->meta);
                if (isset($post) && !empty($post)) {
                    if ($post['name'] !== "" && $post['user'] !== "") {
                        Loader::loadModels($this, array("Services"));
                        $add_new = $api->addUserPerm($service_fields->email, $service_fields->password, $service_fields->domain, $post);
                        $this->log($module_row->meta->hostname . "|Change DB User Password", serialize("addUserPerm"), "input", true);
                        if ($add_new['status'] !== 0) {
                            $siteworx_error = str_replace('Please see details below.', '', $add_new['payload']);
                            $siteworx_error = strstr($siteworx_error, "Usage", true);
                            echo "<div class='alert alert-danger alert-dismissable'>
		<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
				<p>{$siteworx_error}</p>
			</div>";
                        } else {
                            echo "<div class='alert alert-success alert-dismissable'>
		<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
				<p>" . Language::_("tastyinterworx.success", true) . "</p>
			</div><script>$(document).ready(function (e) { $('#global_modal').modal('hide');});</script>";
                        }
                    } else {
                        $error = array(
                            0 => array(
                                "result" => Language::_("tastyinterworx.empty_invalid_values", true)
                            )
                        );
                        echo "<div class='alert alert-danger alert-dismissable'>
		<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
				<p>{$error[0]['result']}</p>
			</div>";
                    }
                } else {
                    $customfiles = $this->customStyleJS();
                    $listdatabases = $api->listDatabases($service_fields->email, $service_fields->password, $service_fields->domain);
                    $i = 0;
                    $select_option = "<select name='name' class='form-control' id='name'>";
                    foreach ($listdatabases['payload'] as $sss => $aaa) {
                        $select_option .= "<option value='{$listdatabases['payload'][$i]['name']}'>{$listdatabases['payload'][$i]['fqdn']}</option>";
                        $i++;
                    }
                    $select_option .= "</select>";


                    $this->Form->create("", array('onsubmit' => 'return false', 'id' => 'addform', 'autocomplete' => "off"));
                    echo" {$customfiles}
            <div class='modal-body'>
<div class='div_response'></div>";
                    $this->Form->fieldHidden("user", $this->Html->ifSet($get["user"]), array('id' => "user"));

                    echo'<div class="form-group">
   <label>' . Language::_("tastyinterworx.db.adduser", true) . " " . $get["user"] . " " . Language::_("tastyinterworx.db.to_database", true) . '</label>
' . $select_option . '
</div>
</div>
<div class="modal-footer">
<button type="button" name="cancel" class="btn btn-default" data-dismiss="modal"><i class="fa fa-ban"></i> ' . Language::_("tastyinterworx.cancel", true) . '</button>
<button type="button" class="btn btn-primary" name="add_new" id="addnewsubmit"><i class="fa fa-plus-circle"></i> ' . Language::_("tastyinterworx.submit", true) . '</button>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $("#addnewsubmit").click(function () {
    var form = $("#addform").serialize();
    doAjaxPost("' . $this->base_uri . "services/manage/" . $service->id . "/databases/addusertodb/?" . '"+ form, form);
        });
    });
</script>


    ';
                    $this->Form->end();
                }

                exit();
            } else {
                return false;
            }
        }
    }

    public function databaseschangepass($package, $service, array $get = null, array $post = null, array $files = null) {

        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            if (isset($get["name"])) {
                Loader::loadHelpers($this, array("Form", "Html"));
                $service_fields = $this->serviceFieldsToObject($service->fields);
                $module_row = $this->getModuleRow($package->module_row);
                $api = $this->getApi($module_row->meta);
                if (isset($post) && !empty($post)) {
                    if ($post['name'] !== "" && $post['password'] !== "") {
                        Loader::loadModels($this, array("Services"));
                        $add_new = $api->editDBUser($service_fields->email, $service_fields->password, $service_fields->domain, $post);
                        $this->log($module_row->meta->hostname . "|Change DB User Password", serialize("editDBUser"), "input", true);
                        if ($add_new['status'] !== 0) {
                            $siteworx_error = str_replace('Please see details below.', '', $add_new['payload']);
                            $siteworx_error = strstr($siteworx_error, "Usage", true);
                            echo "<div class='alert alert-danger alert-dismissable'>
		<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
				<p>{$siteworx_error}</p>
			</div>";
                        } else {
                            echo "<div class='alert alert-success alert-dismissable'>
		<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
				<p>" . Language::_("tastyinterworx.success", true) . "</p>
			</div><script>$(document).ready(function (e) { $('#global_modal').modal('hide');});</script>";
                        }
                    } else {
                        $error = array(
                            0 => array(
                                "result" => Language::_("tastyinterworx.empty_invalid_values", true)
                            )
                        );
                        echo "<div class='alert alert-danger alert-dismissable'>
		<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
				<p>{$error[0]['result']}</p>
			</div>";
                    }
                } else {
                    $customfiles = $this->customStyleJS();

                    $this->Form->create("", array('onsubmit' => 'return false', 'id' => 'changepassform', 'autocomplete' => "off"));
                    echo" {$customfiles}
            <div class='modal-body'>
<div class='div_response'></div>";
                    $this->Form->fieldHidden("name", $this->Html->ifSet($get["name"]), array('id' => "name"));

                    echo'<div class="form-group">
   <label>' . Language::_("tastyinterworx.changepassword", true) . " " . Language::_("tastyinterworx.for", true) . " " . $get["name"] . '</label>
    <input type="password" class="form-control" value="" id="password" name="password" placeholder="**********">
</div>
<div class="new_div"></div>
</div>
<div class="modal-footer">
<button type="button" name="cancel" class="btn btn-default" data-dismiss="modal"><i class="fa fa-ban"></i> ' . Language::_("tastyinterworx.cancel", true) . '</button>
<button type="button" class="btn btn-default" id="generate"><i class="fa fa-key"></i> ' . Language::_("tastyinterworx.service.generate", true) . '</button>
<button type="button" class="btn btn-primary" name="change_password" id="change_password"><i class="fa fa-edit"></i> ' . Language::_("tastyinterworx.submit", true) . '</button>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $("#change_password").click(function () {
    var form = $("#changepassform").serialize();
    doAjaxPost("' . $this->base_uri . "services/manage/" . $service->id . "/databases/changepass/?" . '"+ form, form);
        });
        $("#generate").click(function () {
            doAjaxGet("' . $this->base_uri . "services/manage/" . $service->id . "/changepassword/generatepass/" . '", "' . Language::_("tastyinterworx.generated_password", true) . '");
        });
    });
</script>


    ';
                    $this->Form->end();
                }

                exit();
            } else {
                return false;
            }
        }
    }

    public function databasesaddnewdbuser($package, $service, array $get = null, array $post = null, array $files = null) {

        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            Loader::loadHelpers($this, array("Form", "Html"));
            $service_fields = $this->serviceFieldsToObject($service->fields);
            $module_row = $this->getModuleRow($package->module_row);
            $api = $this->getApi($module_row->meta);
            if (isset($post) && !empty($post)) {
                if ($post['name'] !== "" && $post['password'] !== "") {
                    Loader::loadModels($this, array("Services"));
                    $add_new = $api->addDBUser($service_fields->email, $service_fields->password, $service_fields->domain, $post);
                    $this->log($module_row->meta->hostname . "|Create New DB", serialize("addDatabases"), "input", true);
                    if ($add_new['status'] !== 0) {
                        $siteworx_error = str_replace('Please see details below.', '', $add_new['payload']);
                        $siteworx_error = strstr($siteworx_error, "Usage", true);
                        echo "<div class='alert alert-danger alert-dismissable'>
		<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
				<p>{$siteworx_error}</p>
			</div>";
                    } else {
                        echo "<div class='alert alert-success alert-dismissable'>
		<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
				<p>" . Language::_("tastyinterworx.success", true) . "</p>
			</div><script>$(document).ready(function (e) { $('#global_modal').modal('hide');});</script>";
                    }
                } else {
                    $error = array(
                        0 => array(
                            "result" => Language::_("tastyinterworx.empty_invalid_values", true)
                        )
                    );
                    echo "<div class='alert alert-danger alert-dismissable'>
		<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
				<p>{$error[0]['result']}</p>
			</div>";
                }
            } else {
                $customfiles = $this->customStyleJS();

                $this->Form->create("", array('onsubmit' => 'return false', 'id' => 'addform', 'autocomplete' => "off"));
                echo" {$customfiles}
            <div class='modal-body'>
<div class='div_response'></div>";

                echo'<div class="form-group">
<label>' . Language::_("tastyinterworx.db.dbuser", true) . '</label>
<div class="input-group">
  <span class="input-group-addon" id="dir_s">' . $service_fields->username . '_</span>
    <input type="text" class="form-control" value="" id="name" name="name" placeholder=""></div>
</div>
<div class="form-group">
   <label>' . Language::_("tastyinterworx.service.password", true) . '</label>
    <input type="password" class="form-control" value="" id="password" name="password" placeholder="**********">
</div>
<div class="new_div"></div>

</div>
<div class="modal-footer">
<button type="button" name="cancel" class="btn btn-default" data-dismiss="modal"><i class="fa fa-ban"></i> ' . Language::_("tastyinterworx.cancel", true) . '</button>
<button type="button" class="btn btn-default" id="generate"><i class="fa fa-key"></i> ' . Language::_("tastyinterworx.service.generate", true) . '</button>
<button type="button" class="btn btn-primary" name="add_new" id="addnewsubmit"><i class="fa fa-plus-circle"></i> ' . Language::_("tastyinterworx.submit", true) . '</button>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $("#addnewsubmit").click(function () {
    var form = $("#addform").serialize();
    doAjaxPost("' . $this->base_uri . "services/manage/" . $service->id . "/databases/addnewdbuser/?" . '"+ form, form);
        });
        $("#generate").click(function () {
            doAjaxGet("' . $this->base_uri . "services/manage/" . $service->id . "/changepassword/generatepass/" . '", "' . Language::_("tastyinterworx.generated_password", true) . '");
        });
    });
</script>


    ';
                $this->Form->end();
            }

            exit();
        }
    }

    public function databasesaddnewdb($package, $service, array $get = null, array $post = null, array $files = null) {

        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            Loader::loadHelpers($this, array("Form", "Html"));
            $service_fields = $this->serviceFieldsToObject($service->fields);
            $module_row = $this->getModuleRow($package->module_row);
            $api = $this->getApi($module_row->meta);
            if (isset($post) && !empty($post)) {
                if ($post['name'] !== "") {
                    Loader::loadModels($this, array("Services"));
                    $add_new = $api->addDatabases($service_fields->email, $service_fields->password, $service_fields->domain, $post);
                    $this->log($module_row->meta->hostname . "|Create New DB", serialize("addDatabases"), "input", true);
                    if ($add_new['status'] !== 0) {
                        $siteworx_error = str_replace('Please see details below.', '', $add_new['payload']);
                        $siteworx_error = strstr($siteworx_error, "Usage", true);
                        echo "<div class='alert alert-danger alert-dismissable'>
		<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
				<p>{$siteworx_error}</p>
			</div>";
                    } else {
                        echo "<div class='alert alert-success alert-dismissable'>
		<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
				<p>" . Language::_("tastyinterworx.success", true) . "</p>
			</div><script>$(document).ready(function (e) { $('#global_modal').modal('hide');});</script>";
                    }
                } else {
                    $error = array(
                        0 => array(
                            "result" => Language::_("tastyinterworx.empty_invalid_values", true)
                        )
                    );
                    echo "<div class='alert alert-danger alert-dismissable'>
		<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
				<p>{$error[0]['result']}</p>
			</div>";
                }
            } else {
                $customfiles = $this->customStyleJS();

                $this->Form->create("", array('onsubmit' => 'return false', 'id' => 'addform', 'autocomplete' => "off"));
                echo" {$customfiles}
            <div class='modal-body'>
<div class='div_response'></div>";

                echo'<div class="form-group">
<label>' . Language::_("tastyinterworx.db.database", true) . '</label>
<div class="input-group">
  <span class="input-group-addon" id="dir_s">' . $service_fields->username . '_</span>
    <input type="text" class="form-control" value="" id="name" name="name" placeholder=""></div>
</div>
</div>
<div class="modal-footer">
<button type="button" name="cancel" class="btn btn-default" data-dismiss="modal"><i class="fa fa-ban"></i> ' . Language::_("tastyinterworx.cancel", true) . '</button>
<button type="button" class="btn btn-primary" name="add_new" id="addnewsubmit"><i class="fa fa-plus-circle"></i> ' . Language::_("tastyinterworx.submit", true) . '</button>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $("#addnewsubmit").click(function () {
    var form = $("#addform").serialize();
    doAjaxPost("' . $this->base_uri . "services/manage/" . $service->id . "/databases/addnewdb/?" . '"+ form, form);
        });
    });
</script>


    ';
                $this->Form->end();
            }

            exit();
        }
    }

    public function databasesmain($package, $service, array $get = null, array $post = null, array $files = null) {
        $customfiles = $this->customStyleJS();
        $this->view = new View("databases", "default");
        $this->view->base_uri = $this->base_uri;
        Loader::loadHelpers($this, array("Form", "Html"));
        $service_fields = $this->serviceFieldsToObject($service->fields);
        $module_row = $this->getModuleRow($package->module_row);
        $api = $this->getApi($module_row->meta);

        if (isset($post['delete_db'])) {
            if (!empty($post['name'])) {
                $delete_email = $api->deleteDatabases($service_fields->email, $service_fields->password, $service_fields->domain, $post);
                $this->log($module_row->meta->hostname . "|Delete Database", serialize("deleteDatabases"), "input", true);
            } else {
                $error = array(
                    0 => array(
                        "result" => Language::_("tastyinterworx.empty_invalid_values", true)
                    )
                );
                $this->Input->setErrors($error[0]);
            }
        } else if (isset($post['delete_dbuser'])) {
            if (!empty($post['name'])) {
                $delete_email = $api->deleteDBUser($service_fields->email, $service_fields->password, $service_fields->domain, $post);
                $this->log($module_row->meta->hostname . "|Delete Database User", serialize("deleteDBUser"), "input", true);
            } else {
                $error = array(
                    0 => array(
                        "result" => Language::_("tastyinterworx.empty_invalid_values", true)
                    )
                );
                $this->Input->setErrors($error[0]);
            }
        }

        $listdatabases = $api->listDatabases($service_fields->email, $service_fields->password, $service_fields->domain);
        $listdbuser = $api->listDBUser($service_fields->email, $service_fields->password, $service_fields->domain);
        $this->view->set("module_row", $module_row);
        $this->view->set("service_fields", $service_fields);
        $this->view->set("listdatabases", $listdatabases['payload']);
        $this->view->set("listdbuser", $listdbuser['payload']);
        $this->view->set("emaildomains", array($service_fields->domain => $service_fields->domain));
        $this->view->set("type", $package->meta->type);
        $this->view->set("service_id", $service->id);



        $this->view->setDefaultView("components" . DS . "modules" . DS . "tastyinterworxmodule" . DS);
        return $customfiles . $this->view->fetch();
    }

    public function manageappsaddnew($package, $service, array $get = null, array $post = null, array $files = null) {

        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            Loader::loadHelpers($this, array("Form", "Html"));
            $service_fields = $this->serviceFieldsToObject($service->fields);
            $module_row = $this->getModuleRow($package->module_row);
            if (isset($post) && !empty($post)) {
                if ($post['softdomain'] !== "" && $post['softdirectory'] !== "" && $post['admin_username'] !== "" && $post['admin_pass'] !== "" && $post['admin_email'] !== "" && $post['language'] !== "" && $post['site_name'] !== "" && $post['site_desc'] !== "") {
                    Loader::loadModels($this, array("Services"));
                    $api = $this->getsoftaApi($package, $module_row->meta->hostname, $service_fields->email, $service_fields->password, $service_fields->domain);
                    $install_script = $api->install($post['scriptid'], $post);
                    if (!isset($install_script['error']) || empty($install_script['error'])) {

                        echo "<div class='alert alert-success alert-dismissable'>
		<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
				<p>" . Language::_("tastyinterworx.success", true) . "</p>
			</div><script>$(document).ready(function (e) { $('#global_modal').modal('hide');});</script>";
                    } else {
                        $p = "";
                        foreach ($install_script['error'] as $key => $value) {
                            $p .= $install_script['error'][$key];
                        }

                        echo "<div class='alert alert-danger alert-dismissable'>
		<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
				<p>{$p}</p>
			</div>";
                    }
                } else {
                    $error = array(
                        0 => array(
                            "result" => Language::_("tastyinterworx.empty_invalid_values", true)
                        )
                    );
                    echo "<div class='alert alert-danger alert-dismissable'>
		<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
				<p>{$error[0]['result']}</p>
			</div>";
                }
            } else {
                $customfiles = $this->customStyleJS();

                $this->Form->create("", array('onsubmit' => 'return false', 'id' => 'addform', 'autocomplete' => "off"));
                echo" {$customfiles}
            <div class='modal-body'>
<div class='div_response'></div>";

                echo'<div class="form-group">
   <label>' . Language::_("tastyinterworx.manageapps.choose_software", true) . '</label>
<select name="scriptid" id="scriptid" class="form-control">
' . $this->scriptsavailable($package, $service_fields) . '
</select>
</div>
<div class="form-group">
   <label>' . Language::_("tastyinterworx.service.domain", true) . '</label>
<select name="softdomain" id="softdomain" class="form-control">
<option value="' . $service_fields->domain . '">' . $service_fields->domain . '</option>
</select>
</div>
<div class="form-group">
   <label>' . Language::_("tastyinterworx.manageapps.software_directory_addapp", true) . '</label>
    <input type="text" class="form-control" value="" id="softdirectory" name="softdirectory" placeholder=""></div>
<div class="form-group">
   <label>' . Language::_("tastyinterworx.manageapps.swadmin_username", true) . '</label>
    <input type="text" class="form-control" value="" id="admin_username" name="admin_username" placeholder=""></div>
<div class="form-group">
   <label>' . Language::_("tastyinterworx.manageapps.swadmin_pass", true) . '</label>
    <input type="password" class="form-control" value="" id="admin_pass" name="admin_pass" placeholder=""></div>
<div class="form-group">
   <label>' . Language::_("tastyinterworx.manageapps.swadmin_email", true) . '</label>
    <input type="text" class="form-control" value="" id="admin_email" name="admin_email" placeholder=""></div>
<div class="form-group">
   <label>' . Language::_("tastyinterworx.manageapps.sw_site_name", true) . '</label>
    <input type="text" class="form-control" value="" id="site_name" name="site_name" placeholder=""></div>
<div class="form-group">
   <label>' . Language::_("tastyinterworx.manageapps.sw_site_desc", true) . '</label>
    <input type="text" class="form-control" value="" id="site_desc" name="site_desc" placeholder=""></div>
<div class="form-group">
   <label>' . Language::_("tastyinterworx.manageapps.language", true) . '</label>
<select name="language" id="language" class="form-control">
<option value="en" >English</option>
<option value="ar">Arabic</option>
<option value="en_ca">English (Canada)</option>
<option value="en_uk">English (United Kingdom)</option>
<option value="en_au">English Au</option>
<option value="bg">Bulgarian</option>
<option value="ca">Catalan</option>
<option value="hr">Croatian</option>
<option value="da">Dansk</option>
<option value="de">Deutsch</option>
<option value="es">Español (Spanish)</option>
<option value="et">Estonian</option>
<option value="fr">Français</option>
<option value="gl">Gaelg</option>
<option value="he">Hebrew</option>
<option value="is">Icelandic</option>
<option value="it">Italiano</option>
<option value="ja">Japanese</option>
<option value="ko">Korean</option>
<option value="lv">Latvian</option>
<option value="hu">Magyar (Hungarian)</option>
<option value="nl">Nederlands (Dutch)</option>
<option value="no">Norwegian</option>
<option value="fa">Persian</option>
<option value="pl">Polski</option>
<option value="pt">Português (Portuguese)</option>
<option value="pt_br">Português do Brasil</option>
<option value="ro">Română</option>
<option value="ru">Russian</option>
<option value="sr">Serbian</option>
<option value="sk">Slovak (Slovakian)</option>
<option value="fi">Suomi</option>
<option value="sv">Swedish</option>
<option value="th">Thai</option>
<option value="tr">Türkçe (Turkish)</option>
<option value="cs">Česky (Czech)</option>
<option value="el">Ελληνικά (Greek)</option>
<option value="uk">Українська (Ukrainian)</option>
<option value="zh">中文 (Chinese Simplified)</option>
<option value="zh_tw">中文(台灣) (Chinese Traditional)</option></select>
</div>
</div>
<div class="modal-footer">
<button type="button" name="cancel" class="btn btn-default" data-dismiss="modal"><i class="fa fa-ban"></i> ' . Language::_("tastyinterworx.cancel", true) . '</button>
<button type="button" class="btn btn-primary" name="add_new" id="addnewsubmit"><i class="fa fa-plus-circle"></i> ' . Language::_("tastyinterworx.submit", true) . '</button>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $("#addnewsubmit").click(function () {
    var form = $("#addform").serialize();
    doAjaxPost("' . $this->base_uri . "services/manage/" . $service->id . "/manageapps/installapps/?" . '"+ form, form);
        });
    });
</script>


    ';
                $this->Form->end();
            }

            exit();
        }
    }

    public function manageappsmain($package, $service, array $get = null, array $post = null, array $files = null) {
        $customfiles = $this->customStyleJS();
        $this->view = new View("manageapps_softaculous", "default");
        $this->view->base_uri = $this->base_uri;
        Loader::loadHelpers($this, array("Form", "Html"));
        $service_fields = $this->serviceFieldsToObject($service->fields);
        $module_row = $this->getModuleRow($package->module_row);
        $api = $this->getsoftaApi($package, $module_row->meta->hostname, $service_fields->email, $service_fields->password, $service_fields->domain);
        if (isset($post['submitremovebu'])) {
            $post_data = array(
                "filename" => "{$post['filename']}"
            );
            $remove_backup = $api->remove_backup($post_data['filename']);
        } else if (isset($post['submitmakebu'])) {
            $post_data = array(
                "installid" => "{$post['installid']}"
            );
            $make_backup = $api->backup($post_data['installid']);
        } else if (isset($post['submitrestorebu'])) {
            $post_data = array(
                "installid" => "{$post['filename']}"
            );
            $delete_install = $api->restoreBackup($post_data['installid']);
        } else if (isset($post['submitdeleteinstall'])) {
            $post_data = array(
                "installid" => "{$post['installid']}"
            );
            $delete_install = $api->removeInstall($post_data['installid']);
        } else if (isset($post['submitupgrade'])) {
            $post_data = array(
                "installid" => "{$post['installid']}"
            );
            $delete_install = $api->upgradeInstall($post_data['installid']);
        }

        $installations = $api->list_installed_apps();
        $getallscripts = $api->list_scripts();
        $installations_backups = $api->list_backups();

        $this->view->set("module_row", $module_row);
        $this->view->set("service_fields", $service_fields);
        $this->view->set("installations", $installations['installations']);
        $this->view->set("getallscripts", $getallscripts);
        $this->view->set("installations_backups", $installations_backups['backups']);
        $this->view->set("availabledomain", array($service_fields->domain => $service_fields->domain));
        $this->view->set("availablescripts", $this->scriptsavailable($package, $service_fields));
        $this->view->set("type", $package->meta->type);
        $this->view->set("service_id", $service->id);



        $this->view->setDefaultView("components" . DS . "modules" . DS . "tastyinterworxmodule" . DS);
        return $customfiles . $this->view->fetch();
    }

    public function backupsaddnewsch($package, $service, array $get = null, array $post = null, array $files = null) {

        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            Loader::loadHelpers($this, array("Form", "Html"));
            $service_fields = $this->serviceFieldsToObject($service->fields);
            $module_row = $this->getModuleRow($package->module_row);
            $api = $this->getApi($module_row->meta);
            if (isset($post) && !empty($post)) {
                if ($post['frequency'] !== "" && $post['type'] !== "" && $post['location'] !== "" && $post['email_address'] !== "" && $post['rotate'] !== "" && $post['hour'] !== "") {
                    Loader::loadModels($this, array("Services"));
                    $add_new = $api->createBackupSchedule($service_fields->email, $service_fields->password, $service_fields->domain, $post);
                    $this->log($module_row->meta->hostname . "|Create Backup Schedule", serialize("createBackupSchedule"), "input", true);
                    if ($add_new['status'] !== 0) {
                        $siteworx_error = str_replace('Please see details below.', '', $add_new['payload']);
                        $siteworx_error = strstr($siteworx_error, "Usage", true);
                        echo "<div class='alert alert-danger alert-dismissable'>
		<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
				<p>{$siteworx_error}</p>
			</div>";
                    } else {
                        echo "<div class='alert alert-success alert-dismissable'>
		<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
				<p>" . Language::_("tastyinterworx.success", true) . "</p>
			</div><script>$(document).ready(function (e) { $('#global_modal').modal('hide');});</script>";
                    }
                } else {
                    $error = array(
                        0 => array(
                            "result" => Language::_("tastyinterworx.empty_invalid_values", true)
                        )
                    );
                    echo "<div class='alert alert-danger alert-dismissable'>
		<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
				<p>{$error[0]['result']}</p>
			</div>";
                }
            } else {
                $customfiles = $this->customStyleJS();
                $frequency = array(
                    "weekly" => "Weekly",
                    "monthly" => "Monthly"
                );
                $type = array(
                    "full" => "Full Backup",
                    "partial" => "Partial Backup",
                    "structure" => "Structure-Only Backup"
                );
                $location = array(
                    "siteworx" => "Default Location",
                );
                $hour = array(
                    "0" => "0:00",
                    "1" => "1:00",
                    "2" => "2:00",
                    "3" => "3:00",
                    "4" => "4:00",
                    "5" => "5:00",
                    "6" => "6:00",
                    "7" => "7:00",
                    "8" => "8:00",
                    "9" => "9:00",
                    "10" => "10:00",
                    "11" => "11:00",
                    "12" => "12:00",
                    "13" => "13:00",
                    "14" => "14:00",
                    "15" => "15:00",
                    "16" => "16:00",
                    "17" => "17:00",
                    "18" => "18:00",
                    "19" => "19:00",
                    "20" => "20:00",
                    "21" => "21:00",
                    "22" => "22:00",
                    "23" => "23:00"
                );
                $frequency_opt = "";
                $hour_opt = "";
                $location_opt = "";
                $type_opt = "";
                foreach ($frequency as $key => $value) {
                    $frequency_opt .= "<option value='{$key}'>{$frequency[$key]}</option>";
                }
                foreach ($type as $key => $value) {
                    $type_opt .= "<option value='{$key}'>{$type[$key]}</option>";
                }
                foreach ($location as $key => $value) {
                    $location_opt .= "<option value='{$key}'>{$location[$key]}</option>";
                }
                foreach ($hour as $key => $value) {
                    $hour_opt .= "<option value='{$key}'>{$hour[$key]}</option>";
                }

                $this->Form->create("", array('onsubmit' => 'return false', 'id' => 'addform', 'autocomplete' => "off"));

                echo" {$customfiles}
            <div class='modal-body'>
<div class='div_response'></div>";

                echo'<div class="form-group">
   <label>' . Language::_("tastyinterworx.frequency", true) . '</label>
<select name="frequency" class="form-control" id="frequency">
' . $frequency_opt . '
</select></div>
    <div class="form-group">
   <label>' . Language::_("tastyinterworx.type", true) . '</label>
<select name="type" class="form-control" id="type">
' . $type_opt . '
</select></div>
    <div class="form-group">
   <label>' . Language::_("tastyinterworx.location", true) . '</label>
<select name="location" class="form-control" id="location">
' . $location_opt . '
</select></div>
<div class="form-group">
   <label>' . Language::_("tastyinterworx.email_address", true) . '</label>
    <input type="email" class="form-control" value="" id="email_address" name="email_address" placeholder=""></div>
<div class="form-group">
   <label>' . Language::_("tastyinterworx.rotate", true) . ' ' . Language::_("tastyinterworx.rotate.desc", true) . '</label>
    <input type="text" class="form-control" value="" id="rotate" name="rotate" placeholder=""></div>
    <div class="form-group">
   <label>' . Language::_("tastyinterworx.hour", true) . '</label>
<select name="hour" class="form-control" id="hour">
' . $hour_opt . '
</select></div>
    <div class="form-group" id="dayofweek">
   <label>' . Language::_("tastyinterworx.dayofweek", true) . '</label>
<select name="day_of_week" class="form-control" id="day_of_week">
<option value="0">Sunday</option>
  <option value="1">Monday</option>
  <option value="2">Tuesday</option>
  <option value="3">Wednesday</option>
  <option value="4">Thursday</option>
  <option value="5">Friday</option>
  <option value="6">Saturday</option>
</select></div>
    <div class="form-group" id="dayofmonth" style="display:none;">
   <label>' . Language::_("tastyinterworx.dayofmonth", true) . '</label>
<select name="day_of_month" class="form-control" id="day_of_month">
  <option value="1">1</option>
  <option value="2">2</option>
  <option value="3">3</option>
  <option value="4">4</option>
  <option value="5">5</option>
  <option value="6">6</option>
  <option value="7">7</option>
  <option value="8">8</option>
  <option value="9">9</option>
  <option value="10">10</option>
  <option value="11">11</option>
  <option value="12">12</option>
  <option value="13">13</option>
  <option value="14">14</option>
  <option value="15">15</option>
  <option value="16">16</option>
  <option value="17">17</option>
  <option value="18">18</option>
  <option value="19">19</option>
  <option value="20">20</option>
  <option id="yui-gen1" value="21">21</option>
  <option value="22">22</option>
  <option value="23">23</option>
  <option value="24">24</option>
  <option value="25">25</option>
  <option value="26">26</option>
  <option value="27">27</option>
  <option value="28">28</option>
  <option value="29">29</option>
  <option value="30">30</option>
  <option value="31">31</option>
</select></div>
</div>
<div class="modal-footer">
<button type="button" name="cancel" class="btn btn-default" data-dismiss="modal"><i class="fa fa-ban"></i> ' . Language::_("tastyinterworx.cancel", true) . '</button>
<button type="button" class="btn btn-primary" name="add_new" id="addnewsubmit"><i class="fa fa-plus-circle"></i> ' . Language::_("tastyinterworx.submit", true) . '</button>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $("#frequency").change(function () {
        if($(this).val() === "weekly"){
        $("#dayofweek").css("display","block")
        $("#dayofmonth").css("display","none")
         } else if($(this).val() === "monthly"){
        $("#dayofweek").css("display","none")
        $("#dayofmonth").css("display","block")
         }
        });
        $("#addnewsubmit").click(function () {
    var form = $("#addform").serialize();
    doAjaxPost("' . $this->base_uri . "services/manage/" . $service->id . "/backups/addnewsch/?" . '"+ form, form);
        });
    });
</script>


    ';
                $this->Form->end();
            }

            exit();
        }
    }

    public function backupsaddnew($package, $service, array $get = null, array $post = null, array $files = null) {

        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            Loader::loadHelpers($this, array("Form", "Html"));
            $service_fields = $this->serviceFieldsToObject($service->fields);
            $module_row = $this->getModuleRow($package->module_row);
            $api = $this->getApi($module_row->meta);
            if (isset($post) && !empty($post)) {
                if ($post['location'] !== "" && $post['email_address'] !== "") {
                    $post['type'] = "full";
                    Loader::loadModels($this, array("Services"));
                    $add_new = $api->createBackup($service_fields->email, $service_fields->password, $service_fields->domain, $post);
                    $this->log($module_row->meta->hostname . "|Create Backup", serialize("createBackup"), "input", true);
                    if ($add_new['status'] !== 0) {
                        $siteworx_error = str_replace('Please see details below.', '', $add_new['payload']);
                        $siteworx_error = strstr($siteworx_error, "Usage", true);
                        echo "<div class='alert alert-danger alert-dismissable'>
		<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
				<p>{$siteworx_error}</p>
			</div>";
                    } else {
                        echo "<div class='alert alert-success alert-dismissable'>
		<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
				<p>" . Language::_("tastyinterworx.success", true) . "</p>
			</div><script>$(document).ready(function (e) { $('#global_modal').modal('hide');});</script>";
                    }
                } else {
                    $error = array(
                        0 => array(
                            "result" => Language::_("tastyinterworx.empty_invalid_values", true)
                        )
                    );
                    echo "<div class='alert alert-danger alert-dismissable'>
		<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
				<p>{$error[0]['result']}</p>
			</div>";
                }
            } else {
                $customfiles = $this->customStyleJS();

                $this->Form->create("", array('onsubmit' => 'return false', 'id' => 'addform', 'autocomplete' => "off"));

                echo" {$customfiles}
            <div class='modal-body'>
<div class='div_response'></div>";

                echo'<div class="form-group">
   <label>' . Language::_("tastyinterworx.email_address", true) . '</label>
    <input type="email" class="form-control" value="" id="email_address" name="email_address" placeholder=""></div>
    <div class="form-group">
   <label>' . Language::_("tastyinterworx.location", true) . '</label>
<select name="location" class="form-control" id="location">
<option value="siteworx">Default Location</option>
</select></div>
       </div>
<div class="modal-footer">
<button type="button" name="cancel" class="btn btn-default" data-dismiss="modal"><i class="fa fa-ban"></i> ' . Language::_("tastyinterworx.cancel", true) . '</button>
<button type="button" class="btn btn-primary" name="add_new" id="addnewsubmit"><i class="fa fa-plus-circle"></i> ' . Language::_("tastyinterworx.submit", true) . '</button>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $("#addnewsubmit").click(function () {
    var form = $("#addform").serialize();
    doAjaxPost("' . $this->base_uri . "services/manage/" . $service->id . "/backups/addnew/?" . '"+ form, form);
        });
    });
</script>


    ';
                $this->Form->end();
            }

            exit();
        }
    }

    public function backupsmain($package, $service, array $get = null, array $post = null, array $files = null) {
        $customfiles = $this->customStyleJS();
        $this->view = new View("backups", "default");
        $this->view->base_uri = $this->base_uri;
        Loader::loadHelpers($this, array("Form", "Html"));
        $service_fields = $this->serviceFieldsToObject($service->fields);
        $module_row = $this->getModuleRow($package->module_row);
        $api = $this->getApi($module_row->meta);

        if (isset($post['delete_backup'])) {
            if (!empty($post['backups'])) {
                $delete_email = $api->deleteBackup($service_fields->email, $service_fields->password, $service_fields->domain, $post);
                $this->log($module_row->meta->hostname . "|Delete Backup", serialize("deleteBackup"), "input", true);
            } else {
                $error = array(
                    0 => array(
                        "result" => Language::_("tastyinterworx.empty_invalid_values", true)
                    )
                );
                $this->Input->setErrors($error[0]);
            }
        }

        $listbackups = $api->listBackups($service_fields->email, $service_fields->password, $service_fields->domain);
        $listbackupschedule = $api->listBackupSchedule($service_fields->email, $service_fields->password, $service_fields->domain);
        $this->view->set("module_row", $module_row);
        $this->view->set("service_fields", $service_fields);
        $this->view->set("listbackups", $listbackups['payload']);
        $this->view->set("listbackupschedule", $listbackupschedule['payload']);
        $this->view->set("emaildomains", array($service_fields->domain => $service_fields->domain));
        $this->view->set("type", $package->meta->type);
        $this->view->set("service_id", $service->id);



        $this->view->setDefaultView("components" . DS . "modules" . DS . "tastyinterworxmodule" . DS);
        return $customfiles . $this->view->fetch();
    }

    public function cronjobsaddnew($package, $service, array $get = null, array $post = null, array $files = null) {

        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            Loader::loadHelpers($this, array("Form", "Html"));
            $service_fields = $this->serviceFieldsToObject($service->fields);
            $module_row = $this->getModuleRow($package->module_row);
            $api = $this->getApi($module_row->meta);
            if (isset($post) && !empty($post)) {
                if ($post['minute'] !== "" && $post['hour'] !== "" && $post['day'] !== "" && $post['month'] !== "" && $post['dayofweek'] !== "" && $post['script'] !== "") {
                    Loader::loadModels($this, array("Services"));
                    $add_new = $api->addCron($service_fields->email, $service_fields->password, $service_fields->domain, $post);
                    $this->log($module_row->meta->hostname . "|Add New Cron Job", serialize("addCron"), "input", true);
                    if ($add_new['status'] !== 0) {
                        $siteworx_error = str_replace('Please see details below.', '', $add_new['payload']);
                        $siteworx_error = strstr($siteworx_error, "Usage", true);
                        echo "<div class='alert alert-danger alert-dismissable'>
		<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
				<p>{$siteworx_error}</p>
			</div>";
                    } else {
                        echo "<div class='alert alert-success alert-dismissable'>
		<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
				<p>" . Language::_("tastyinterworx.success", true) . "</p>
			</div><script>$(document).ready(function (e) { $('#global_modal').modal('hide');});</script>";
                    }
                } else {
                    $error = array(
                        0 => array(
                            "result" => Language::_("tastyinterworx.empty_invalid_values", true)
                        )
                    );
                    echo "<div class='alert alert-danger alert-dismissable'>
		<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
				<p>{$error[0]['result']}</p>
			</div>";
                }
            } else {
                $customfiles = $this->customStyleJS();

                $this->Form->create("", array('onsubmit' => 'return false', 'id' => 'addform', 'autocomplete' => "off"));
                $min_array = $this->cronSelectValues("min");
                $hour_array = $this->cronSelectValues("hour");
                $day_array = $this->cronSelectValues("day");
                $month_array = $this->cronSelectValues("month");
                $weekday_array = $this->cronSelectValues("weekday");
                $min_opt = "";
                $hour_opt = "";
                $day_opt = "";
                $month_opt = "";
                $weekday_opt = "";

                foreach ($min_array as $key => $value) {
                    $min_opt .= "<option value='{$key}'>{$min_array[$key]}</option>";
                }
                foreach ($hour_array as $key => $value) {
                    $hour_opt .= "<option value='{$key}'>{$hour_array[$key]}</option>";
                }
                foreach ($day_array as $key => $value) {
                    $day_opt .= "<option value='{$key}'>{$day_array[$key]}</option>";
                }
                foreach ($month_array as $key => $value) {
                    $month_opt .= "<option value='{$key}'>{$month_array[$key]}</option>";
                }
                foreach ($weekday_array as $key => $value) {
                    $weekday_opt .= "<option value='{$key}'>{$weekday_array[$key]}</option>";
                }

                echo" {$customfiles}
            <div class='modal-body'>
<div class='div_response'></div>";

                echo'
    <div class="form-group">
   <label>' . Language::_("tastyinterworx.minute", true) . '</label>
<select name="minute" class="form-control" id="minute">
' . $min_opt . '
</select>
</div>
    <div class="form-group">
   <label>' . Language::_("tastyinterworx.hour", true) . '</label>
<select name="hour" class="form-control" id="hour">
' . $hour_opt . '
</select>
</div>
    <div class="form-group">
   <label>' . Language::_("tastyinterworx.day", true) . '</label>
<select name="day" class="form-control" id="day">
' . $day_opt . '
</select>
</div>
    <div class="form-group">
   <label>' . Language::_("tastyinterworx.month", true) . '</label>
<select name="month" class="form-control" id="month">
' . $month_opt . '
</select>
</div>
    <div class="form-group">
   <label>' . Language::_("tastyinterworx.weekday", true) . '</label>
<select name="dayofweek" class="form-control" id="dayofweek">
' . $weekday_opt . '
</select>
</div>
<div class="form-group">
   <label>' . Language::_("tastyinterworx.script", true) . '</label>
    <input type="text" class="form-control" value="" id="script" name="script" placeholder=""></div>
       </div>
<div class="modal-footer">
<button type="button" name="cancel" class="btn btn-default" data-dismiss="modal"><i class="fa fa-ban"></i> ' . Language::_("tastyinterworx.cancel", true) . '</button>
<button type="button" class="btn btn-primary" name="add_new" id="addnewsubmit"><i class="fa fa-plus-circle"></i> ' . Language::_("tastyinterworx.submit", true) . '</button>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $("#addnewsubmit").click(function () {
    var form = $("#addform").serialize();
    doAjaxPost("' . $this->base_uri . "services/manage/" . $service->id . "/cronjobs/addnew/?" . '"+ form, form);
        });
    });
</script>


    ';
                $this->Form->end();
            }

            exit();
        }
    }

    public function cronjobsmain($package, $service, array $get = null, array $post = null, array $files = null) {
        $customfiles = $this->customStyleJS();
        $this->view = new View("cronjobs", "default");
        $this->view->base_uri = $this->base_uri;
        Loader::loadHelpers($this, array("Form", "Html"));
        $service_fields = $this->serviceFieldsToObject($service->fields);
        $module_row = $this->getModuleRow($package->module_row);
        $api = $this->getApi($module_row->meta);

        if (isset($post['delete_cronjob'])) {
            if (!empty($post['jobs'])) {
                $delete_email = $api->deleteCron($service_fields->email, $service_fields->password, $service_fields->domain, $post);
                $this->log($module_row->meta->hostname . "|Delete Cron Job", serialize("deleteCron"), "input", true);
            } else {
                $error = array(
                    0 => array(
                        "result" => Language::_("tastyinterworx.empty_invalid_values", true)
                    )
                );
                $this->Input->setErrors($error[0]);
            }
        }





        $listcron = $api->listCron($service_fields->email, $service_fields->password, $service_fields->domain);
        $this->view->set("module_row", $module_row);
        $this->view->set("service_fields", $service_fields);
        $this->view->set("listcron", $listcron['payload']);
        $this->view->set("emaildomains", array($service_fields->domain => $service_fields->domain));
        $this->view->set("type", $package->meta->type);
        $this->view->set("service_id", $service->id);



        $this->view->setDefaultView("components" . DS . "modules" . DS . "tastyinterworxmodule" . DS);
        return $customfiles . $this->view->fetch();
    }

    public function pointerdomainsaddnew($package, $service, array $get = null, array $post = null, array $files = null) {

        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            Loader::loadHelpers($this, array("Form", "Html"));
            $service_fields = $this->serviceFieldsToObject($service->fields);
            $module_row = $this->getModuleRow($package->module_row);
            $api = $this->getApi($module_row->meta);
            if (isset($post) && !empty($post)) {
                if ($post['domain'] !== "" && $post['redir_type'] !== "" && $post['points_to'] !== "") {
                    Loader::loadModels($this, array("Services"));
                    $add_new = $api->addDomainsRedirects($service_fields->email, $service_fields->password, $service_fields->domain, $post);
                    $this->log($module_row->meta->hostname . "|Add New Pointer Domain", serialize("addDomainsRedirects"), "input", true);
                    if ($add_new['status'] !== 0) {
                        $siteworx_error = str_replace('Please see details below.', '', $add_new['payload']);
                        $siteworx_error = strstr($siteworx_error, "Usage", true);
                        echo "<div class='alert alert-danger alert-dismissable'>
		<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
				<p>{$siteworx_error}</p>
			</div>";
                    } else {
                        echo "<div class='alert alert-success alert-dismissable'>
		<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
				<p>" . Language::_("tastyinterworx.success", true) . "</p>
			</div><script>$(document).ready(function (e) { $('#global_modal').modal('hide');});</script>";
                    }
                } else {
                    $error = array(
                        0 => array(
                            "result" => Language::_("tastyinterworx.empty_invalid_values", true)
                        )
                    );
                    echo "<div class='alert alert-danger alert-dismissable'>
		<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
				<p>{$error[0]['result']}</p>
			</div>";
                }
            } else {
                $customfiles = $this->customStyleJS();

                $this->Form->create("", array('onsubmit' => 'return false', 'id' => 'addform', 'autocomplete' => "off"));
                $select_option = "<select name='redir_type' class='form-control' id='redir_type'>";
                $select_option .= "<option value='redirect_301'>Permanent Redirect (301)</option>";
                $select_option .= "<option value='redirect_302'>Temporary Redirect (302)</option>";
                $select_option .= "<option value='server_alias'>Server Alias</option>";
                $select_option .= "</select>";

                echo" {$customfiles}
            <div class='modal-body'>
<div class='div_response'></div>";

                echo'<div class="form-group">
   <label>' . Language::_("tastyinterworx.domain", true) . '</label>
    <input type="text" class="form-control" value="" id="domain" name="domain" placeholder=""></div>
<div class="form-group">
   <label>' . Language::_("tastyinterworx.points_to", true) . '</label>
    <input type="text" class="form-control" value="" id="points_to" name="points_to" placeholder=""></div>
    <div class="form-group">
   <label>' . Language::_("tastyinterworx.redir_type", true) . '</label>
   ' . $select_option . '</div>
       </div>
<div class="modal-footer">
<button type="button" name="cancel" class="btn btn-default" data-dismiss="modal"><i class="fa fa-ban"></i> ' . Language::_("tastyinterworx.cancel", true) . '</button>
<button type="button" class="btn btn-primary" name="add_new" id="addnewsubmit"><i class="fa fa-plus-circle"></i> ' . Language::_("tastyinterworx.submit", true) . '</button>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $("#addnewsubmit").click(function () {
    var form = $("#addform").serialize();
    doAjaxPost("' . $this->base_uri . "services/manage/" . $service->id . "/pointerdomains/addnew/?" . '"+ form, form);
        });
    });
</script>


    ';
                $this->Form->end();
            }

            exit();
        }
    }

    public function pointerdomainsmain($package, $service, array $get = null, array $post = null, array $files = null) {
        $customfiles = $this->customStyleJS();
        $this->view = new View("pointerdomains", "default");
        $this->view->base_uri = $this->base_uri;
        Loader::loadHelpers($this, array("Form", "Html"));
        $service_fields = $this->serviceFieldsToObject($service->fields);
        $module_row = $this->getModuleRow($package->module_row);
        $api = $this->getApi($module_row->meta);

        if (isset($post['delete_domain'])) {
            if (!empty($post['domain'])) {
                $delete_email = $api->deleteDomainsRedirects($service_fields->email, $service_fields->password, $service_fields->domain, $post);
                $this->log($module_row->meta->hostname . "|Delete Pointer Domain", serialize("deleteDomainsRedirects"), "input", true);
            } else {
                $error = array(
                    0 => array(
                        "result" => Language::_("tastyinterworx.empty_invalid_values", true)
                    )
                );
                $this->Input->setErrors($error[0]);
            }
        }





        $listpointer = $api->listDomainsRedirects($service_fields->email, $service_fields->password, $service_fields->domain);
        $this->view->set("module_row", $module_row);
        $this->view->set("service_fields", $service_fields);
        $this->view->set("listpointer", $listpointer['payload']);
        $this->view->set("emaildomains", array($service_fields->domain => $service_fields->domain));
        $this->view->set("type", $package->meta->type);
        $this->view->set("service_id", $service->id);



        $this->view->setDefaultView("components" . DS . "modules" . DS . "tastyinterworxmodule" . DS);
        return $customfiles . $this->view->fetch();
    }

    public function secondarydomainsaddnew($package, $service, array $get = null, array $post = null, array $files = null) {

        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            Loader::loadHelpers($this, array("Form", "Html"));
            $service_fields = $this->serviceFieldsToObject($service->fields);
            $module_row = $this->getModuleRow($package->module_row);
            $api = $this->getApi($module_row->meta);
            if (isset($post) && !empty($post)) {
                if ($post['domain'] !== "") {
                    Loader::loadModels($this, array("Services"));
                    $add_new = $api->addAddonDomains($service_fields->email, $service_fields->password, $service_fields->domain, $post);
                    $this->log($module_row->meta->hostname . "|Add New Secondary Domain", serialize("addAddonDomains"), "input", true);
                    if ($add_new['status'] !== 0) {
                        $siteworx_error = str_replace('Please see details below.', '', $add_new['payload']);
                        $siteworx_error = strstr($siteworx_error, "Usage", true);
                        echo "<div class='alert alert-danger alert-dismissable'>
		<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
				<p>{$siteworx_error}</p>
			</div>";
                    } else {
                        echo "<div class='alert alert-success alert-dismissable'>
		<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
				<p>" . Language::_("tastyinterworx.success", true) . "</p>
			</div><script>$(document).ready(function (e) { $('#global_modal').modal('hide');});</script>";
                    }
                } else {
                    $error = array(
                        0 => array(
                            "result" => Language::_("tastyinterworx.empty_invalid_values", true)
                        )
                    );
                    echo "<div class='alert alert-danger alert-dismissable'>
		<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
				<p>{$error[0]['result']}</p>
			</div>";
                }
            } else {
                $customfiles = $this->customStyleJS();

                $this->Form->create("", array('onsubmit' => 'return false', 'id' => 'addform', 'autocomplete' => "off"));
                echo" {$customfiles}
            <div class='modal-body'>
<div class='div_response'></div>";

                echo'<div class="form-group">
   <label>' . Language::_("tastyinterworx.domain", true) . '</label>
    <input type="text" class="form-control" value="" id="domain" name="domain" placeholder=""></div>
       </div>
<div class="modal-footer">
<button type="button" name="cancel" class="btn btn-default" data-dismiss="modal"><i class="fa fa-ban"></i> ' . Language::_("tastyinterworx.cancel", true) . '</button>
<button type="button" class="btn btn-primary" name="add_new" id="addnewsubmit"><i class="fa fa-plus-circle"></i> ' . Language::_("tastyinterworx.submit", true) . '</button>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $("#addnewsubmit").click(function () {
    var form = $("#addform").serialize();
    doAjaxPost("' . $this->base_uri . "services/manage/" . $service->id . "/secondarydomains/addnew/?" . '"+ form, form);
        });
    });
</script>


    ';
                $this->Form->end();
            }

            exit();
        }
    }

    public function secondarydomainsmain($package, $service, array $get = null, array $post = null, array $files = null) {
        $customfiles = $this->customStyleJS();
        $this->view = new View("secondarydomains", "default");
        $this->view->base_uri = $this->base_uri;
        Loader::loadHelpers($this, array("Form", "Html"));
        $service_fields = $this->serviceFieldsToObject($service->fields);
        $module_row = $this->getModuleRow($package->module_row);
        $api = $this->getApi($module_row->meta);

        if (isset($post['delete_domain'])) {
            if (!empty($post['domain'])) {
                $delete_email = $api->deleteAddonDomains($service_fields->email, $service_fields->password, $service_fields->domain, $post);
                $this->log($module_row->meta->hostname . "|Delete Secondary Domain", serialize("deleteAddonDomains"), "input", true);
            } else {
                $error = array(
                    0 => array(
                        "result" => Language::_("tastyinterworx.empty_invalid_values", true)
                    )
                );
                $this->Input->setErrors($error[0]);
            }
        }





        $listsecondary = $api->listAddonDomains($service_fields->email, $service_fields->password, $service_fields->domain);
        $this->view->set("module_row", $module_row);
        $this->view->set("service_fields", $service_fields);
        $this->view->set("listsecondary", $listsecondary['payload']);
        $this->view->set("emaildomains", array($service_fields->domain => $service_fields->domain));
        $this->view->set("type", $package->meta->type);
        $this->view->set("service_id", $service->id);



        $this->view->setDefaultView("components" . DS . "modules" . DS . "tastyinterworxmodule" . DS);
        return $customfiles . $this->view->fetch();
    }

    public function subdomainsaddnew($package, $service, array $get = null, array $post = null, array $files = null) {

        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            Loader::loadHelpers($this, array("Form", "Html"));
            $service_fields = $this->serviceFieldsToObject($service->fields);
            $module_row = $this->getModuleRow($package->module_row);
            $api = $this->getApi($module_row->meta);
            if (isset($post) && !empty($post)) {
                if ($post['prefix'] !== "") {
                    Loader::loadModels($this, array("Services"));
                    $add_new = $api->addSubDomains($service_fields->email, $service_fields->password, $service_fields->domain, $post);
                    $this->log($module_row->meta->hostname . "|Add New Sub Domain", serialize("addSubDomains"), "input", true);
                    if ($add_new['status'] !== 0) {
                        $siteworx_error = str_replace('Please see details below.', '', $add_new['payload']);
                        $siteworx_error = strstr($siteworx_error, "Usage", true);
                        echo "<div class='alert alert-danger alert-dismissable'>
		<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
				<p>{$siteworx_error}</p>
			</div>";
                    } else {
                        echo "<div class='alert alert-success alert-dismissable'>
		<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
				<p>" . Language::_("tastyinterworx.success", true) . "</p>
			</div><script>$(document).ready(function (e) { $('#global_modal').modal('hide');});</script>";
                    }
                } else {
                    $error = array(
                        0 => array(
                            "result" => Language::_("tastyinterworx.empty_invalid_values", true)
                        )
                    );
                    echo "<div class='alert alert-danger alert-dismissable'>
		<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
				<p>{$error[0]['result']}</p>
			</div>";
                }
            } else {
                $customfiles = $this->customStyleJS();
                $select_option = "<select name='domain' class='form-control' id='domain'>";
                $select_option .= "<option value='{$service_fields->domain}'>{$service_fields->domain}</option>";
                $select_option .= "</select>";

                $this->Form->create("", array('onsubmit' => 'return false', 'id' => 'addform', 'autocomplete' => "off"));
                echo" {$customfiles}
            <div class='modal-body'>
<div class='div_response'></div>";

                echo'<div class="form-group">
   <label>' . Language::_("tastyinterworx.subdomain", true) . '</label>
    <input type="text" class="form-control" value="" id="prefix" name="prefix" placeholder=""></div>
    <div class="form-group">
   <label>' . Language::_("tastyinterworx.email.domain", true) . '</label>
   ' . $select_option . '</div>
       </div>
<div class="modal-footer">
<button type="button" name="cancel" class="btn btn-default" data-dismiss="modal"><i class="fa fa-ban"></i> ' . Language::_("tastyinterworx.cancel", true) . '</button>
<button type="button" class="btn btn-primary" name="add_new" id="addnewsubmit"><i class="fa fa-plus-circle"></i> ' . Language::_("tastyinterworx.submit", true) . '</button>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $("#addnewsubmit").click(function () {
    var form = $("#addform").serialize();
    doAjaxPost("' . $this->base_uri . "services/manage/" . $service->id . "/subdomains/addnew/?" . '"+ form, form);
        });
    });
</script>


    ';
                $this->Form->end();
            }

            exit();
        }
    }

    public function subdomainsmain($package, $service, array $get = null, array $post = null, array $files = null) {
        $customfiles = $this->customStyleJS();
        $this->view = new View("subdomains", "default");
        $this->view->base_uri = $this->base_uri;
        Loader::loadHelpers($this, array("Form", "Html"));
        $service_fields = $this->serviceFieldsToObject($service->fields);
        $module_row = $this->getModuleRow($package->module_row);
        $api = $this->getApi($module_row->meta);

        if (isset($post['delete_subdomain'])) {
            if (!empty($post['prefix'])) {
                $delete_email = $api->deleteSubDomains($service_fields->email, $service_fields->password, $service_fields->domain, $post);
                $this->log($module_row->meta->hostname . "|Delete Sub Domain", serialize("deleteSubDomains"), "input", true);
            } else {
                $error = array(
                    0 => array(
                        "result" => Language::_("tastyinterworx.empty_invalid_values", true)
                    )
                );
                $this->Input->setErrors($error[0]);
            }
        }





        $listsubd = $api->listSubDomains($service_fields->email, $service_fields->password, $service_fields->domain);
        $this->view->set("module_row", $module_row);
        $this->view->set("service_fields", $service_fields);
        $this->view->set("listsubd", $listsubd['payload']);
        $this->view->set("emaildomains", array($service_fields->domain => $service_fields->domain));
        $this->view->set("type", $package->meta->type);
        $this->view->set("service_id", $service->id);



        $this->view->setDefaultView("components" . DS . "modules" . DS . "tastyinterworxmodule" . DS);
        return $customfiles . $this->view->fetch();
    }

    public function ftpaccountsaddnew($package, $service, array $get = null, array $post = null, array $files = null) {

        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            Loader::loadHelpers($this, array("Form", "Html"));
            $service_fields = $this->serviceFieldsToObject($service->fields);
            $module_row = $this->getModuleRow($package->module_row);
            $api = $this->getApi($module_row->meta);
            if (isset($post) && !empty($post)) {
                if ($post['user'] !== "" && $post['password'] !== "") {
                    $post['homedir'] = "/home/{$service_fields->username}/{$post['homedir']}";
                    Loader::loadModels($this, array("Services"));
                    $add_new = $api->addFtpAccount($service_fields->email, $service_fields->password, $service_fields->domain, $post);
                    $this->log($module_row->meta->hostname . "|Add New FTP Account", serialize("addFtpAccount"), "input", true);
                    if ($add_new['status'] !== 0) {
                        $siteworx_error = str_replace('Please see details below.', '', $add_new['payload']);
                        $siteworx_error = strstr($siteworx_error, "Usage", true);
                        echo "<div class='alert alert-danger alert-dismissable'>
		<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
				<p>{$siteworx_error}</p>
			</div>";
                    } else {
                        echo "<div class='alert alert-success alert-dismissable'>
		<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
				<p>" . Language::_("tastyinterworx.success", true) . "</p>
			</div><script>$(document).ready(function (e) { $('#global_modal').modal('hide');});</script>";
                    }
                } else {
                    $error = array(
                        0 => array(
                            "result" => Language::_("tastyinterworx.empty_invalid_values", true)
                        )
                    );
                    echo "<div class='alert alert-danger alert-dismissable'>
		<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
				<p>{$error[0]['result']}</p>
			</div>";
                }
            } else {
                $customfiles = $this->customStyleJS();
                $select_option = "<select name='domain' class='form-control' id='domain'>";
                $select_option .= "<option value='{$service_fields->domain}'>{$service_fields->domain}</option>";
                $select_option .= "</select>";

                $this->Form->create("", array('onsubmit' => 'return false', 'id' => 'addform', 'autocomplete' => "off"));
                echo" {$customfiles}
            <div class='modal-body'>
<div class='div_response'></div>";

                echo'<div class="form-group">
   <label>' . Language::_("tastyinterworx.ftp.user", true) . '</label>
    <input type="email" class="form-control" value="" id="user" name="user" placeholder=""></div>
    <div class="form-group">
   <label>' . Language::_("tastyinterworx.email.domain", true) . '</label>
   ' . $select_option . '</div>
   <div class="form-group"> <label>' . Language::_("tastyinterworx.ftp.path", true) . '</label>
<div class="input-group">
  <span class="input-group-addon" id="homedir_s">/home/' . $service_fields->username . '/</span>
  <input type="text" class="form-control" name="homedir" placeholder="e.g: testaccount" aria-describedby="homedir_s">
</div>
</div>
   <div class="form-group"><label>' . Language::_("tastyinterworx.password", true) . '</label>
    <input type="password" class="form-control" value="" id="password" name="password" placeholder="***********"></div>
<div class="new_div"></div>
</div>
</div>
<div class="modal-footer">
<button type="button" name="cancel" class="btn btn-default" data-dismiss="modal"><i class="fa fa-ban"></i> ' . Language::_("tastyinterworx.cancel", true) . '</button>
<button type="button" class="btn btn-default" id="generate"><i class="fa fa-key"></i> ' . Language::_("tastyinterworx.service.generate", true) . '</button>
<button type="button" class="btn btn-primary" name="add_new" id="addnewsubmit"><i class="fa fa-plus-circle"></i> ' . Language::_("tastyinterworx.submit", true) . '</button>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $("#addnewsubmit").click(function () {
    var form = $("#addform").serialize();
    doAjaxPost("' . $this->base_uri . "services/manage/" . $service->id . "/ftpaccounts/addnew/?" . '"+ form, form);
        });
        $("#generate").click(function () {
            doAjaxGet("' . $this->base_uri . "services/manage/" . $service->id . "/changepassword/generatepass/" . '", "' . Language::_("tastyinterworx.generated_password", true) . '");
        });
    });
</script>


    ';
                $this->Form->end();
            }

            exit();
        }
    }

    public function ftpaccountsmain($package, $service, array $get = null, array $post = null, array $files = null) {
        $customfiles = $this->customStyleJS();
        $this->view = new View("ftpaccounts", "default");
        $this->view->base_uri = $this->base_uri;
        Loader::loadHelpers($this, array("Form", "Html"));
        $service_fields = $this->serviceFieldsToObject($service->fields);
        $module_row = $this->getModuleRow($package->module_row);
        $api = $this->getApi($module_row->meta);

        if (isset($post['delete_ftp'])) {
            if (!empty($post['user'])) {
                $delete_email = $api->DeleteFtpAccount($service_fields->email, $service_fields->password, $service_fields->domain, $post);
                $this->log($module_row->meta->hostname . "|Delete FTP Account", serialize("DeleteFtpAccount"), "input", true);
            } else {
                $error = array(
                    0 => array(
                        "result" => Language::_("tastyinterworx.empty_invalid_values", true)
                    )
                );
                $this->Input->setErrors($error[0]);
            }
        }





        $ftpacc = $api->listFtpAccounts($service_fields->email, $service_fields->password, $service_fields->domain);
        $this->view->set("module_row", $module_row);
        $this->view->set("service_fields", $service_fields);
        $this->view->set("ftpacc", $ftpacc['payload']);
        $this->view->set("emaildomains", array($service_fields->domain => $service_fields->domain));
        $this->view->set("type", $package->meta->type);
        $this->view->set("service_id", $service->id);



        $this->view->setDefaultView("components" . DS . "modules" . DS . "tastyinterworxmodule" . DS);
        return $customfiles . $this->view->fetch();
    }

    public function emailaliasaddnew($package, $service, array $get = null, array $post = null, array $files = null) {

        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            Loader::loadHelpers($this, array("Form", "Html"));
            $service_fields = $this->serviceFieldsToObject($service->fields);
            $module_row = $this->getModuleRow($package->module_row);
            $api = $this->getApi($module_row->meta);
            if (isset($post) && !empty($post)) {
                if ($post['email'] !== "" && $post['destination'] !== "") {
                    Loader::loadModels($this, array("Services"));
                    $add_new = $api->addEmailAlias($service_fields->email, $service_fields->password, $service_fields->domain, $post);
                    $this->log($module_row->meta->hostname . "|Add New Email Alias", serialize("addEmailAlias"), "input", true);
                    if ($add_new['status'] !== 0) {
                        $siteworx_error = str_replace('Please see details below.', '', $add_new['payload']);
                        $siteworx_error = strstr($siteworx_error, "Usage", true);
                        echo "<div class='alert alert-danger alert-dismissable'>
		<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
				<p>{$siteworx_error}</p>
			</div>";
                    } else {
                        echo "<div class='alert alert-success alert-dismissable'>
		<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
				<p>" . Language::_("tastyinterworx.success", true) . "</p>
			</div><script>$(document).ready(function (e) { $('#global_modal').modal('hide');});</script>";
                    }
                } else {
                    $error = array(
                        0 => array(
                            "result" => Language::_("tastyinterworx.empty_invalid_values", true)
                        )
                    );
                    echo "<div class='alert alert-danger alert-dismissable'>
		<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
				<p>{$error[0]['result']}</p>
			</div>";
                }
            } else {
                $customfiles = $this->customStyleJS();
                $select_option = "<select name='domain' class='form-control' id='domain'>";
                $select_option .= "<option value='{$service_fields->domain}'>{$service_fields->domain}</option>";
                $select_option .= "</select>";

                $this->Form->create("", array('onsubmit' => 'return false', 'id' => 'addform', 'autocomplete' => "off"));
                echo" {$customfiles}
            <div class='modal-body'>
<div class='div_response'></div>";

                echo'<div class="form-group">
   <label>' . Language::_("tastyinterworx.email.email_address", true) . '</label>
    <input type="email" class="form-control" value="" id="email" name="email" placeholder=""></div>
    <div class="form-group">
   <label>' . Language::_("tastyinterworx.email.domain", true) . '</label>
   ' . $select_option . '</div>
  <div class="form-group"> <label>' . Language::_("tastyinterworx.email.destination", true) . '</label>
    <input type="text" class="form-control" value="" id="destination" name="destination" placeholder=""></div>
</div>
</div>
<div class="modal-footer">
<button type="button" name="cancel" class="btn btn-default" data-dismiss="modal"><i class="fa fa-ban"></i> ' . Language::_("tastyinterworx.cancel", true) . '</button>
<button type="button" class="btn btn-primary" name="add_new" id="addnewsubmit"><i class="fa fa-plus-circle"></i> ' . Language::_("tastyinterworx.submit", true) . '</button>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $("#addnewsubmit").click(function () {
    var form = $("#addform").serialize();
    doAjaxPost("' . $this->base_uri . "services/manage/" . $service->id . "/emailalias/addnew/?" . '"+ form, form);
        });
    });
</script>


    ';
                $this->Form->end();
            }

            exit();
        }
    }

    public function emailaliasmain($package, $service, array $get = null, array $post = null, array $files = null) {
        $customfiles = $this->customStyleJS();
        $this->view = new View("emailalias", "default");
        $this->view->base_uri = $this->base_uri;
        Loader::loadHelpers($this, array("Form", "Html"));
        $service_fields = $this->serviceFieldsToObject($service->fields);
        $module_row = $this->getModuleRow($package->module_row);
        $api = $this->getApi($module_row->meta);

        if (isset($post['delete_email'])) {
            if (!empty($post['username'])) {
                $delete_email = $api->deleteEmailAlias($service_fields->email, $service_fields->password, $service_fields->domain, $post);
                $this->log($module_row->meta->hostname . "|Delete Email Alias", serialize("deleteEmailBox"), "input", true);
            } else {
                $error = array(
                    0 => array(
                        "result" => Language::_("tastyinterworx.empty_invalid_values", true)
                    )
                );
                $this->Input->setErrors($error[0]);
            }
        }





        $emailalias = $api->listEmailAlias($service_fields->email, $service_fields->password, $service_fields->domain);
        $this->view->set("module_row", $module_row);
        $this->view->set("service_fields", $service_fields);
        $this->view->set("emailalias", $emailalias['payload']);
        $this->view->set("emaildomains", array($service_fields->domain => $service_fields->domain));
        $this->view->set("type", $package->meta->type);
        $this->view->set("service_id", $service->id);



        $this->view->setDefaultView("components" . DS . "modules" . DS . "tastyinterworxmodule" . DS);
        return $customfiles . $this->view->fetch();
    }

    public function emailaddnew($package, $service, array $get = null, array $post = null, array $files = null) {

        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            Loader::loadHelpers($this, array("Form", "Html"));
            $service_fields = $this->serviceFieldsToObject($service->fields);
            $module_row = $this->getModuleRow($package->module_row);
            $api = $this->getApi($module_row->meta);
            if (isset($post) && !empty($post)) {
                if ($post['password'] !== "" && $post['email'] !== "" && $post['domain'] !== "" && $post['quota'] !== "") {
                    Loader::loadModels($this, array("Services"));
                    if ($post['quota'] === "unlimited") {
                        $post['quota'] = "999999999";
                    }
                    $add_new = $api->addEmailBox($service_fields->email, $service_fields->password, $service_fields->domain, $post);
                    $this->log($module_row->meta->hostname . "|Add New Email", serialize("addEmailBox"), "input", true);
                    if ($add_new['status'] !== 0) {
                        $siteworx_error = str_replace('Please see details below.', '', $add_new['payload']);
                        $siteworx_error = strstr($siteworx_error, "Usage", true);
                        echo "<div class='alert alert-danger alert-dismissable'>
		<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
				<p>{$siteworx_error}</p>
			</div>";
                    } else {
                        echo "<div class='alert alert-success alert-dismissable'>
		<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
				<p>" . Language::_("tastyinterworx.success", true) . "</p>
			</div><script>$(document).ready(function (e) { $('#global_modal').modal('hide');});</script>";
                    }
                } else {
                    $error = array(
                        0 => array(
                            "result" => Language::_("tastyinterworx.empty_invalid_values", true)
                        )
                    );
                    echo "<div class='alert alert-danger alert-dismissable'>
		<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
				<p>{$error[0]['result']}</p>
			</div>";
                }
            } else {
                $customfiles = $this->customStyleJS();
                $select_option = "<select name='domain' class='form-control' id='domain'>";
                $select_option .= "<option value='{$service_fields->domain}'>{$service_fields->domain}</option>";
                $select_option .= "</select>";

                $this->Form->create("", array('onsubmit' => 'return false', 'id' => 'addform', 'autocomplete' => "off"));
                echo" {$customfiles}
            <div class='modal-body'>
<div class='div_response'></div>";

                echo'<div class="form-group">
   <label>' . Language::_("tastyinterworx.email.email_address", true) . '</label>
    <input type="email" class="form-control" value="" id="email" name="email" placeholder=""></div>
    <div class="form-group">
   <label>' . Language::_("tastyinterworx.email.domain", true) . '</label>
   ' . $select_option . '</div>
  <div class="form-group"> <label>' . Language::_("tastyinterworx.email.quota", true) . '</label>
    <input type="text" class="form-control" value="" id="quota" name="quota" placeholder="e.g: 250 OR Unlimited"></div>
   <div class="form-group"><label>' . Language::_("tastyinterworx.password", true) . '</label>
    <input type="password" class="form-control" value="" id="password" name="password" placeholder="***********"></div>
<div class="new_div"></div>
</div>
</div>
<div class="modal-footer">
<button type="button" name="cancel" class="btn btn-default" data-dismiss="modal"><i class="fa fa-ban"></i> ' . Language::_("tastyinterworx.cancel", true) . '</button>
<button type="button" class="btn btn-default" id="generate"><i class="fa fa-key"></i> ' . Language::_("tastyinterworx.service.generate", true) . '</button>
<button type="button" class="btn btn-primary" name="add_new" id="addnewsubmit"><i class="fa fa-plus-circle"></i> ' . Language::_("tastyinterworx.submit", true) . '</button>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $("#addnewsubmit").click(function () {
    var form = $("#addform").serialize();
    doAjaxPost("' . $this->base_uri . "services/manage/" . $service->id . "/email/addnew/?" . '"+ form, form);
        });
        $("#generate").click(function () {
            doAjaxGet("' . $this->base_uri . "services/manage/" . $service->id . "/changepassword/generatepass/" . '", "' . Language::_("tastyinterworx.generated_password", true) . '");
        });
    });
</script>


    ';
                $this->Form->end();
            }

            exit();
        }
    }

    public function emailchangepassword($package, $service, array $get = null, array $post = null, array $files = null) {

        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            if (isset($get["email"])) {
                Loader::loadHelpers($this, array("Form", "Html"));
                $service_fields = $this->serviceFieldsToObject($service->fields);
                $module_row = $this->getModuleRow($package->module_row);
                $api = $this->getApi($module_row->meta);
                if (isset($post) && !empty($post)) {
                    if ($post['password'] !== "" && $post['email'] !== "") {
                        Loader::loadModels($this, array("Services"));
                        $change_password = $api->editEmailBox($service_fields->email, $service_fields->password, $service_fields->domain, $post);
                        $this->log($module_row->meta->hostname . "|Change Email Password", serialize("editEmailBox"), "input", true);
                        if ($change_password['status'] !== 0) {
                            $siteworx_error = str_replace('Please see details below.', '', $change_password['payload']);
                            $siteworx_error = strstr($siteworx_error, "Usage", true);
                            echo "<div class='alert alert-danger alert-dismissable'>
		<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
				<p>{$siteworx_error}</p>
			</div>";
                        } else {
                            echo "<div class='alert alert-success alert-dismissable'>
		<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
				<p>" . Language::_("tastyinterworx.success", true) . "</p>
			</div><script>$(document).ready(function (e) { $('#global_modal').modal('hide');});</script>";
                        }
                    } else {
                        $error = array(
                            0 => array(
                                "result" => Language::_("tastyinterworx.empty_invalid_values", true)
                            )
                        );
                        echo "<div class='alert alert-danger alert-dismissable'>
		<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
				<p>{$error[0]['result']}</p>
			</div>";
                    }
                } else {
                    $customfiles = $this->customStyleJS();

                    $this->Form->create("", array('onsubmit' => 'return false', 'id' => 'changepassform', 'autocomplete' => "off"));
                    echo" {$customfiles}
            <div class='modal-body'>
<div class='div_response'></div>";
                    $this->Form->fieldHidden("email", $this->Html->ifSet($get["email"]), array('id' => "email"));

                    echo'<div class="form-group">
   <label>' . Language::_("tastyinterworx.changepassword", true) . " " . Language::_("tastyinterworx.for", true) . " " . $get["email"] . '</label>
    <input type="password" class="form-control" value="" id="password" name="password" placeholder="**********">
</div>
<div class="new_div"></div>
</div>
<div class="modal-footer">
<button type="button" name="cancel" class="btn btn-default" data-dismiss="modal"><i class="fa fa-ban"></i> ' . Language::_("tastyinterworx.cancel", true) . '</button>
<button type="button" class="btn btn-default" id="generate"><i class="fa fa-key"></i> ' . Language::_("tastyinterworx.service.generate", true) . '</button>
<button type="button" class="btn btn-primary" name="change_password" id="change_password"><i class="fa fa-edit"></i> ' . Language::_("tastyinterworx.submit", true) . '</button>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $("#change_password").click(function () {
    var form = $("#changepassform").serialize();
    doAjaxPost("' . $this->base_uri . "services/manage/" . $service->id . "/email/changepassword/?" . '"+ form, form);
        });
        $("#generate").click(function () {
            doAjaxGet("' . $this->base_uri . "services/manage/" . $service->id . "/changepassword/generatepass/" . '", "' . Language::_("tastyinterworx.generated_password", true) . '");
        });
    });
</script>


    ';
                    $this->Form->end();
                }

                exit();
            } else {
                return false;
            }
        }
    }

    public function emailmain($package, $service, array $get = null, array $post = null, array $files = null) {
        $customfiles = $this->customStyleJS();
        $this->view = new View("email", "default");
        $this->view->base_uri = $this->base_uri;
        Loader::loadHelpers($this, array("Form", "Html"));
        $service_fields = $this->serviceFieldsToObject($service->fields);
        $module_row = $this->getModuleRow($package->module_row);
        $api = $this->getApi($module_row->meta);

        if (isset($post['delete_email'])) {
            if (!empty($post['username'])) {
                $delete_email = $api->deleteEmailBox($service_fields->email, $service_fields->password, $service_fields->domain, $post);
                $this->log($module_row->meta->hostname . "|Delete Email Account", serialize("deleteEmailBox"), "input", true);
            } else {
                $error = array(
                    0 => array(
                        "result" => Language::_("tastyinterworx.empty_invalid_values", true)
                    )
                );
                $this->Input->setErrors($error[0]);
            }
        }





        $email = $api->listEmailBoxes($service_fields->email, $service_fields->password, $service_fields->domain);
        $this->view->set("module_row", $module_row);
        $this->view->set("service_fields", $service_fields);
        $this->view->set("email", $email['payload']);
        $this->view->set("emaildomains", array($service_fields->domain => $service_fields->domain));
        $this->view->set("type", $package->meta->type);
        $this->view->set("service_id", $service->id);



        $this->view->setDefaultView("components" . DS . "modules" . DS . "tastyinterworxmodule" . DS);
        return $customfiles . $this->view->fetch();
    }

    public function changepassword($package, $service, array $get = null, array $post = null, array $files = null) {
        if (isset($get[2]) && $get[2] === "generatepass") {
            return $this->generatepass($package, $service, $get, $post, $files);
        } else {
            if ($package->meta->changepassword !== "false") {
                $customfiles = $this->customStyleJS();
                $this->view = new View("change_password", "default");
                $this->view->setDefaultView("components" . DS . "modules" . DS . "tastyinterworxmodule" . DS);
                $this->view->base_uri = $this->base_uri;
                // Load the helpers required for this view
                Loader::loadHelpers($this, array("Form", "Html"));

                $service_fields = $this->serviceFieldsToObject($service->fields);
                if (isset($post['changepassword'])) {
                    if ($post['password'] !== "" && $post['confirm_password'] !== "") {
                        if ($post['password'] != $post['confirm_password']) {
                            $error = array(
                                0 => array(
                                    "result" => Language::_("tastyinterworx.error.passwordemptymatch", true)
                                )
                            );
                            $this->Input->setErrors($error);
                        } else {
                            Loader::loadModels($this, array("Services"));
                            $data = array(
                                'domain' => $this->Html->ifSet($service_fields->domain),
                                'email' => $this->Html->ifSet($service_fields->email),
                                'reseller_id' => $this->Html->ifSet($service_fields->reseller_id),
                                'password' => $this->Html->ifSet($post['password']),
                                'confirm_password' => $this->Html->ifSet($post['confirm_password'])
                            );
                            $this->Services->edit($service->id, $data);

                            if ($this->Services->errors()) {
                                $this->Input->setErrors($this->Services->errors());
                            }
                        }
                    } else {
                        $error = array(
                            0 => array(
                                "result" => Language::_("tastyinterworx.error.passwordemptymatch", true)
                            )
                        );
                        $this->Input->setErrors($error);
                    }
                }
                $this->view->set("webdir", WEBDIR);
                $this->view->set("post", (object) $post);
                $this->view->set("service_fields", $service_fields);
                $this->view->set("service_id", $service->id);

                return $customfiles . $this->view->fetch();
            }
        }
    }

    public function accountusage($package, $service, array $get = null, array $post = null, array $files = null) {
        if ($package->meta->accountusage !== "false") {
            $service_fields = $this->serviceFieldsToObject($service->fields);
            $module_row = $this->getModuleRow($package->module_row);


            if ($package->meta->type === "standard") {
                $this->view = new View("account_usage", "default");
                $this->view->base_uri = $this->base_uri;
                $api = $this->getApi($module_row->meta);
                $accountDetails = $api->getSiteworxAccountInfo($service_fields->domain);

                foreach ($accountDetails['payload'] as $key => $value) {
                    if ($key !== "bandwidth" && $key !== "storage" && $key !== "storage_used" && $key !== "bandwidth_used") {
                        if ($accountDetails['payload'][$key] >= 999999999) {
                            $accountDetails['payload'][$key] = "Unlimited";
                        }
                    }
                }
                $this->view->set("name_servers", $module_row->meta->name_servers);
                $this->view->set("module_row", $module_row);
                $this->view->set("service_fields", $service_fields);
                $this->view->set("accountDetails", $accountDetails['payload']);
                $this->view->set("type", $package->meta->type);
                $this->view->set("service_id", $service->id);
                $this->view->set("pmeta", $package->meta);
            } else if ($package->meta->type === "reseller") {
                $this->view = new View("account_usage_reseller", "default");
                $this->view->base_uri = $this->base_uri;
                $api = $this->getApi($module_row->meta);
                $accountDetails = $api->getResellerAccountInfo($service_fields->email);
                foreach ($accountDetails['payload'] as $key => $value) {
                    if ($key !== "RSL_OPT_STORAGE" && $key !== "RSL_OPT_SITEWORX_ACCOUNTS" && $key !== "RSL_OPT_BANDWIDTH" && $key !== "bandwidth_used" && $key !== "storage_used" && $key !== "accounts_used") {
                        if ($accountDetails['payload'][$key] >= 999999999) {
                            $accountDetails['payload'][$key] = "Unlimited";
                        }
                    }
                }
                $this->view->set("module_row", $module_row);
                $this->view->set("service_fields", $service_fields);
                $this->view->set("accountDetails", $accountDetails['payload']);
                $this->view->set("type", $package->meta->type);
                $this->view->set("service_id", $service->id);
                $this->view->set("pmeta", $package->meta);
            }
            $customfiles = $this->customStyleJS();
            Loader::loadHelpers($this, array("Form", "Html"));

            $this->view->setDefaultView("components" . DS . "modules" . DS . "tastyinterworxmodule" . DS);
            return $customfiles . $this->view->fetch();
        }
    }

    public function generatepass($package, $service, array $get = null, array $post = null, array $files = null) {

        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            echo '<div class="form-group">
            <label for="">Copy &amp; Paste The Following Password</label>
            <input type="text" class="form-control" readonly="readonly" value="' . $this->generatePassword() . '">
            </div>';

            exit();
        } else {
            return false;
        }
    }

    public function moduleRowName() {
        return Language::_("tastyinterworx.module_row", true);
    }

    public function moduleRowNamePlural() {
        return Language::_("tastyinterworx.module_row_plural", true);
    }

    public function moduleGroupName() {
        return Language::_("tastyinterworx.module_group", true);
    }

    public function moduleRowMetaKey() {
        return "hostname";
    }

    public function getGroupOrderOptions() {
        return array('first' => Language::_("tastyinterworx.order_options.first", true));
    }

    public function selectModuleRow($module_group_id) {
        if (!isset($this->ModuleManager))
            Loader::loadModels($this, array("ModuleManager"));

        $group = $this->ModuleManager->getGroup($module_group_id);

        if ($group) {
            switch ($group->add_order) {
                default:
                case "first":

                    foreach ($group->rows as $row) {
                        return $row->id;
                    }

                    break;
            }
        }
        return 0;
    }

    private function gettastyinterworxIsReseller($module_row) {

        $api = $this->getApi($module_row->meta);

        $action = $module_row->meta->hostname . "|CheckUserIsReseller";
        $this->log($action, serialize($module_row->meta->hostname), "input", true);
        return $api->userIsReseller();
    }

    private function gettastyinterworxPackages($module_row, $reseller = false) {
        $api = $this->getApi($module_row->meta);

        if ($reseller == true) {
            $action = $module_row->meta->hostname . "|listResellerPackages";
            $this->log($action, serialize($module_row->meta->hostname), "input", true);

            $packages = $api->listResellerPackages();
        } else {
            $action = $module_row->meta->hostname . "|listPackages";
            $this->log($action, serialize($module_row->meta->hostname), "input", true);

            $packages = $api->listPackages();
        }


        $array = array();
        foreach ($packages['payload'] as $key => $value) {
            $array[$packages['payload'][$key]['name']] = $packages['payload'][$key]['name'];
        }

        return $array;
    }

    public function getPackageFields($vars = null) {
        Loader::loadHelpers($this, array("Html"));

        $fields = new ModuleFields();
        $fields->setHtml("
            <script type=\"text/javascript\">
                $(document).ready(function() {
                    // Re-fetch module options
                    $('#type, #manageapps').change(function() {
                        fetchModuleOptions();
                    });
                });
            </script>
        ");

        $module_row = null;
        if (isset($vars->module_group) && $vars->module_group == "") {

            if (isset($vars->module_row) && $vars->module_row > 0)
                $module_row = $this->getModuleRow($vars->module_row);
            else {

                $rows = $this->getModuleRows();
                if (isset($rows[0]))
                    $module_row = $rows[0];
                unset($rows);
            }
        }
        else {

            $rows = $this->getModuleRows($vars->module_group);
            if (isset($rows[0]))
                $module_row = $rows[0];
            unset($rows);
        }
        if ($module_row) {
            if (isset($vars->meta['type']) && $vars->meta['type'] === "reseller" && !$this->gettastyinterworxIsReseller($module_row)) {
                $packages = $this->gettastyinterworxPackages($module_row, true);
            } else {
                $packages = $this->gettastyinterworxPackages($module_row);
            }
        }

        $p_options = array('standard' => "Standard", 'reseller' => "Reseller");
        $typefield = $fields->label(Language::_("tastyinterworx.package.type", true), "type");
        $typefield->attach($fields->fieldSelect("meta[type]", $p_options, $this->Html->ifSet($vars->meta['type']), array('id' => "type")));
        $fields->setField($typefield);

        $package = $fields->label(Language::_("tastyinterworx.package", true), "package_name");
        $package->attach($fields->fieldSelect("meta[package]", $packages, $this->Html->ifSet($vars->meta['package']), array('id' => "package_name")));
        $fields->setField($package);

        $select_options = array('true' => "Enable", 'false' => "Disable");
        $accountusagefield = $fields->label(Language::_("tastyinterworx.accountusage", true), "accountusage");
        $accountusagefield->attach($fields->fieldSelect("meta[accountusage]", $select_options, $this->Html->ifSet($vars->meta['accountusage']), array('id' => "accountusage")));
        $fields->setField($accountusagefield);

        $changepasswordfield = $fields->label(Language::_("tastyinterworx.changepassword", true), "changepassword");
        $changepasswordfield->attach($fields->fieldSelect("meta[changepassword]", $select_options, $this->Html->ifSet($vars->meta['changepassword']), array('id' => "changepassword")));
        $fields->setField($changepasswordfield);

        if ($vars->meta['type'] !== "reseller") {

            $emailfield = $fields->label(Language::_("tastyinterworx.email", true), "email");
            $emailfield->attach($fields->fieldSelect("meta[email]", $select_options, $this->Html->ifSet($vars->meta['email']), array('id' => "email")));
            $fields->setField($emailfield);

            $emailaliasfield = $fields->label(Language::_("tastyinterworx.emailalias", true), "emailalias");
            $emailaliasfield->attach($fields->fieldSelect("meta[emailalias]", $select_options, $this->Html->ifSet($vars->meta['emailalias']), array('id' => "emailalias")));
            $fields->setField($emailaliasfield);

            $ftpaccountsfield = $fields->label(Language::_("tastyinterworx.ftpaccounts", true), "ftpaccounts");
            $ftpaccountsfield->attach($fields->fieldSelect("meta[ftpaccounts]", $select_options, $this->Html->ifSet($vars->meta['ftpaccounts']), array('id' => "ftpaccounts")));
            $fields->setField($ftpaccountsfield);

            $subdomainsfield = $fields->label(Language::_("tastyinterworx.subdomains", true), "subdomains");
            $subdomainsfield->attach($fields->fieldSelect("meta[subdomains]", $select_options, $this->Html->ifSet($vars->meta['subdomains']), array('id' => "subdomains")));
            $fields->setField($subdomainsfield);

            $secondarydomainsfield = $fields->label(Language::_("tastyinterworx.secondarydomains", true), "secondarydomains");
            $secondarydomainsfield->attach($fields->fieldSelect("meta[secondarydomains]", $select_options, $this->Html->ifSet($vars->meta['secondarydomains']), array('id' => "secondarydomains")));
            $fields->setField($secondarydomainsfield);

            $pointerdomainsfield = $fields->label(Language::_("tastyinterworx.pointerdomains", true), "pointerdomains");
            $pointerdomainsfield->attach($fields->fieldSelect("meta[pointerdomains]", $select_options, $this->Html->ifSet($vars->meta['pointerdomains']), array('id' => "pointerdomains")));
            $fields->setField($pointerdomainsfield);

            $databasesfield = $fields->label(Language::_("tastyinterworx.databases", true), "databases");
            $databasesfield->attach($fields->fieldSelect("meta[databases]", $select_options, $this->Html->ifSet($vars->meta['databases']), array('id' => "databases")));
            $fields->setField($databasesfield);

            $cronjobsfield = $fields->label(Language::_("tastyinterworx.cronjobs", true), "cronjobs");
            $cronjobsfield->attach($fields->fieldSelect("meta[cronjobs]", $select_options, $this->Html->ifSet($vars->meta['cronjobs']), array('id' => "cronjobs")));
            $fields->setField($cronjobsfield);

            $backupsfield = $fields->label(Language::_("tastyinterworx.backups", true), "backups");
            $backupsfield->attach($fields->fieldSelect("meta[backups]", $select_options, $this->Html->ifSet($vars->meta['backups']), array('id' => "backups")));
            $fields->setField($backupsfield);

            $manage_select = array('false' => "Disable", 'softaculous' => "Softaculous");
            $manageapps = $fields->label(Language::_("tastyinterworx.manageapps", true), "manageapps");
            $manageapps->attach($fields->fieldSelect("meta[manageapps]", $manage_select, $this->Html->ifSet($vars->meta['manageapps']), array('id' => "manageapps")));
            $fields->setField($manageapps);
        }
        if ($vars->meta['type'] === "reseller") {
            $nodeworxfield = $fields->label(Language::_("tastyinterworx.nodeworx_login", true), "nodeworx_login");
            $nodeworxfield->attach($fields->fieldSelect("meta[nodeworx_login]", $select_options, $this->Html->ifSet($vars->meta['nodeworx_login']), array('id' => "nodeworx_login")));
            $fields->setField($nodeworxfield);
        }
        if ($vars->meta['type'] !== "reseller") {

            $siteworxfield = $fields->label(Language::_("tastyinterworx.siteworx_login", true), "siteworx_login");
            $siteworxfield->attach($fields->fieldSelect("meta[siteworx_login]", $select_options, $this->Html->ifSet($vars->meta['siteworx_login']), array('id' => "siteworx_login")));
            $fields->setField($siteworxfield);
        }

        return $fields;
    }

    public function getEmailTags() {
        return array(
            'module' => array('hostname', 'name_servers', 'port'),
            'package' => array('type', 'package'),
            'service' => array('username', 'email', 'password', 'domain')
        );
    }

    public function addPackage(array $vars = null) {


        $this->Input->setRules($this->getPackageRules($vars));


        $meta = array();
        if ($this->Input->validates($vars)) {



            foreach ($vars['meta'] as $key => $value) {
                $meta[] = array(
                    'key' => $key,
                    'value' => $value,
                    'encrypted' => 0
                );
            }
        }
        return $meta;
    }

    public function editPackage($package, array $vars = null) {


        $this->Input->setRules($this->getPackageRules($vars));


        $meta = array();
        if ($this->Input->validates($vars)) {


            foreach ($vars['meta'] as $key => $value) {
                $meta[] = array(
                    'key' => $key,
                    'value' => $value,
                    'encrypted' => 0
                );
            }
        }
        return $meta;
    }

    public function manageModule($module, array &$vars) {

        $this->view = new View("manage", "default");
        $this->view->base_uri = $this->base_uri;
        $this->view->setDefaultView("components" . DS . "modules" . DS . "tastyinterworxmodule" . DS);


        Loader::loadHelpers($this, array("Form", "Html", "Widget"));

        $this->view->set("module", $module);

        return $this->view->fetch();
    }

    public function manageAddRow(array &$vars) {

        $this->view = new View("add_row", "default");
        $this->view->base_uri = $this->base_uri;
        $this->view->setDefaultView("components" . DS . "modules" . DS . "tastyinterworxmodule" . DS);


        Loader::loadHelpers($this, array("Form", "Html", "Widget"));

        $this->view->set("vars", (object) $vars);
        return $this->view->fetch();
    }

    public function manageEditRow($module_row, array &$vars) {
        $this->view = new View("edit_row", "default");
        $this->view->base_uri = $this->base_uri;
        $this->view->setDefaultView("components" . DS . "modules" . DS . "tastyinterworxmodule" . DS);


        Loader::loadHelpers($this, array("Form", "Html", "Widget"));

        if (empty($vars))
            $vars = $module_row->meta;


        $this->view->set("vars", (object) $vars);
        return $this->view->fetch();
    }

    public function addModuleRow(array &$vars) {
        $meta_fields = array("hostname", "apikey", "account_count", "use_ssl", "name_servers", "port");
        $encrypted_fields = array("hostname", "apikey", "account_count", "use_ssl", "name_servers", "port");

        $this->Input->setRules($this->getRowRules($vars));


        if ($this->Input->validates($vars)) {


            $meta = array();
            foreach ($vars as $key => $value) {

                if (in_array($key, $meta_fields)) {
                    $meta[] = array(
                        'key' => $key,
                        'value' => $value,
                        'encrypted' => in_array($key, $encrypted_fields) ? 1 : 0
                    );
                }
            }

            return $meta;
        }
    }

    public function editModuleRow($module_row, array &$vars) {
        $meta_fields = array("hostname", "apikey", "account_count", "use_ssl", "name_servers", "port");
        $encrypted_fields = array("hostname", "apikey", "account_count", "use_ssl", "name_servers", "port");

        $this->Input->setRules($this->getRowRules($vars));


        if ($this->Input->validates($vars)) {


            $meta = array();
            foreach ($vars as $key => $value) {

                if (in_array($key, $meta_fields)) {
                    $meta[] = array(
                        'key' => $key,
                        'value' => $value,
                        'encrypted' => in_array($key, $encrypted_fields) ? 1 : 0
                    );
                }
            }

            return $meta;
        }
    }

    public function deleteModuleRow($module_row) {

    }

    public function getServiceName($service) {
        foreach ($service->fields as $field) {
            if ($field->key == "domain")
                return $field->value;
        }
        return null;
    }

    public function getPackageServiceName($package, array $vars = null) {
        if ($package->meta->type === "standard") {
            if (isset($vars['domain']))
                return $vars['domain'];
        } else if ($package->meta->type === "reseller") {
            if (isset($vars['reseller_id']))
                return $vars['reseller_id'];
        }
        return null;
    }

    public function getAdminAddFields($package, $vars = null) {

        Loader::loadHelpers($this, array("Html"));

        $fields = new ModuleFields();
        $fields->setHtml("
       			<script type=\"text/javascript\" =>
    $(function() {
       $(\"#use_module_module\").removeAttr(\"disabled\");
      				});
			</script>
    ");
        if ($package->meta->type != "reseller") {
            // Create domain label
            $domain = $fields->label(Language::_("tastyinterworx.service_field.domain", true), "domain");
            // Create domain field and attach to domain label
            $domain->attach($fields->fieldText("domain", $this->Html->ifSet($vars->domain), array('id' => "domain")));
            // Set the label as a field
            $fields->setField($domain);
        } else {
            // Set a field for reseller ID
            $reseller_id = $fields->label(Language::_("tastyinterworx.service_field.reseller_id", true), "reseller_id");
            // Create domain field and attach to domain label
            $reseller_id->attach($fields->fieldText("reseller_id", $this->Html->ifSet($vars->reseller_id), array('id' => "reseller_id")));
            $tooltip = $fields->tooltip(Language::_("tastyinterworx.service_field.tooltip.reseller_id", true));
            $reseller_id->attach($tooltip);
            // Set the label as a field
            $fields->setField($reseller_id);
        }

        // Create email label
        $email = $fields->label(Language::_("tastyinterworx.service_field.email", true), "email");
        // Create email field and attach to email label
        $email->attach($fields->fieldText("email", $this->Html->ifSet($vars->email), array('id' => "email")));
        // Add tooltip
        $tooltip = $fields->tooltip(Language::_("tastyinterworx.service_field.tooltip.email", true));
        $email->attach($tooltip);
        // Set the label as a field
        $fields->setField($email);

        // Create username label
        $username = $fields->label(Language::_("tastyinterworx.service_field.username", true), "username");
        // Create username field and attach to username label
        $username->attach($fields->fieldText("username", $this->Html->ifSet($vars->username), array('id' => "username")));
        // Add tooltip
        $tooltip = $fields->tooltip(Language::_("tastyinterworx.service_field.tooltip.username", true));
        $username->attach($tooltip);
        // Set the label as a field
        $fields->setField($username);

        // Create password label
        $password = $fields->label(Language::_("tastyinterworx.service_field.password", true), "password");
        // Create password field and attach to password label
        $password->attach($fields->fieldPassword("password", array('id' => "password", 'value' => $this->Html->ifSet($vars->password))));
        // Add tooltip
        $tooltip = $fields->tooltip(Language::_("tastyinterworx.service_field.tooltip.password", true));
        $password->attach($tooltip);
        // Set the label as a field
        $fields->setField($password);

        // Create confirm_password label
        $confirm_password = $fields->label(Language::_("tastyinterworx.service_field.confirm_password", true), "confirm_password");
        // Create password field and attach to password label
        $confirm_password->attach($fields->fieldPassword("confirm_password", array('id' => "confirm_password", 'value' => $this->Html->ifSet($vars->password))));
        // Add tooltip
        $confirm_password->attach($tooltip);
        // Set the label as a field
        $fields->setField($confirm_password);

        return $fields;
    }

    public function getClientAddFields($package, $vars = null) {
        Loader::loadHelpers($this, array("Html"));

        $fields = new ModuleFields();

        // Create domain label
        $domain = $fields->label(Language::_("tastyinterworx.service_field.domain", true), "domain");
        // Create domain field and attach to domain label
        $domain->attach($fields->fieldText("domain", $this->Html->ifSet($vars->domain, $this->Html->ifSet($vars->domain)), array('id' => "domain")));
        // Set the label as a field
        $fields->setField($domain);

        return $fields;
    }

    public function getAdminEditFields($package, $vars = null) {

        Loader::loadHelpers($this, array("Html"));

        $fields = new ModuleFields();

        // Set a domain field if this is not a reseller
        if ((!isset($vars->reseller_id) || $vars->reseller_id == 0) && $package->meta->type != "reseller") {
            // Create domain label
            $domain = $fields->label(Language::_("tastyinterworx.service_field.domain", true), "domain");
            // Create email field and attach to email label
            $domain->attach($fields->fieldText("domain", $this->Html->ifSet($vars->domain), array('id' => "domain")));
            // Add tooltip
            $tooltip = $fields->tooltip(Language::_("tastyinterworx.service_field.tooltip.domain", true));
            $domain->attach($tooltip);
            // Set the label as a field
            $fields->setField($domain);
        } else {
            // Set a field for reseller ID
            $reseller_id = $fields->label(Language::_("tastyinterworx.service_field.reseller_id", true), "reseller_id");
            // Create domain field and attach to domain label
            $reseller_id->attach($fields->fieldText("reseller_id", $this->Html->ifSet($vars->reseller_id), array('id' => "reseller_id")));
            $tooltip = $fields->tooltip(Language::_("tastyinterworx.service_field.tooltip.reseller_id", true));
            $reseller_id->attach($tooltip);
            // Set the label as a field
            $fields->setField($reseller_id);
        }

        // Create email label
        $email = $fields->label(Language::_("tastyinterworx.service_field.email", true), "email");
        // Create email field and attach to email label
        $email->attach($fields->fieldText("email", $this->Html->ifSet($vars->email), array('id' => "email")));
        // Set the label as a field
        $fields->setField($email);

        // Create username label
        $username = $fields->label(Language::_("tastyinterworx.service_field.username", true), "username");
        // Create username field and attach to username label
        $username->attach($fields->fieldText("username", $this->Html->ifSet($vars->username), array('id' => "username")));
        // Set the label as a field
        $fields->setField($username);

        // Create password label
        $password = $fields->label(Language::_("tastyinterworx.service_field.password", true), "password");
        // Create password field and attach to password label
        $password->attach($fields->fieldPassword("password", array('id' => "password", 'value' => $this->Html->ifSet($vars->password))));
        // Set the label as a field
        $fields->setField($password);

        return $fields;
    }

    public function validateService($package, array $vars = null, $edit = false) {
        $rules = array(
            'domain' => array(
                'format' => array(
                    'rule' => array(array($this, "hostnameValidator")),
                    'message' => Language::_("tastyinterworx.error.service.domain.format", true)
                )
            )
        );
        if ($package->meta->type == "reseller")
            unset($rules['domain']);

        $this->Input->setRules($rules);
        return $this->Input->validates($vars);
    }

    private function generateUsername($hostname) {
        // Remove everything except letters and numbers from the domain
        // ensure no number appears in the beginning
        $username = ltrim(preg_replace('/[^a-z0-9]/i', '', $hostname), '0123456789');

        $length = strlen($username);
        $pool = "abcdefghijklmnopqrstuvwxyz0123456789";
        $pool_size = strlen($pool);

        if ($length < 5) {
            for ($i = $length; $i < 8; $i++) {
                $username .= substr($pool, mt_rand(0, $pool_size - 1), 1);
            }
            $length = strlen($username);
        }

        return substr($username, 0, min($length, 8));
    }

    private function generatePassword($min_length = 10, $max_length = 14) {
        $pool = "abcdefghijklmnopqrstuvwxyz0123456789";
        $pool_size = strlen($pool);
        $length = mt_rand(max($min_length, 5), min($max_length, 14));
        $password = "";

        for ($i = 0; $i < $length; $i++) {
            $password .= substr($pool, mt_rand(0, $pool_size - 1), 1);
        }

        return $password;
    }

    private function getFieldsFromInput(array $vars, $package) {
        $fields = array(
            'domain' => isset($vars['domain']) ? $vars['domain'] : null,
            'email' => isset($vars['email']) ? $vars['email'] : null,
            'username' => isset($vars['username']) ? $vars['username'] : null,
            'password' => $this->generatePassword(),
            'plan' => $package->meta->package,
            'reseller' => ($package->meta->type == "reseller" ? 1 : 0)
        );

        return $fields;
    }

    public function addService($package, array $vars = null, $parent_package = null, $parent_service = null, $status = "pending") {
        $row = $this->getModuleRow($package->module_row);
        $api = $this->getApi($row->meta);

        if (!$row) {
            $this->Input->setErrors(array('module_row' => array('missing' => Language::_("tastyinterworx.!error.module_row.missing", true))));
            return;
        }


        Loader::loadModels($this, array("Clients"));
        if (isset($vars['client_id']) && ($client = $this->Clients->get($vars['client_id'], false)))
            $client_email = $client->email;

        if (isset($vars['domain']) && $package->meta->type != "reseller")
            $username = $this->generateUsername($vars['domain']);
        elseif ($package->meta->type == "reseller")
            $username = $client->first_name;


        $vars['email'] = $client_email;
        $vars['username'] = $username;

        $params = $this->getFieldsFromInput((array) $vars, $package);

        $this->validateService($package, $vars);

        if ($this->Input->errors())
            return;


        if ($vars['use_module'] == "true") {


            if ($package->meta->type == "reseller") {
                $masked_params = $params;
                $masked_params['password'] = "***";
                $this->log($row->meta->hostname . "|createResellerAccount", serialize($masked_params), "input", true);
                unset($masked_params);
                $result = $api->createResellerAccount($params);
            } else if ($package->meta->type == "standard") {
                $masked_params = $params;
                $masked_params['password'] = "***";
                $this->log($row->meta->hostname . "|createSiteWorxAccount", serialize($masked_params), "input", true);
                unset($masked_params);

                $result = $api->createSiteWorxAccount($params);
            }


            if ($result['status'] == 0) {
                if ($package->meta->type == "reseller") {
                    $reseller_id = (isset($result['payload']['reseller_id']) ? $result['payload']['reseller_id'] : (!empty($vars['reseller_id']) ? $vars['reseller_id'] : 0));
                }
            } else {
                $siteworx_error = str_replace('Please see details below.', '', $result['payload']);
                $siteworx_error = strstr($siteworx_error, "Usage", true);
                $fa = array(
                    0 => array(
                        "result" => "{$siteworx_error}"
                    )
                );
                $this->Input->setErrors($fa);
                return FALSE;
            }



            if ($this->Input->errors())
                return;
        }


        return array(
            array(
                'key' => "domain",
                'value' => $params['domain'],
                'encrypted' => 0
            ),
            array(
                'key' => "email",
                'value' => $params['email'],
                'encrypted' => 0
            ),
            array(
                'key' => "reseller_id",
                'value' => isset($reseller_id) ? $reseller_id : 0,
                'encrypted' => 0
            ),
            array(
                'key' => "username",
                'value' => $params['username'],
                'encrypted' => 1
            ),
            array(
                'key' => "password",
                'value' => $params['password'],
                'encrypted' => 1
            )
        );
    }

    public function editService($package, $service, array $vars = null, $parent_package = null, $parent_service = null) {
        $row = $this->getModuleRow($package->module_row);
        $api = $this->getApi($row->meta);

        $this->validateService($package, $vars, true);

        if ($this->Input->errors())
            return;

        $service_fields = $this->serviceFieldsToObject($service->fields);

        // Set 0 for reseller ID if none set
        if (empty($vars['reseller_id']))
            $vars['reseller_id'] = 0;

        // Only provision the service if 'use_module' is true
        if ($vars['use_module'] == "true") {

            $input = array(
                'email' => (isset($vars['email']) ? $vars['email'] : $service_fields->email),
                'nickname' => (isset($vars['username']) ? $vars['username'] : $service_fields->username)
            );

            if (isset($vars['password'])) {
                $input['password'] = $vars['password'];
            }

            if ($package->meta->type == "reseller") {
                $input['reseller_id'] = $service_fields->reseller_id;

                $action = $row->meta->hostname . "|modifyReseller";
                $this->log($action, serialize($input), "input", true);

                $result = $api->editResellerAccount($input);
            } else {
                $input['domain'] = $service_fields->domain;

                $action = $row->meta->hostname . "|modifyAccount";
                $this->log($action, serialize($input), "input", true);

                $result = $api->editSiteWorxAccount($input);
            }
            if ($result['status'] == 0) {

            } else {
                $siteworx_error = str_replace('Please see details below.', '', $result['payload']);
                $siteworx_error = strstr($siteworx_error, "Usage", true);
                $fa = array(
                    0 => array(
                        "result" => "{$siteworx_error}"
                    )
                );
                $this->Input->setErrors($fa);
                return FALSE;
            }
        }


        // Set fields to update locally
        $fields = array("reseller_id", "domain", "username", "email", "password");
        foreach ($fields as $field) {
            if (property_exists($service_fields, $field) && isset($vars[$field]))
                $service_fields->{$field} = $vars[$field];
        }

        // Return all the service fields
        $fields = array();
        $encrypted_fields = array("username", "password");
        foreach ($service_fields as $key => $value)
            $fields[] = array('key' => $key, 'value' => $value, 'encrypted' => (in_array($key, $encrypted_fields) ? 1 : 0));

        return $fields;
    }

    public function suspendService($package, $service, $parent_package = null, $parent_service = null) {
        $row = $this->getModuleRow($package->module_row);

        if ($row) {
            $api = $this->getApi($row->meta);

            $service_fields = $this->serviceFieldsToObject($service->fields);

            if ($package->meta->type == "reseller") {
                $action = $row->meta->hostname . "|suspendReseller";
                $this->log($action, serialize($service_fields->reseller_id), "input", true);
                $api->suspendedResellerAccount($service_fields->reseller_id);
            } else {
                $action = $row->meta->hostname . "|suspendAccount";
                $this->log($action, serialize($service_fields->username), "input", true);
                $api->suspendedSiteWorxAccount($service_fields->domain);
            }
        }

        return null;
    }

    public function unsuspendService($package, $service, $parent_package = null, $parent_service = null) {
        if (($row = $this->getModuleRow($package->module_row))) {
            $api = $this->getApi($row->meta);

            $service_fields = $this->serviceFieldsToObject($service->fields);

            if ($package->meta->type == "reseller") {
                $action = $row->meta->hostname . "|unsuspendReseller";
                $this->log($action, serialize($service_fields->reseller_id), "input", true);
                $api->unsuspendResellerAccount($service_fields->reseller_id);
            } else {
                $action = $row->meta->hostname . "|unsuspendAccount";
                $this->log($action, serialize($service_fields->username), "input", true);
                $api->unsuspendSiteWorxAccount($service_fields->domain);
            }
        }
        return null;
    }

    public function cancelService($package, $service, $parent_package = null, $parent_service = null) {
        if (($row = $this->getModuleRow($package->module_row))) {
            $api = $this->getApi($row->meta);

            $service_fields = $this->serviceFieldsToObject($service->fields);

            if ($package->meta->type == "reseller") {
                $action = $row->meta->hostname . "|removeReseller";
                $this->log($action, serialize($service_fields->reseller_id), "input", true);
                $api->deleteResellerAccount($service_fields->reseller_id);
            } else {
                $action = $row->meta->hostname . "|removeAccount";
                $this->log($action, serialize($service_fields->username), "input", true);
                $api->deleteSiteWorxAccount($service_fields->domain);
            }

            if ($this->Input->errors())
                return;

            // Update the number of accounts on the server
            $this->updateAccountCount($row);

            // Remove any errors set when attempting to update the account count
            if ($this->Input->errors())
                $this->Input->setErrors(array());
        }

        return null;
    }

    public function changeServicePackage($package_from, $package_to, $service, $parent_package = null, $parent_service = null) {

        if (($row = $this->getModuleRow($package->module_row))) {
            $api = $this->getApi($row->meta);

            // Only request a package change if it has changed
            if ($package_from->meta->package != $package_to->meta->package) {

                $service_fields = $this->serviceFieldsToObject($service->fields);

                $input = array();
                $input["plan"] = $package_to->meta->package;

                if ($package_from->meta->type == "reseller" && $package_to->meta->type == "reseller") {
                    $input['reseller_id'] = $service_fields->reseller_id;

                    $action = $row->meta->hostname . "|modifyReseller";
                    $this->log($action, serialize($input), "input", true);

                    $api->editResellerAccount($input);
                } else if ($package_from->meta->type != "reseller" && $package_to->meta->type != "reseller") {
                    $input["domain"] = $service_fields->domain;

                    $action = $row->meta->hostname . "|modifyAccount";
                    $this->log($action, serialize($input), "input", true);

                    $api->editSiteWorxAccount($input);
                } else {
                    $this->Input->setErrors(array('api' => array('result' => Language::_("tastyinterworx.!error.api.package_types", true))));
                }
            }
        }
        return null;
    }

    public function getAdminServiceInfo($service, $package) {
        $row = $this->getModuleRow($package->module_row);

        // Load the view into this object, so helpers can be automatically added to the view
        $this->view = new View("admin_service_info", "default");
        $this->view->base_uri = $this->base_uri;
        $this->view->setDefaultView("components" . DS . "modules" . DS . "tastyinterworxmodule" . DS);

        // Load the helpers required for this view
        Loader::loadHelpers($this, array("Form", "Html"));

        $this->view->set("module_row", $row);
        $this->view->set("package", $package);
        $this->view->set("service", $service);
        $this->view->set("service_fields", $this->serviceFieldsToObject($service->fields));

        return $this->view->fetch();
    }

    public function getClientServiceInfo($service, $package) {
        $row = $this->getModuleRow($package->module_row);

        // Load the view into this object, so helpers can be automatically added to the view
        $this->view = new View("client_service_info", "default");
        $this->view->base_uri = $this->base_uri;
        $this->view->setDefaultView("components" . DS . "modules" . DS . "tastyinterworxmodule" . DS);

        // Load the helpers required for this view
        Loader::loadHelpers($this, array("Form", "Html"));

        $this->view->set("module_row", $row);
        $this->view->set("package", $package);
        $this->view->set("service", $service);
        $this->view->set("service_fields", $this->serviceFieldsToObject($service->fields));

        return $this->view->fetch();
    }

    private function getApi($row_meta) {
        Loader::load(dirname(__FILE__) . DS . "apis" . DS . "bakediw_api.php");

        if (isset($row_meta->use_ssl) && $row_meta->use_ssl == "false") {
            $http = "http";
        } else {
            $http = "https";
        }
        $api = new tastywiApi($row_meta->apikey, $http, $row_meta->hostname, $row_meta->port);

        return $api;
    }

    private function getRowRules(&$vars) {
        $rules = array(
            'hostname' => array(
                'empty' => array(
                    'rule' => "isEmpty",
                    'negate' => true,
                    'message' => Language::_("tastyinterworx.error.row.hostname", true)
                ),
                'valid' => array(
                    'rule' => array(array($this, "hostnameValidator")),
                    'message' => Language::_("tastyinterworx.error.row.hostname", true)
                )
            ),
            'apikey' => array(
                'valid' => array(
                    'rule' => "isEmpty",
                    'negate' => true,
                    'message' => Language::_("tastyinterworx.error.row.apikey", true)
                ),
                'valid_connection' => array(
                    'rule' => array(array($this, "validateConnection"), (object) $vars),
                    'message' => Language::_("tastyinterworx.error.row.apikeyconnection", true)
                )
            ),
            'account_count' => array(
                'empty' => array(
                    'rule' => "isEmpty",
                    'negate' => true,
                    'message' => Language::_("tastyinterworx.error.row.accountlimit", true)
                ),
                'valid' => array(
                    'rule' => array("matches", "/^([0-9]+)?$/"),
                    'message' => Language::_("tastyinterworx.error.row.accountlimit_numeric", true)
                )
            ),
            'name_servers' => array(
                'count' => array(
                    'rule' => array(array($this, "nsCountValidator")),
                    'message' => Language::_("tastyinterworx.!error.name_servers_count", true)
                ),
                'valid' => array(
                    'rule' => array(array($this, "nsValidator")),
                    'message' => Language::_("tastyinterworx.error.row.nameservers", true)
                )
            )
        );

        return $rules;
    }

    private function getPackageRules($vars) {
        $rules = array(
            'meta[package]' => array(
                'valid' => array(
                    'rule' => "isEmpty",
                    'negate' => true,
                    'message' => Language::_("tastyinterworx.error.package.package", true)
                )
            ),
            'meta[type]' => array(
                'valid' => array(
                    'rule' => "isEmpty",
                    'negate' => true,
                    'message' => Language::_("tastyinterworx.error.package.type", true)
                )
            )
        );

        return $rules;
    }

    private function getAccountCount($module_row) {
        $api = $this->getApi($module_row->meta);
        $accounts = false;

        try {
            $action = $module_row->meta->hostname . "|listAccounts";
            $this->log($action, null, "input", true);

            $result = $api->listAccounts();

            if ($result && isset($result['status']) && $result['status'] == "success" && isset($result['payload']))
                $accounts = count($result['payload']);
        } catch (Exception $e) {
            // Nothing to do
        }
        return $accounts;
    }

    private function updateAccountCount($module_row) {
        $api = $this->getApi($module_row->meta);

        // Get the number of accounts on the server
        if (($count = $this->getAccountCount($module_row))) {
            // Update the module row account list
            Loader::loadModels($this, array("ModuleManager"));
            $vars = $this->ModuleManager->getRowMeta($module_row->id);

            if ($vars) {
                $vars->account_count = $count;
                $vars = (array) $vars;

                $this->ModuleManager->editRow($module_row->id, $vars);
            }
        }
    }

    public function hostnameValidator($hostname) {
        if (strlen($hostname) > 255)
            return false;

        return $this->Input->matches($hostname, "/^([a-z0-9]|[a-z0-9][a-z0-9\-]{0,61}[a-z0-9])(\.([a-z0-9]|[a-z0-9][a-z0-9\-]{0,61}[a-z0-9]))+$/");
    }

    public function nsCountValidator($name_servers) {
        if (is_array($name_servers) && count($name_servers) >= 2)
            return true;

        return false;
    }

    public function nsValidator($name_servers) {
        if (is_array($name_servers)) {
            foreach ($name_servers as $name_server) {
                if (!$this->hostnameValidator($name_server))
                    return false;
            }
        }
        return true;
    }

    public function validateConnection($apikey, $vars) {
        $api = $this->getApi($vars);
        $connection = $api->connectTester();
        if ($connection === 0) {
            return TRUE;
        } else {
            return false;
        }
    }

    public function pkggetscripts() {
        $filename = "https://api.softaculous.com/scripts.php?in=serialize";
        $handle = fopen($filename, "r");
        $contents = stream_get_contents($handle);
        fclose($handle);
        $scripts = unserialize($contents);
        $script_select = array();

        foreach ($scripts as $sid => $softw) {
            $script_select[$scripts[$sid]['sid']] = $scripts[$sid]['name'];
        }
        return $script_select;
    }

    private function scriptsavailable($package, $service_fields) {
        $row = $this->getModuleRow($package->module_row);
        $api = $this->getsoftaApi($package, $row->meta->hostname, $service_fields->email, $service_fields->password, $service_fields->domain);

        $result = $api->list_scripts();

        $script_select = "";

        foreach ($result as $key => $value) {
            $script_select .= "<option value='{$result[$key]['sid']}'>{$result[$key]['name']} - Type: {$result[$key]['type']}</option>";
        }

        return $script_select;
    }

    private function getsoftaApi($package, $host, $user, $pass, $domain) {
        $https = "";
        $row = $this->getModuleRow($package->module_row);
        Loader::load(dirname(__FILE__) . DS . "apis" . DS . "bakedsofta_api.php");
        $loginparams = array(
            "email" => $user,
            "password" => $pass,
            "domain" => $domain
        );
        if ($row->meta->use_ssl == "false") {
            $https = "http";
        } else {
            $https = "https";
        }

        $api = new bakedSoftaAPI($loginparams, $https, $host, $row->meta->port);

        return $api;
    }

    public function getDomains($vars, $service_fields) {
        $api = $this->getApi($vars);
        $listsecondary = $api->listAddonDomains($service_fields->email, $service_fields->password, $service_fields->domain);
        $select_option = "<option value='{$service_fields->domain}'>{$service_fields->domain}</option>";
        foreach ($listsecondary as $key => $value) {
            $select_option .= "<option value='{$listsecondary[$key]['domain']}'>{$listsecondary[$key]['domain']}</option>";
        }
        return $select_option;
    }

    private function cronSelectValues($select_name) {
        if ($select_name === "min") {
            return array(
                "*" => " Every Minute (*) ",
                "*/2" => "Every other minute(*/2)",
                "*/5" => "Every 5 minutes(*/5)",
                "*/10" => "Every 10 minutes(*/10)",
                "*/15" => "Every 15 minutes(*/15)",
                "0" => ":00 (0)",
                "1" => ":01 (1)",
                "2" => ":02 (2)",
                "3" => ":03 (3)",
                "4" => ":04 (4)",
                "5" => ":05 (5)",
                "6" => ":06 (6)",
                "7" => ":07 (7)",
                "8" => ":08 (8)",
                "9" => ":09 (9)",
                "10" => ":10 (10)",
                "11" => ":11 (11)",
                "12" => ":12 (12)",
                "13" => ":13 (13)",
                "14" => ":14 (14)",
                "15" => ":15 (15)",
                "16" => ":16 (16)",
                "17" => ":17 (17)",
                "18" => ":18 (18)",
                "19" => ":19 (19)",
                "20" => ":20 (20)",
                "21" => ":21 (21)",
                "22" => ":22 (22)",
                "23" => ":23 (23)",
                "24" => ":24 (24)",
                "25" => ":25 (25)",
                "26" => ":26 (26)",
                "27" => ":27 (27)",
                "28" => ":28 (28)",
                "29" => ":29 (29)",
                "30" => ":30 (30)",
                "31" => ":31 (31)",
                "32" => ":32 (32)",
                "33" => ":33 (33)",
                "34" => ":34 (34)",
                "35" => ":35 (35)",
                "36" => ":36 (36)",
                "37" => ":37 (37)",
                "38" => ":38 (38)",
                "39" => ":39 (39)",
                "40" => ":40 (40)",
                "41" => ":41 (41)",
                "42" => ":42 (42)",
                "43" => ":43 (43)",
                "44" => ":44 (44)",
                "45" => ":45 (45)",
                "46" => ":46 (46)",
                "47" => ":47 (47)",
                "48" => ":48 (48)",
                "49" => ":49 (49)",
                "50" => ":50 (50)",
                "51" => ":51 (51)",
                "52" => ":52 (52)",
                "53" => ":53 (53)",
                "54" => ":54 (54)",
                "55" => ":55 (55)",
                "56" => ":56 (56)",
                "57" => ":57 (57)",
                "58" => ":58 (58)",
                "59" => ":59 (59)"
            );
        } else if ($select_name === "hour") {
            return array(
                "*" => " Every Hour (*) ",
                "*/2" => "Every other hour (*/2)",
                "*/4" => "Every 4 hours (*/4)",
                "*/6" => "Every 6 hours (*/6)",
                "0" => "12:00 a.m. midnight (0)",
                "1" => "1:00 a.m. (1)",
                "2" => "2:00 a.m. (2)",
                "3" => "3:00 a.m. (3)",
                "4" => "4:00 a.m. (4)",
                "5" => "5:00 a.m. (5)",
                "6" => "6:00 a.m. (6)",
                "7" => "7:00 a.m. (7)",
                "8" => "8:00 a.m. (8)",
                "9" => "9:00 a.m. (9)",
                "10" => "10:00 a.m. (10)",
                "11" => "11:00 a.m. (11)",
                "12" => "12:00 p.m. (12)",
                "13" => "1:00 p.m. (13)",
                "14" => "2:00 p.m. (14)",
                "15" => "3:00 p.m. (15)",
                "16" => "4:00 p.m. (16)",
                "17" => "5:00 p.m. (17)",
                "18" => "6:00 p.m. (18)",
                "19" => "7:00 p.m. (19)",
                "20" => "8:00 p.m. (20)",
                "21" => "9:00 p.m. (21)",
                "22" => "10:00 p.m. (22)",
                "23" => "11:00 p.m. (23)"
            );
        } else if ($select_name === "day") {
            return array(
                "*" => " Every day (*) ",
                "1" => " 1st (1) ",
                "2" => " 2nd (2) ",
                "3" => " 3rd (3) ",
                "4" => " 4th (4) ",
                "5" => " 5th (5) ",
                "6" => " 6th (6) ",
                "7" => " 7th (7) ",
                "8" => " 8th (8) ",
                "9" => " 9th (9) ",
                "10" => " 10th (10) ",
                "11" => " 11th (11) ",
                "12" => " 12th (12) ",
                "13" => " 13th (13) ",
                "14" => " 14th (14) ",
                "15" => " 15th (15) ",
                "16" => " 16th (16) ",
                "17" => " 17th (17) ",
                "18" => " 18th (18) ",
                "19" => " 19th (19) ",
                "20" => " 20th (20) ",
                "21" => " 21st (21) ",
                "22" => " 22nd (22) ",
                "23" => " 23rd (23) ",
                "24" => " 24th (24) ",
                "25" => " 25th (25) ",
                "26" => " 26th (26) ",
                "27" => " 27th (27) ",
                "28" => " 28th (28) ",
                "29" => " 29th (29) ",
                "30" => " 30th (30) ",
                "31" => " 31st (31) "
            );
        } else if ($select_name === "month") {
            return array(
                "*" => " All ",
                "1" => " January (1) ",
                "2" => " February (2) ",
                "3" => " March (3) ",
                "4" => " April (4) ",
                "5" => " May (5) ",
                "6" => " June (6) ",
                "7" => " July (7) ",
                "8" => " August (8) ",
                "9" => " September (9) ",
                "10" => " October (10) ",
                "11" => " November (11) ",
                "12" => " December (12) "
            );
        } else if ($select_name === "weekday") {
            return array(
                "*" => " All ",
                "0" => " Sunday (0) ",
                "1" => " Monday (1) ",
                "2" => " Tuesday (2) ",
                "3" => " Wednesday (3) ",
                "4" => " Thursday (4) ",
                "5" => " Friday (5) ",
                "6" => " Saturday (6) "
            );
        }
    }

}
