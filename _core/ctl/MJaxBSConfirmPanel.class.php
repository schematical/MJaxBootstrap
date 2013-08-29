<?php
class MJaxBSConfirmPanel extends MJaxPanel{
    public $lnkConfirm = null;
    public $lnkCancel = null;
    public $strBodyText = null;
    public function __construct($objParentControl, $strControlId = null){
        parent::__construct($objParentControl, $strControlId);
        $this->strTemplate = __MJAX_BS_CORE_VIEW__ . '/' . get_class($this) . '.tpl.php';

        $this->lnkConfirm = new MJaxLinkButton($this);
        $this->lnkConfirm->AddCssClass('btn btn-large btn-success');
        $this->lnkConfirm->Text = "Confirm";
        $this->lnkConfirm->AddAction($this, 'lnkConfirm_click');

        $this->lnkCancel = new MJaxLinkButton($this);
        $this->lnkCancel->AddCssClass('btn btn-large btn-error');
        $this->lnkCancel->Text = "Cancel";
        $this->lnkCancel->AddAction($this, 'lnkCancel_click');
    }

    public function lnkCancel_click()
    {
        $this->TriggerEvent('mjax-bs-cancel');
        $this->objForm->HideAlert();
    }

    public function lnkConfirm_click()
    {
        $this->TriggerEvent('mjax-bs-confirm');
        $this->objForm->HideAlert();
    }

    /////////////////////////
    // Public Properties: GET
    /////////////////////////
    public function __get($strName)
    {
        switch ($strName) {
            case "Text":
                return $this->strBodyText;

            default:
                return parent::__get($strName);
                //throw new Exception("Not porperty exists with name '" . $strName . "' in class " . __CLASS__);
        }
    }

    /////////////////////////
    // Public Properties: SET
    /////////////////////////
    public function __set($strName, $mixValue)
    {
        switch ($strName) {

            case "Text":
                return $this->strBodyText = $mixValue;
            default:
                return parent::__set($strName, $mixValue);
                //throw new Exception("Not porperty exists with name '" . $strName . "' in class " . __CLASS__);
        }
    }
    
}