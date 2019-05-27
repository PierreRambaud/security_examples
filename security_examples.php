<?php

class security_examples extends Module
{
    public function __construct()
    {
        $this->name = 'security_examples';
        $this->version = '1.0.0';
        $this->author = 'PrestaShop';
        $this->need_instance = 0;
        $this->bootstrap = true;

        parent::__construct();
    }

    public function install()
    {
        // Lets you want to create a parent tab. Then call the installTab() like below example-
        $this->installTab('AdminSecurityExamples', 'Security Examples');

        // Lets you want to create a child tab under 'Shipping' Tab. As we know Shipping Tab's class name is 'AdminParentShipping'
        $this->installTab('AdminSecurityExamplesXss', 'Xss', 'AdminSecurityExamples');
        $this->installTab('AdminSecurityExamplesRce', 'Rce', 'AdminSecurityExamples');
        $this->installTab('AdminSecurityExamplesLfi', 'Lfi', 'AdminSecurityExamples');
        $this->installTab('AdminSecurityExamplesSqli', 'SQLi', 'AdminSecurityExamples');

        return parent::install();
    }

    public function installTab($yourControllerClassName, $yourTabName, $tabParentControllerName = false)
    {
        $tab = new Tab();
        $tab->active = 1;
        $tab->class_name = $yourControllerClassName;
        $tab->name = array();

        foreach (Language::getLanguages(true) as $lang) {
            $tab->name[$lang['id_lang']] = $yourTabName;
        }

        $tab->id_parent = $tabParentControllerName ? (int) Tab::getIdFromClassName($tabParentControllerName) : 0;

        $tab->module = $this->name;
        $tab->add();
    }


    /**
     * uninstall()
     *
     * @param none
     * @return bool
     */
    public function uninstall()
    {
        // unregister hook
        if (!parent::uninstall()) {
            $this->_errors[] = $this->l('There was an error during the desinstallation.');
            return false;
        }

        $tabs = [
            'AdminSecurityExamples',
            'AdminSecurityExamplesSQLi',
            'AdminSecurityExamplesRce',
            'AdminSecurityExamplesLfi',
            'AdminSecurityExamplesXss',
        ];
        foreach ($tabs as $tabName) {
            $idTab = Tab::getIdFromClassName($tabName);
            if ($idTab !== false) {
                $tab = new Tab($idTab);
                $tab->active = true;
                $tab->save();
            }
        }

        return true;
    }
}
