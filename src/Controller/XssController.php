<?php

namespace SecurityExamples\Controller;

use PrestaShopBundle\Controller\Admin\FrameworkBundleAdminController;
use Symfony\Component\HttpFoundation\Request;

class XssController extends FrameworkBundleAdminController
{
    public function indexAction(Request $request)
    {
        return $this->render('@Modules/security_examples/templates/admin/xss.html.twig');
    }
}
