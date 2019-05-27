<?php

namespace SecurityExamples\Controller;

use PrestaShopBundle\Controller\Admin\FrameworkBundleAdminController;

class RceController extends FrameworkBundleAdminController
{
    public function indexAction()
    {
        return $this->render('@Modules/security_examples/templates/admin/rce.html.twig');
    }
}
