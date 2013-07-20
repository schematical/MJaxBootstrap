<?php
define('__MJAX_BS__', dirname(__FILE__));
define('__MJAX_BS_CORE__', __MJAX_BS__ . '/_core');
define('__MJAX_BS_CORE_CTL__', __MJAX_BS_CORE__ . '/ctl');
define('__MJAX_BS_CORE_MODEL__', __MJAX_BS_CORE__ . '/model');
define('__MJAX_BS_CORE_VIEW__', __MJAX_BS_CORE__ . '/view');
MLCApplicationBase::$arrClassFiles['MJaxBSControlBase'] = __MJAX_BS_CORE__ . '/MJaxBSControlBase.class.php';
MLCApplicationBase::$arrClassFiles['MJaxBSFormBase'] = __MJAX_BS_CORE__ . '/MJaxBSFormBase.class.php';
MLCApplicationBase::$arrClassFiles['MJaxBSTextBox'] = __MJAX_BS_CORE__ . '/MJaxBSTextBox.class.php';
//Ctl
MLCApplicationBase::$arrClassFiles['MJaxBSCheckBox'] = __MJAX_BS_CORE_CTL__ . '/MJaxBSCheckBox.class.php';
MLCApplicationBase::$arrClassFiles['MJaxBSBreadcrumbPanel'] = __MJAX_BS_CORE_CTL__ . '/MJaxBSBreadcrumbPanel.class.php';
MLCApplicationBase::$arrClassFiles['MJaxBSAlertPanel'] = __MJAX_BS_CORE_CTL__ . '/MJaxBSAlertPanel.class.php';


//require_once(__MJAX_BS_CORE__ . '/_enum.inc.php');

MJaxControlBase::AddExtension(new MJaxBSControlBase());
MJaxFormBase::AddExtension(new MJaxBSFormBase());
//MJaxTextBox::AddExtension(new MJaxBSTextBox());

define('__MJAX_BS_ASSETS_JS__', MLCApplication::GetAssetUrl('/js', 'MJaxBootstrap'));
