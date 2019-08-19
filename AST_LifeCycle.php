<?php
include_once('AST_InstallIndicator.php');
class AST_LifeCycle extends AST_InstallIndicator
  {
    public function install()
      {
        $this->initOptions();
        $this->installDatabaseTables();
        $this->otherInstall();
        $this->saveInstalledVersion();
        $this->markAsInstalled();
      }
    public function uninstall()
      {
        $this->otherUninstall();
        $this->unInstallDatabaseTables();
        $this->deleteSavedOptions();
        $this->markAsUnInstalled();
      }
    public function upgrade()
      {
      }
    public function activate()
      {
      }
    public function deactivate()
      {
      }
    protected function initOptions()
      {
      }
    public function addActionsAndFilters()
      {
      }
    protected function installDatabaseTables()
      {
      }
    protected function unInstallDatabaseTables()
      {
      }
    protected function otherInstall()
      {
      }
    protected function otherUninstall()
      {
      }
    public function addSettingsSubMenuPage()
      {
        $this->addSettingsSubMenuPageToPluginsMenu();
      }
    protected function requireExtraPluginFiles()
      {
        require_once(ABSPATH . 'wp-includes/pluggable.php');
        require_once(ABSPATH . 'wp-admin/includes/plugin.php');
      }
    protected function getSettingsSlug()
      {
        return get_class($this) . 'Settings';
      }
    protected function addSettingsSubMenuPageToPluginsMenu()
      {
        $this->requireExtraPluginFiles();
        $displayName = $this->getPluginDisplayName();
        add_submenu_page('plugins.php', $displayName, $displayName, 'manage_options', $this->getSettingsSlug(), array(
            &$this,
            'settingsPage'
        ));
      }
    protected function addSettingsSubMenuPageToSettingsMenu()
      {
        $this->requireExtraPluginFiles();
        $displayName = $this->getPluginDisplayName();
        add_options_page($displayName, $displayName, 'manage_options', $this->getSettingsSlug(), array(
            &$this,
            'settingsPage'
        ));
      }
    protected function prefixTableName($name)
      {
        global $wpdb;
        return $wpdb->prefix . strtolower($this->prefix($name));
      }
    public function getAjaxUrl($actionName)
      {
        return admin_url('admin-ajax.php') . '?action=' . $actionName;
      }
  }