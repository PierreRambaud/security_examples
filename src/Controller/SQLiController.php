<?php

namespace SecurityExamples\Controller;

use PrestaShopBundle\Controller\Admin\FrameworkBundleAdminController;

class SQLiController extends FrameworkBundleAdminController
{
    public function indexAction()
    {
        return $this->render('@Modules/security_examples/templates/admin/sqli.html.twig');
    }
}
