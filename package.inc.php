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
MLCApplicationBase::$arrClassFiles['MJaxBSDateTimePicker'] = __MJAX_BS_CORE_CTL__ . '/MJaxBSDateTimePicker.class.php';
MLCApplicationBase::$arrClassFiles['MJaxBSAutocompleteTextBox'] = __MJAX_BS_CORE_CTL__ . '/MJaxBSAutocompleteTextBox.class.php';
MLCApplicationBase::$arrClassFiles['MJaxBSDropdown'] = __MJAX_BS_CORE_CTL__ . '/MJaxBSDropdown.class.php';
MLCApplicationBase::$arrClassFiles['MJaxBSConfirmPanel'] = __MJAX_BS_CORE_CTL__ . '/MJaxBSConfirmPanel.class.php';
MLCApplicationBase::$arrClassFiles['MJaxBSListBox'] = __MJAX_BS_CORE_CTL__ . '/MJaxBSListBox.class.php';

MLCApplicationBase::$arrClassFiles['MJaxBSTableColumn'] = __MJAX_BS_CORE_CTL__ . '/MJaxBSTableColumn.class.php';

MLCApplicationBase::$arrClassFiles['MJaxBSPillBoxPanel'] = __MJAX_BS_CORE_CTL__ . '/MJaxBSPillBoxPanel.class.php';
MLCApplicationBase::$arrClassFiles['MJaxBSPillBox'] = __MJAX_BS_CORE_CTL__ . '/MJaxBSPillBox.class.php';



require_once(__MJAX_BS_CORE_CTL__ . '/_events.inc.php');

MJaxControlBase::AddExtension(new MJaxBSControlBase());
MJaxFormBase::AddExtension(new MJaxBSFormBase());
//MJaxTextBox::AddExtension(new MJaxBSTextBox());

define('__MJAX_BS_ASSETS_JS__', MLCApplication::GetAssetUrl('/js', 'MJaxBootstrap'));
