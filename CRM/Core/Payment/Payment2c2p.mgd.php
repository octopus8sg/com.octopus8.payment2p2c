<?php
// This file declares a managed database record of type "ReportTemplate".
// The record will be automatically inserted, updated, or deleted from the
// database as appropriate. For more details, see "hook_civicrm_managed" at:
// http://wiki.civicrm.org/confluence/display/CRMDOC42/Hook+Reference
use CRM_Payment2c2p_ExtensionUtil as E;

return [
    0 => [
        'name' => 'Payment2c2p',
        'entity' => 'PaymentProcessorType',
        'params' => [
            'version' => 3,
            'name' => 'Payment2c2p',
            'title' => E::ts('Payment2c2p'),
            'description' => '',
            'user_name_label' => 'Merchant ID',
            'password_label' => 'Password',
            'subject_label' => 'Thank You Page',
            'signature_label' => 'Failure Page',
            'class_name' => 'Payment_Payment2c2p',
            'billing_mode' => 4,
            'payment_type' => 1,
            'is_recur' => 0,
            'url_site_test_default' => 'https://sandbox-pgw.2c2p.com',
            'url_site_default' => 'https://pgw.2c2p.com',
            'url_api_test_default' => 'https://demo2.2c2p.com/2C2PFrontend/PaymentAction/2.0/action',
            'url_api_default' => 'https://t.2c2p.com/PaymentAction/2.0/action',
        ],
    ],
];
