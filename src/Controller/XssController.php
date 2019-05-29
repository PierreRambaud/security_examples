<?php

namespace SecurityExamples\Controller;

use Db;
use PrestaShopBundle\Controller\Admin\FrameworkBundleAdminController;
use PrestaShopDatabaseException;
use Symfony\Component\HttpFoundation\Request;

class XssController extends FrameworkBundleAdminController
{
    /**
     * Don't forget to disable xss protection
     *
     * Header set X-XSS-Protection 0
     */
    public function indexAction(Request $request)
    {
        $orders = [];
        $dateFrom = $request->query->get('date-from');
        $dateTo = $request->query->get('date-to');

        // Always care about user data
        // $dateFrom = date('Y-m-d', strtotime($request->query->get('date-from')));
        // $dateTo = date('Y-m-d', strtotime($request->query->get('date-to')));

        if (!empty($dateFrom) && !empty($dateTo)) {
            try {
                $orders = Db::getInstance()->executeS(
                    'SELECT * FROM ' . _DB_PREFIX_ . 'orders WHERE ' .
                    'date_add BETWEEN "' . pSQL($dateFrom) . '" AND "' .
                    pSQL($dateTo) . '"'
                );
            } catch (PrestaShopDatabaseException $e) {
                // Don't care, we are awesome
            }
        }

        return $this->render(
            '@Modules/security_examples/templates/admin/xss.html.twig',
            [
                'orders' => $orders,
                'dateFrom' => $dateFrom,
                'dateTo' => $dateTo,
            ]
        );
    }
}
