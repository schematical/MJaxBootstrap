<?php
class MJaxBSListBox extends MJaxPanel{

    public $lnkPrimary = null;
    public $arrOptions = array();
    public $lnkSelOption = null;
    public function __construct($objParentControl, $strControlId = null){
        parent::__construct($objParentControl, $strControlId);
        $this->strTemplate = __MJAX_BS_CORE_VIEW__ . '/' . get_class($this) . '.tpl.php';
        $this->AddCssClass('btn-group');
        $this->lnkPrimary = new MJaxLinkButton($this);
        $this->lnkPrimary->AddCssClass('btn dropdown-toggle');
        $this->lnkPrimary->AddAction(
            $this,
            'lnkPrimary_click'
        );

        //Remember to append <span class="caret"></span>
        $this->objForm->AddJSCall(
            sprintf(
                "$(function(){ $('#%s .dropdown-toggle').dropdown(); });",
                $this->strControlId
            )
        );

    }
    public function lnkPrimary_click(){
        $this->objForm->AddJSCall(
            sprintf(
                "$('#%s .dropdown-toggle').dropdown('toggle');",
                $this->strControlId
            )
        );
    }
    public function AddItem($strText, $strValue, $blnSelected = false){
        $lnkReturn = new MJaxLinkButton($this);
        $lnkReturn->Text = $strText;
        $lnkReturn->ActionParameter = $strValue;
        if($blnSelected){
            $lnkReturn->AddCssClass('btn-primary');
        }
        $lnkReturn->AddAction(
            $this,
            'lnkOption_click'
        );
        $this->arrOptions[] = $lnkReturn;
        return $lnkReturn;
    }
    public function SetText($strText){
        $this->lnkPrimary->Text = $strText . '<span class="caret"></span>';
    }
    public function GetValue(){
        if(is_null($this->lnkSelOption)){
            return null;
        }
        return $this->lnkSelOption->ActionParameter;
    }
    public function SetValue($mixActionParameter){
        if(is_null($mixActionParameter)){
            return $this->lnkSelOption = null;
        }
       foreach($this->arrOptions as $lnkOption){
           if($lnkOption->ActionParameter == $mixActionParameter){
               return $this->lnkSelOption = $lnkOption;
           }
       }
        throw new Exception("No value in " . $this->strControlId . ' with value: ' . $mixActionParameter);
    }
    public function lnkOption_click($f, $c, $mixActionParameter){
        $this->lnkSelOption = $this->arrChildControls[$c];
        $this->TriggerEvent('change');
    }

    /////////////////////////
    // Public Properties: GET
    /////////////////////////
    public function __get($strName)
    {
        switch ($strName) {
            case "Text":
                return $this->lnkPrimary->Text;
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
                return $this->SetText($mixValue);
            default:
                return parent::__set($strName, $mixValue);
            //throw new Exception("Not porperty exists with name '" . $strName . "' in class " . __CLASS__);
        }
    }
    
}