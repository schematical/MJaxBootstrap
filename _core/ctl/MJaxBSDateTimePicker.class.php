<?php
class MJaxBSDateTimePicker extends MJaxPanel{
    public function __construct($objParentControl, $objMDEApp = null) {
        parent::__construct($objParentControl, $objMDEApp);
        //$this->strTemplate = __MJAX_BS_CORE_CTL__ . '/MJaxBSCheckBox.tpl.php';
        $this->objForm->AddHeaderAsset(
            new MJaxJSHeaderAsset(
                MLCApplication::GetAssetUrl('/js/bootstrap-datetimepicker.min.js', 'MJaxBootstrap')
            )
        );
        $this->objForm->AddHeaderAsset(
            new MJaxCssHeaderAsset(
                MLCApplication::GetAssetUrl('/css/bootstrap-datetimepicker.min.css', 'MJaxBootstrap')
            )
        );
        $this->strTemplate = __MJAX_BS_CORE_VIEW__ . '/' . get_class($this) . '.tpl.php';

    }

}
