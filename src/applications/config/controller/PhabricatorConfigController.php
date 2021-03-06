<?php

abstract class PhabricatorConfigController extends PhabricatorController {

  public function shouldRequireAdmin() {
    return true;
  }

  public function buildSideNavView($filter = null, $for_app = false) {
    $user = $this->getRequest()->getUser();

    $nav = new AphrontSideNavFilterView();
    $nav->setBaseURI(new PhutilURI($this->getApplicationURI()));
    $nav->addLabel(pht('Configuration'));
    $nav->addFilter('/', pht('Core Settings'));
    $nav->addFilter('application/', pht('Application Settings'));
    $nav->addFilter('history/', pht('Settings History'));
    $nav->addFilter('version/', pht('Version Information'));
    $nav->addFilter('all/', pht('All Settings'));
    $nav->addLabel(pht('Setup'));
    $nav->addFilter('issue/', pht('Setup Issues'));
    $nav->addFilter('welcome/', pht('Installation Guide'));
    $nav->addLabel(pht('Database'));
    $nav->addFilter('database/', pht('Database Status'));
    $nav->addFilter('dbissue/', pht('Database Issues'));
    $nav->addLabel(pht('Cache'));
    $nav->addFilter('cache/', pht('Cache Status'));
    $nav->addLabel(pht('Cluster'));
    $nav->addFilter('cluster/databases/', pht('Database Servers'));
    $nav->addFilter('cluster/notifications/', pht('Notification Servers'));
    $nav->addFilter('cluster/repositories/', pht('Repository Servers'));
    $nav->addLabel(pht('Modules'));

    $modules = PhabricatorConfigModule::getAllModules();
    foreach ($modules as $key => $module) {
      $nav->addFilter('module/'.$key.'/', $module->getModuleName());
    }

    return $nav;
  }

  public function buildApplicationMenu() {
    return $this->buildSideNavView(null, true)->getMenu();
  }

}
