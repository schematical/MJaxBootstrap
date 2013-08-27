<?php
class MJaxBSDropdown extends MJaxPanel{
    public $lnkMain = null;
    public $arrOptions = null;

    public function __construct($objParentControl, $strControlId = null, $lnkMain = null){
        parent::__construct($objParentControl, $strControlId);
        $this->strTemplate = __VIEW_ACTIVE_APP_DIR__ . '/www/_panels/' . get_class($this) . '.tpl.php';
        $this->AddCssClass('dropdown');
        if(is_null($lnkMain)){
            $this->lnkMain = new MJaxLinkButton($this);
        }else{
            $this->lnkMain = $lnkMain;
        }
        $this->lnkMain->AddCssClass('btn dropdown-toggle');
        $this->lnkMain->Attr('data-toggle', 'dropdown');

    }
    public function AddOption($strText){
        $lnkOption = new MJaxLinkButton($this);
        $lnkOption->Attr('tabindex', '-1');
        $lnkOption->Text = $strText;
        $this->arrOptions[] = $lnkOption;
        return $lnkOption;
    }
    
}