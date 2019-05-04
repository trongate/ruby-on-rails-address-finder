<?php
trait Finder
{
    protected $target_module;

    function module($module) {
        require_once APPPATH.'modules/'.$module.'/controllers/'.ucfirst($module).'.php';
        $target_module = $module;
        $this->$target_module = new $target_module;
    }
}