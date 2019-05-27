<?php

namespace SecurityExamples\Controller;

use PrestaShopBundle\Controller\Admin\FrameworkBundleAdminController;

class XssController extends FrameworkBundleAdminController
{
    public function indexAction()
    {
        return $this->render('@Modules/security_examples/templates/admin/xss.html.twig');
    }
}
