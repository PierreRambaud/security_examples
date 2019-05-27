<?php

namespace SecurityExamples\Controller;

use Symfony\Component\Finder\Finder;
use PrestaShopBundle\Controller\Admin\FrameworkBundleAdminController;
use Symfony\Component\HttpFoundation\Request;

class LfiController extends FrameworkBundleAdminController
{
    public function indexAction(Request $request)
    {
        $finder = new Finder();
        $finder->files()->in(
            $this->getDirectoryPath()
        );

        return $this->render(
            '@Modules/security_examples/templates/admin/lfi.html.twig',
            ['finder' => $finder],
        );
    }

    public function downloadAction(Request $request)
    {
        // Exploit http://ps-develop.localhost/admin-dev/index.php/modules/security-examples/lfi/download?file=../config/defines.inc.php
        $filename = $request->query->get('file');
        return $this->file(
            $this->getDirectoryPath() .
            $filename
        );
    }


    private function getDirectorypath()
    {
        return sprintf(
            '%s/../docs/csv_import/',
            $this->getParameter('kernel.root_dir')
        );
    }
}
