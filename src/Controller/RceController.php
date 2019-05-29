<?php

namespace SecurityExamples\Controller;

use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;
use PrestaShopBundle\Controller\Admin\FrameworkBundleAdminController;
use Symfony\Component\HttpFoundation\Request;

class RceController extends FrameworkBundleAdminController
{
    public function indexAction(Request $request)
    {
        $output = null;
        $type = $request->query->get('type');
        if (!empty($type)) {
            $process = new Process(
                sprintf(
                    '%s/../bin/console debug:%s',
                    $this->getParameter('kernel.root_dir'),
                    $type
                )
            );
            $process->run();

            // Use automatic escape from process, or something like escapeshellarg
            // $process = new Process(
            //     [
            //         $this->getParameter('kernel.root_dir') . '/../bin/console',
            //         'debug:' . $type
            //     ]
            // );
            // $process->run();

            if (!$process->isSuccessful()) {
                throw new ProcessFailedException($process);
            }
            $output = $process->getOutput();
        }

        return $this->render(
            '@Modules/security_examples/templates/admin/rce.html.twig',
            ['output' => $output]
        );
    }
}
