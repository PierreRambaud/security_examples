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
     * http://ps-develop.localhost/admin-dev/index.php/modules/security-examples/xss?date-from=2018-10-08&date-to=2019-05-28%3Cscript%3Ealert(true);%3C/script%3E
     */
    public function indexAction(Request $request)
    {
        $orders = [];
        $dateFrom = $request->query->get('date-from');
        $dateTo = $request->query->get('date-to');
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
