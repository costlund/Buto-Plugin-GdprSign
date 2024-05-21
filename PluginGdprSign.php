<?php
class PluginGdprSign{
  public $settings;
  public $mysql;
  function __construct($buto) {
    if($buto){
      wfPlugin::includeonce('wf/yml');
      wfPlugin::includeonce('wf/mysql');
      $this->mysql =new PluginWfMysql();
      $this->settings = wfPlugin::getPluginSettings('gdpr/sign', true);
    }
  }
  public function widget_sign($data){
    $element = wfDocument::getElementFromFolder(__DIR__, __FUNCTION__);
    wfDocument::renderElement($element);
  }
  public function page_sign_capture(){
    $this->db_account_gdpr_insert();
    $this->event_signin();
    wfDocument::renderElementFromFolder(__DIR__, __FUNCTION__);
  }
  public function event_signin(){
    $rs = $this->db_account_gdpr_select_one();
    wfUser::setSession('plugin/gdpr/sign/user/version', $rs->get('version'));
    wfUser::setSession('plugin/gdpr/sign/user/last_version', $this->last_version());
    wfUser::setSession('plugin/gdpr/sign/user/new_version', false);
    if($this->last_version() && $rs->get('version') != $this->last_version()){
      wfUser::setSession('plugin/gdpr/sign/user/new_version', true);
    }
    return null;
  }
  public function page_approvals(){
    wfPlugin::enable('wf/table');
    wfDocument::renderElementFromFolder(__DIR__, __FUNCTION__);
  }
  public function page_approvals_data(){
    $rs = $this->db_account_gdpr_select_many();
    wfPlugin::includeonce('datatable/datatable_1_10_18');
    $datatable = new PluginDatatableDatatable_1_10_18();
    exit($datatable->set_table_data($rs));
  }
  public function db_open(){
    $this->mysql->open($this->settings->get('data/mysql'));
  }
  public function getSql($key){
    return new PluginWfYml(__DIR__.'/mysql/sql.yml', $key);
  }
  private function db_account_gdpr_select_one(){
    $this->db_open();
    $sql = $this->getSql(__FUNCTION__);
    $this->mysql->execute($sql->get());
    return $this->mysql->getOne(array('sql' => $sql->get()));
  }
  private function db_account_gdpr_insert(){
    $this->db_open();
    $sql = $this->getSql(__FUNCTION__);
    $this->mysql->execute($sql->get());
    return null;
  }
  private function db_account_gdpr_select_many(){
    $this->db_open();
    $sql = $this->getSql(__FUNCTION__);
    $this->mysql->execute($sql->get());
    $rs = $this->mysql->getMany();
    $theme = wfGlobals::get('theme');
    foreach($rs as $k => $v){
      $rs[$k]['link'] = '<a href="#" onclick="window.open(\'/theme/'.$theme.'/gdpr/'.$v['version'].'.pdf\')">'.$v['version'].'</a>';
    }
    return $rs;
  }
  private function last_version(){
    /**
     * files
     */
    $files =  wfFilesystem::getScandir(wfGlobals::getWebDir().'/theme/[theme]/gdpr', array('.pdf'));
    /**
     * Add version number as array keys.
     */
    $temp = array();
    foreach($files as $k => $v){
      $temp[str_replace('.pdf', '', $v)] = $v;
    }
    /**
     * Sort latest version first.
     */
    krsort($temp);
    /**
     * 
     */
    $files = $temp;
    /**
     * version
     */
    $version = null;
    if(sizeof($files)){
      foreach($files as $k => $v){
        // $version = $v;
        // $version = str_replace('.pdf', '', $version);
        $version = $k;
        break;
      }
    }
    /**
     * 
     */
    return $version;
  }
}