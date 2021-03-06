<?php

require_once 'payment2c2p.civix.php';

// phpcs:disable
use CRM_Payment2c2p_ExtensionUtil as E;

// phpcs:enable

/**
 * Implements hook_civicrm_config().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_config/
 */
function payment2c2p_civicrm_config(&$config)
{
    _payment2c2p_civix_civicrm_config($config);
}

/**
 * Implements hook_civicrm_xmlMenu().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_xmlMenu
 */
function payment2c2p_civicrm_xmlMenu(&$files)
{
    _payment2c2p_civix_civicrm_xmlMenu($files);
}

/**
 * Implements hook_civicrm_install().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_install
 */
function payment2c2p_civicrm_install()
{
    _payment2c2p_civix_civicrm_install();
}

/**
 * Implements hook_civicrm_postInstall().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_postInstall
 */
function payment2c2p_civicrm_postInstall()
{
    _payment2c2p_civix_civicrm_postInstall();
}

/**
 * Implements hook_civicrm_uninstall().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_uninstall
 */
function payment2c2p_civicrm_uninstall()
{
    _payment2c2p_civix_civicrm_uninstall();
}

/**
 * Implements hook_civicrm_enable().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_enable
 */
function payment2c2p_civicrm_enable()
{
    _payment2c2p_civix_civicrm_enable();
}

/**
 * Implements hook_civicrm_disable().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_disable
 */
function payment2c2p_civicrm_disable()
{
    _payment2c2p_civix_civicrm_disable();
}

/**
 * Implements hook_civicrm_upgrade().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_upgrade
 */
function payment2c2p_civicrm_upgrade($op, CRM_Queue_Queue $queue = NULL)
{
    return _payment2c2p_civix_civicrm_upgrade($op, $queue);
}

/**
 * Implements hook_civicrm_managed().
 *
 * Generate a list of entities to create/deactivate/delete when this module
 * is installed, disabled, uninstalled.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_managed
 */
//function payment2c2p_civicrm_managed(&$entities)
//{
//    _payment2c2p_civix_civicrm_managed($entities);
//}

/**
 * Implements hook_civicrm_caseTypes().
 *
 * Add CiviCase types provided by this extension.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_caseTypes
 */
function payment2c2p_civicrm_caseTypes(&$caseTypes)
{
    _payment2c2p_civix_civicrm_caseTypes($caseTypes);
}

/**
 * Implements hook_civicrm_angularModules().
 *
 * Add Angular modules provided by this extension.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_angularModules
 */
function payment2c2p_civicrm_angularModules(&$angularModules)
{
    // Auto-add module files from ./ang/*.ang.php
    _payment2c2p_civix_civicrm_angularModules($angularModules);
}


//CRM_Contribute_Form_ContributionView
/**
 * @param $formName
 * @param $form CRM_Core_Form
 */
function payment2c2p_civicrm_buildForm($formName, &$form)
{
    if ($formName == 'CRM_Contribute_Form_ContributionView') {
//                CRM_Core_Error::debug_var('form', $form);
        $isHasAccess = FALSE;
        $action = 'update';
        $id = $form->get('id');
        try {
            $isHasAccess = Civi\Api4\Contribution::checkAccess()
                ->setAction($action)
                ->addValue('id', $id)
                ->execute()->first()['access'];
        } catch (API_Exception $e) {
            $isHasAccess = FALSE;
        }
        if ($isHasAccess) {

            $contribution = Civi\Api4\Contribution::get(TRUE)
                ->addWhere('id', '=', $id)->addSelect('*')->execute()->first();
            if (empty($contribution)) {
                CRM_Core_Error::statusBounce(ts('Access to contribution not permitted'));
            }
            // We just cast here because it was traditionally an array called values - would be better
            // just to use 'contribution'.
            $values = (array)$contribution;
            $invoiceId = $values['invoice_id'];
//            $contributionStatus = CRM_Core_PseudoConstant::getName('CRM_Contribute_BAO_Contribution', 'contribution_status_id', $values['contribution_status_id']);
//            if ($contributionStatus == 'Pending') {
//                CRM_Core_Error::debug_var('values', $values);
//                CRM_Core_Error::debug_var('contributionStatus', $contributionStatus);
            if (isset($form->get_template_vars()['linkButtons'])) {
                $linkButtons = $form->get_template_vars()['linkButtons'];
                $urlParams = "reset=1&invoiceId={$invoiceId}";
                $linkButtons[] = [
                    'title' => ts('Update Status from 2c2p'),
//                'name' => ts('Update Status from 2c2p'),
                    'url' => 'civicrm/payment2c2p/checkpending',
                    'qs' => $urlParams,
                    'icon' => 'fa-pencil',
                    'accessKey' => 'u',
                    'ref' => '',
                    'name' => '',
                    'extra' => '',
                ];
                $form->assign('linkButtons', $linkButtons ?? []);
            }
        }
    }
//    }
}


