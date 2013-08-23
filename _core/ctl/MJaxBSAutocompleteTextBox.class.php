<?php
class MJaxBSAutocompleteTextBox extends MJaxTextBox{
    protected $strProxyText = null;
    public function __construct($objParentControl, $objListener, $strFunction){
        parent::__construct($objParentControl);
        $this->objForm->AddRoute(
            array('get', 'post'),
            'typehead_' . $this->strControlId,
            $strFunction,
            $objListener
        );
        $this->strTextMode = MJaxTextMode::Hidden;
    }
    public function Render($blnPrint = true, $blnAjax = false){
        $strHtml = parent::Render(false);

        $strJs = sprintf("

                $('#%s_proxy').typeahead({
                    source:function(strSearch, funProcess){
                        $.ajax({
                            url: MJax.strCurrPageUrl + '.typehead_%s',
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
            $this->ControlId
        );
        if(!$blnAjax){
            $strHtml .= sprintf(
                "<input id='%s_proxy' name='%s' type='text' value='%s' data-real-id='%s' %s></input>",
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
        $this->blnModified = true;
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
            default:
                return parent::__set($strName, $mixValue);
        }
    }

}