<?php

namespace SecurityExamples\Controller;

use PrestaShopBundle\Controller\Admin\FrameworkBundleAdminController;

class LfiController extends FrameworkBundleAdminController
{
    public function indexAction()
    {
        return $this->render('@Modules/security_examples/templates/admin/lfi.html.twig');
    }
}