/**
 * Implements hook_civicrm_alterSettingsFolders().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_alterSettingsFolders
 */
function payment2c2p_civicrm_alterSettingsFolders(&$metaDataFolders = NULL)
{
    _payment2c2p_civix_civicrm_alterSettingsFolders($metaDataFolders);
}

/**
 * Implements hook_civicrm_entityTypes().
 *
 * Declare entity types provided by this module.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_entityTypes
 */
function payment2c2p_civicrm_entityTypes(&$entityTypes)
{
    _payment2c2p_civix_civicrm_entityTypes($entityTypes);
}

/**
 * Implements hook_civicrm_themes().
 */
function payment2c2p_civicrm_themes(&$themes)
{
    _payment2c2p_civix_civicrm_themes($themes);
}

// --- Functions below this ship commented out. Uncomment as required. ---

/**
 * Implements hook_civicrm_preProcess().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_preProcess
 */
//function payment2c2p_civicrm_preProcess($formName, &$form) {
//
//}

/**
 * Implements hook_civicrm_navigationMenu()
 *
 * @param array $menu
 * @return void
 */
function payment2c2p_civicrm_navigationMenu(&$menu)
{
//    _payment2c2p_civix_insert_navigation_menu($menu, 'Administer/CiviContribute', [
//        'label' => E::ts('2c2p Settings'),
//        'name' => '2c2p_settings',
//        'url' => 'civicrm/payment2c2p/settings',
//        'permission' => 'administer CiviCRM',
//        'operator' => 'OR',
//        'has_separator' => 1,
//        'is_active' => 1,
//    ]);
//    _payment2c2p_civix_navigationMenu($menu);
}

/**
 * Implements hook_civicrm_preProcess().
 *
 * This enacts the following
 * - find and cancel any related payments
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_post
 *
 * @throws \CiviCRM_API3_Exception
 * @throws \API_Exception
 * @throws CRM_Core_Exception
 */
function payment2c2p_civicrm_post($op, $objectName, $objectId, $objectRef)
{
//    CRM_Core_Error::debug_var('started_civicrm_post', date("Y-m-d H:i:s"));
//    CRM_Core_Error::debug_var('op', $op);
//    CRM_Core_Error::debug_var('objectName', $objectName);
    if ($op === 'edit' && $objectName === 'Contribution') {
        if (in_array(CRM_Core_PseudoConstant::getName('CRM_Contribute_BAO_Contribution',
            'contribution_status_id',
            $objectRef->contribution_status_id),
            ['Cancelled', 'Failed']
        )) {
//            CRM_Core_Error::debug_var('objectName', $objectName);
//            CRM_Core_Error::debug_var('objectId', $objectId);
//            CRM_Core_Error::debug_var('objectRef', $objectRef);
            payment2c2p_cancel_related_2c2p_record((int)$objectId);
            return TRUE;
        }
    } elseif ($op = 'create') {
//        CRM_Core_Error::debug_var('objectName', $objectName);
//        CRM_Core_Error::debug_var('objectId', $objectId);
//        CRM_Core_Error::debug_var('objectRef', $objectRef);
//        CRM_Core_Error::debug_var('ended_create_civicrm_post', date("Y-m-d H:i:s"));
        return TRUE;
    } else {
//        CRM_Core_Error::debug_var('objectName', $objectName);
//        CRM_Core_Error::debug_var('objectId', $objectId);
//        CRM_Core_Error::debug_var('objectRef', $objectRef);
//        CRM_Core_Error::debug_var('ended_something_else', date("Y-m-d H:i:s"));
        return TRUE;

    }
    CRM_Core_Error::debug_var('ended_civicrm_post', date("Y-m-d H:i:s"));
    return TRUE;

}


