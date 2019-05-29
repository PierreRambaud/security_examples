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
        $customer_id = $request->request->get('customer_id', null);
        if ($request->isMethod('POST') && !empty($customer_id)) {
            // Blind SQL example:
            // 1 AND (SELECT LENGTH(database()))=10
            try {
                $customer = Db::getInstance()->executeS(
                    'SELECT * FROM ' . _DB_PREFIX_ . 'customer WHERE id_customer = ' . $customer_id
                );
                // Fix, use cast
                // $customer = Db::getInstance()->executeS(
                //     'SELECT * FROM ' . _DB_PREFIX_ . 'customer WHERE id_customer = ' . $customer_id
                // );
            } catch (PrestaShopDatabaseException $e) {
                // Don't care, we are awesome
            }
        }

        return $this->render(
            '@Modules/security_examples/templates/admin/sqli.html.twig',
            [
                'customer' => !empty($customer[0]) ? $customer[0] : null,
                'customer_id' => $customer_id,
            ]
        );
    }
}
