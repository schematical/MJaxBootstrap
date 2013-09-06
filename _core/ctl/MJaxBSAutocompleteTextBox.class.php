<?php
class MJaxBSAutocompleteTextBox extends MJaxTextBox{
    protected $strProxyText = null;
    protected $strUrl = null;
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
        //TODO: Remove all this BS seperate out properly
        if(is_null($this->strUrl)){
            $strUrlCode = sprintf("if(MJax.strCurrPageUrl.indexOf('?') == -1){
                            var strUrl = MJax.strCurrPageUrl + '.typehead_%s'
                        }else{
                            var strUrl = MJax.strCurrPageUrl + '&mjax-route-ext=typehead_%s';
                        }",
                $this->ControlId,
                $this->ControlId
            );
        }else{
            $strUrlCode = 'var strUrl = "' . $this->strUrl . '";';
        }


        $strJs = sprintf("

                $('#%s_proxy').typeahead({
                    source:function(strSearch, funProcess){

                        %s
                        $.ajax({
                            url: strUrl,
                            success: funProcess,
                            data:{
                                search:strSearch
                            },
                            dataType:'json',
                            error: MJax.LoadMainPageLoadFail,
                            type:'POST'

                        });
                    },
                    menu: '<ol class=\"typeahead dropdown-menu\"></ol>',
                    item:'<li><a href=\"#\"></a></li>'
                 });

            ",


            $this->ControlId,
            $strUrlCode
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
            default:
                return parent::__set($strName, $mixValue);
        }
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