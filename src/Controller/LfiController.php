<?php

namespace SecurityExamples\Controller;

use Exception;
use SplFileInfo;
use Symfony\Component\Finder\Finder;
use PrestaShopBundle\Controller\Admin\FrameworkBundleAdminController;
use Symfony\Component\HttpFoundation\Request;

class LfiController extends FrameworkBundleAdminController
{
    public function indexAction(Request $request)
    {
        return $this->render(
            '@Modules/security_examples/templates/admin/lfi.html.twig',
            ['finder' => $this->getFiles()]
        );
    }

    public function downloadAction(Request $request)
    {
        $filename = $request->query->get('file');

        // Check if file exist in the selected directory
        // $finder = $this->getFiles();
        // $finder->filter(
        //     function (SplFileInfo $file) use ($filename) {
        //         if ($file->getRelativePathName() !== $filename) {
        //             return false;
        //         }
        //     }
        // );

        // $files = iterator_to_array($finder);
        // if (empty($files)) {
        //     throw new Exception('File not found');
        // }

        // return $this->file(
        //     $this->getDirectoryPath() .
        //     array_pop($files)
        // );


        return $this->file(
            $this->getDirectoryPath() .
            $filename
        );
    }

    private function getFiles()
    {
        $finder = new Finder();
        $finder->files()->in(
            $this->getDirectoryPath()
        );

        return $finder;
    }

    private function getDirectorypath()
    {
        return sprintf(
            '%s/../docs/csv_import/',
            $this->getParameter('kernel.root_dir')
        );
    }
}
