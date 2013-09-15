<?php
/* 
 * This is a basic dif for use with the MJax Framework
 */
class MJaxBSPillBox extends MJaxControl{

    public function __construct($objParentControl){
        parent::__construct($objParentControl);

        $this->AddAction(
            $this, 'Remove'
        );

    }
    public function Remove(){
        parent::Remove();
        $this->objForm->Detach($this);
    }

    public function Render($blnPrint = true, $blnRenderAsAjax = false){

        if($blnRenderAsAjax){
            $strElementOverride = 'control';
            $this->Attr('transition', $this->strTransition);
        }else{
            $strElementOverride = 'li';
        }
        $strRendered = parent::Render();

        $strHeader = sprintf("<%s id='%s' name='%s' %s>\n", $strElementOverride, $this->strControlId, $this->strControlId, $this->GetAttrString());
        //If template is set render template


        //Render Text
        $strRendered .= $this->strText;
        //Check/Do autorender children

        $strRendered .= '<button type="button" class="close">×</button>';
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
            case "Href":
                return $this->strHref;

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
            case "Href":
                    return $this->strHref = $mixValue;
            default:
                //throw new Exception("Not porperty exists with name '" . $strName . "' in class " . __CLASS__);
                return parent::__set($strName, $mixValue);

        }
    }
}
?>