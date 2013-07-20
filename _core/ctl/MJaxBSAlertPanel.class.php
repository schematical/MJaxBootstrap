<?php
class MJaxBSAlertPanel extends MJaxPanel{
    const INFO = 'info';
    const ERROR = 'error';
    const SUCCESS = 'success';
    public function __construct($objParentControl, $strExtra = null){
        parent::__construct($objParentControl);
        $this->AddCssClass('alert');
        if(!is_null($strExtra)){
            $this->AddCssClass('alert-' . $strExtra);
        }
    }
}