/**
 * @param $objectId
 * @return bool
 * @throws CRM_Core_Exception
 * @throws CiviCRM_API3_Exception
 */
function payment2c2p_cancel_related_2c2p_record($objectId)
{
    CRM_Core_Error::debug_var('started_canceling_related', date("Y-m-d H:i:s"));
    CRM_Core_Payment_Payment2c2p::setCancelledContributionStatus($objectId);
    CRM_Core_Error::debug_var('ended_canceling_related', date("Y-m-d H:i:s"));
    return TRUE;
}

/**
 * Implements hook_civicrm_managed().
 *
 * Generate a list of entities to create/deactivate/delete when this module
 * is installed, disabled, uninstalled.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_managed
 */
function payment2c2p_civicrm_managed(&$entities) {
    $entities[] = [
        'module' => 'com.octopus8.payment2c2p',
        'name' => 'Payment2c2p_Recurring_cron',
        'entity' => 'Job',
        'update' => 'always',
        // Ensure local changes are kept, eg. setting the job active
        'params' => [
            'version' => 3,
            'run_frequency' => 'Always',
            'name' => 'Payment2c2p Recurring Payments',
            'description' => 'Process pending and scheduled payments in the Payment2c2p processor',
            'api_entity' => 'Job',
            'api_action' => 'run_payment_cron',
            'parameters' => "processor_name=Payment2c2p",
            'is_active' => '1',
        ],
    ];
    $entities[] = [
        'module' => 'com.octopus8.payment2c2p',
        'name' => 'Payment2c2p_Failed_Transaction_ActivityType',
        'entity' => 'OptionValue',
        'update' => 'always',
        'params' => [
            'version' => 3,
            'option_group_id' => 'activity_type',
            'label' => 'Payment2c2p Transaction Failed',
            'is_reserved' => 1,
            'filter' => 1,
        ],
    ];
    $entities[] = [
        'module' => 'com.octopus8.payment2c2p',
        'name' => 'Payment2c2p_Succeed_Transaction_ActivityType',
        'entity' => 'OptionValue',
        'update' => 'always',
        'params' => [
            'version' => 3,
            'option_group_id' => 'activity_type',
            'label' => 'Payment2c2p Transaction Succeeded',
            'is_reserved' => 1,
            'filter' => 1,
        ],
    ];
//    ///@todo
//    $entities[] = [
//        'module' => 'com.octopus8.payment2c2p',
//        'name' => 'Payment2c2p_Transaction_Verification_cron',
//        'entity' => 'Job',
//        'update' => 'never',
//        // Ensure local changes are kept, eg. setting the job active
//        'params' => [
//            'version' => 3,
//            'run_frequency' => 'Always',
//            'name' => 'Payment2c2p Transaction Verifications',
//            'description' => 'Process pending transaction verifications in the Payment2c2p processor',
//            'api_entity' => 'Payment2c2pContributionTransactions',
//            'api_action' => 'validate',
//            'parameters' => "",
//            'is_active' => '1',
//        ],
//    ];
    _payment2c2p_civix_civicrm_managed($entities);}
