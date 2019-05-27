<?php

namespace SecurityExamples\Controller;

use Db;
use PrestaShopBundle\Controller\Admin\FrameworkBundleAdminController;
use PrestaShopDatabaseException;
use Symfony\Component\HttpFoundation\Request;

class SQLiController extends FrameworkBundleAdminController
{
    public function indexAction(Request $request)
    {
        if ($request->isMethod('POST')) {
            // Blind SQL example:
            // 1 AND (SELECT LENGTH(database()))=10
            try {
                $customer = Db::getInstance()->executeS(
                    'SELECT * FROM ' . _DB_PREFIX_ . 'customer WHERE id_customer = ' . $request->request->get('customer_id')
                );
            } catch (PrestaShopDatabaseException $e) {
                // Don't care, we are awesome
            }
        }

        return $this->render(
            '@Modules/security_examples/templates/admin/sqli.html.twig',
            [
                'customer' => !empty($customer[0]) ? $customer[0] : null,
            ],
        );
    }
}
