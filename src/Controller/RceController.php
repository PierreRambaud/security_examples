<?php

namespace SecurityExamples\Controller;

use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;
use PrestaShopBundle\Controller\Admin\FrameworkBundleAdminController;
use Symfony\Component\HttpFoundation\Request;

class RceController extends FrameworkBundleAdminController
{
    // exploit http://ps-develop.localhost/admin-dev/index.php/modules/security-examples/rce/command?type=router;whoami
    public function indexAction(Request $request)
    {
        $output = null;
        $type = $request->query->get('type');
        if (!empty($type)) {
            $process = new Process(
                sprintf(
                    '%s %s/../bin/console debug:%s',
                    PHP_BINARY,
                    $this->getParameter('kernel.root_dir'),
                    $type
                )
            );
            $process->run();
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
