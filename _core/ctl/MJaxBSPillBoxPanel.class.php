<?php
/* 
 * This is a basic dif for use with the MJax Framework
 */
class MJaxBSPillBoxPanel extends MJaxControl{

    public $arrPills = array();
    public function __construct($objParentControl, $strControlId = null){
        parent::__construct($objParentControl, $strControlId);
        $this->AddCssClass('mjax-pill-box');
        //$this->strTemplate = __MJAX_WADMIN_THEME_CORE_VIEW__ . '/MJaxWAdminSubNavItem.tpl.php';
    }
    public function AddPillbox($strText){

        $ctlPill = new MJaxBSPillBox($this);//$strName;
        $ctlPill->Text = $strText;
        $this->blnModified = false;
        $this->Append($ctlPill);
        return $ctlPill;

    }
    public function Render($blnPrint = true, $blnRenderAsAjax = false){

        if($blnRenderAsAjax){
            $strElementOverride = 'control';
            $this->Attr('transition', $this->strTransition);
        }else{
            $strElementOverride = 'ul';
        }
        $strRendered = parent::Render();

        $strHeader = sprintf("<%s id='%s' name='%s' %s>\n", $strElementOverride, $this->strControlId, $this->strControlId, $this->GetAttrString());
        //If template is set render template

        foreach($this->arrChildControls as $objChildControl){
            $strRendered .= $objChildControl->Render(false);
        }

        $strFooter = sprintf("</%s>", $strElementOverride);
        if(!$blnRenderAsAjax){
            $strRendered = $strHeader . $strRendered . $strFooter;
        }else{
            $strRendered = $strHeader . MLCApplication::XmlEscape(trim($strRendered)) . $strFooter;
        }

        $this->blnModified = false;
        if($blnPrint){
            echo($strRendered);
        }else{
            return $strRendered;
        }
    }
    /////////////////////////
    // Public Properties: GET
    /////////////////////////
    public function __get($strName) {
        switch ($strName) {
           /* case "Href":
                return $this->strHref;*/

            default:
                //throw new Exception("Not porperty exists with name '" . $strName . "' in class " . __CLASS__);
                return parent::__get($strName);

        }
    }

    /////////////////////////
    // Public Properties: SET
    /////////////////////////
    public function __set($strName, $mixValue) {
        switch ($strName) {
           /* case "Href":
                    return $this->strHref = $mixValue;*/
            default:
                //throw new Exception("Not porperty exists with name '" . $strName . "' in class " . __CLASS__);
                return parent::__set($strName, $mixValue);

        }
    }
}
?>