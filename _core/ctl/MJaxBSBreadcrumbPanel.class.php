<?php
class MJaxBSBreadcrumbPanel extends MJaxPanel{
    public $arrCrumbs = array();
    public function __construct($objParentControl, $strControlId = null) {
        parent::__construct($objParentControl, $strControlId);
        $this->strTemplate = __MJAX_BS_CORE_VIEW__ . '/MJaxBSBreadcrumbPanel.tpl.php';
    }
    public function AddCrumb($mixCrumb, $objEvent = null, $mixAction = null){
        if(!is_null($objEvent) ){
            $strText = $mixCrumb;
            $mixCrumb = new MJaxLinkButton($this);
            $mixCrumb->Text = $strText;
            if(!is_string($objEvent)){
                $mixCrumb->AddAction($objEvent, $mixAction);
            }else{
                $mixCrumb->Href = $objEvent;
            }

        }
        $intNewIndex = count($this->arrCrumbs);
        if($mixCrumb instanceof MJaxControl){
            $mixCrumb->ActionParameter = $intNewIndex;
        }

        $this->arrCrumbs[$intNewIndex] = $mixCrumb;
        $this->blnModified = true;
        return $this->arrCrumbs[$intNewIndex];
    }
    public function ClearCrumbs($intAfterIndex = -1){
        foreach($this->arrCrumbs as $intIndex => $mixCrumb){
            if($intIndex > $intAfterIndex){
                if($mixCrumb instanceof MJaxControl){
                    $mixCrumb->Remove();
                }
                unset($this->arrCrumbs[$intIndex]);
            }
        }
        $this->blnModified = true;
    }
}