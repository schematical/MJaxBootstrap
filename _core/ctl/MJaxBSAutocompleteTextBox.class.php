<?php
class MJaxBSAutocompleteTextBox extends MJaxTextBox{
    protected $strProxyText = null;
    protected $strUrl = '/data/search';
    protected $blnOnlyExisting = false;
    protected $strEntity = null;
    protected $strEntityField = null;
    public function __construct($objParentControl, $strControlId = null){//$strUrl = null, $strFunction = null){
        parent::__construct($objParentControl, $strControlId);
       /* if(!is_null($strUrl)){
            if(is_string($strUrl)){
                $this->strUrl = $strUrl;
            }else{
                $this->objForm->AddRoute(
                    array('get', 'post'),
                    'typehead_' . $this->strControlId,
                    $strFunction,
                    $strUrl
                );
            }
        }*/
        $this->strTextMode = MJaxTextMode::Hidden;
    }
    public function Render($blnPrint = true, $blnAjax = false){
        $strHtml = parent::Render(false);
        //Messed up hacky stuff
        $arrData = array();
        if(!is_null($this->strEntity)){
            $arrData['entity'] = $this->strEntity;
            $arrData['entity_field'] = $this->strEntityField;
            $arrData['url'] = $this->strUrl;
        }else{

        }
        $arrData['only_existing'] = $this->blnOnlyExisting;
        $strJs = sprintf(
            "MJax.BS.Autocomplete.Init('%s',%s);",
            $this->ControlId,
            json_encode($arrData)
        );

        if(!$blnAjax){
            $strHtml .= sprintf(
                "<input id='%s_proxy' name='%s' type='text' value='%s' data-real-id='%s' %s />",
                $this->strControlId,
                $this->strName,
                $this->strProxyText,
                $this->strControlId,
                $this->GetAttrString()
            );
            $strHtml .= "<script language='javascript'>";
            $strHtml .= '$(function(){ ';
            $strHtml .= $strJs;
            $strHtml .= '});';
            $strHtml .= '</script>';
        }else{
            $this->objForm->AddJSCall(
                $strJs
            );
        }
        $this->blnModified = false;
        if($blnPrint){
            echo $strHtml;
        }
        return $strHtml;

    }

    /////////////////////////
    // Public Properties: GET
    /////////////////////////
    public function __get($strName)
    {
        switch ($strName) {
            case "Text":
                return $this->strProxyText;
            case "Value":
                return $this->strText;
            case "Url":
                return $this->strUrl;
            case "Entity":
                return $this->strEntity;
            case "EntityField":
                return $this->strEntityField;
            case "OnlyExisting":
                return $this->blnOnlyExisting;
            default:
                return parent::__get($strName);
        }
    }

    /////////////////////////
    // Public Properties: SET
    /////////////////////////
    public function __set($strName, $mixValue)
    {
        switch ($strName) {
            case "Text":
                return $this->strProxyText = $mixValue;
            case "Value":
                return $this->strText = $mixValue;
            case "Url":
                return $this->strUrl = $mixValue;
            case "Entity":
                return $this->strEntity = $mixValue;
            case "EntityField":
                return $this->strEntityField = $mixValue;
            case "OnlyExisting":
                return $this->blnOnlyExisting = $mixValue;

            default:
                return parent::__set($strName, $mixValue);
        }
    }
    public function SetSearchEntity($strEntity, $strField = null){
        $this->strEntity = $strEntity;
        $this->strEntityField = $strField;
    }
    public function GetValue(){
        $arrParts = explode('_', $this->strText);
        if(
            (count($arrParts) == 2) &&
            (class_exists($arrParts[0]))
        ){
            return call_user_func($arrParts[0] . '::LoadById', $arrParts[1]);
        }
        return parent::GetValue();
    }
    public function SetValue($mixData){
        if(
            (is_object($mixData)) &&
            ($mixData instanceof BaseEntity)
        ){
            $this->strProxyText = $mixData->__toString();

            return $this->strText = get_class($mixData) . '_' . $mixData->GetId();
        }else{
            //throw new Exception($this->strProxyText);

            $this->strProxyText = $mixData;

            return parent::SetValue($mixData);
        }

    }

}