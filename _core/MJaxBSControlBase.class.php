<?php
class MJaxBSControlBase extends MJaxExtensionBase{
    protected $intBootstroStep = 0;
	protected $strInputPrepend = null;
	protected $strInputAppend = null;
	public function InitControl($objControl){
		$this->objControl = $objControl;
		if($this->objControl instanceof MJaxTable){
			$this->objControl->AddCssClass('table');
		}
		if($this->objControl instanceof MJaxLinkButton){
			//$this->objControl->AddCssClass('btn');
		}
	}
	public function Alert($mixObject, $strType = 'error'){
		$this->objControl->Form->CtlAlert($this->objControl, $mixObject, $strType);
	}
	public function AnimateOpen($mixObject){
		$this->objControl->Form->AnimateOpen($this->objControl, $mixObject);
	}
    public function Confirm($strText, $funConfirm, $funCancel = null){
        $this->objControl->Form->Confirm($strText, $this->objControl, $funConfirm, $funCancel);
    }
    public function Intro($strTitle, $strContent, $intStep = null, $strPlacement = "top"){
        $this->objControl->AddCssClass("bootstro");// bootstro-highlight"
        if(is_null($intStep)){
            $intStep = $this->intBootstroStep;
        }
        $this->objControl->Attr('data-bootstro-step', $intStep);
        $this->objControl->Attr('data-bootstro-title', htmlspecialchars($strTitle, ENT_QUOTES));
        $this->objControl->Attr('data-bootstro-content',htmlspecialchars($strContent, ENT_QUOTES));
        $this->objControl->Attr('data-bootstro-width',"400px");
        $this->objControl->Attr('data-bootstro-placement', $strPlacement);
        $this->objControl->Attr('data-original-title', '');
        if($this->intBootstroStep == 0){
            $this->objControl->Form->AddJSCall(
                "$(document).ready(function(){
                     bootstro.start('.bootstro');
                });"
            );
        }
        $this->intBootstroStep += 1;
    }
    public function Typehead($objListener, $strFunction){
        $strJs = sprintf("
            $('#%s').typeahead({
                source:function(strSearch, funProcess){
                    $.ajax({
                        url: MJax.strCurrPageUrl + '.typehead_%s',
                        success: funProcess,
                        data:{
                            search:strSearch
                        },
                        dataType:'json',
                        error: MJax.LoadMainPageLoadFail,
                        type:'POST',

                    });
                },
                menu: '<ol class=\"typeahead dropdown-menu\"></ol>',
                item:'<li><a href=\"#\"></a></li>'
             });
        ",
            $this->objControl->ControlId,
            $this->objControl->ControlId
        );
        $this->objControl->Form->AddJSCall(
            $strJs
        );
        $this->objControl->Form->AddRoute(
            array('get', 'post'),
            'typehead_' . $this->objControl->ControlId,
            $strFunction,
            $objListener
        );
    }
	public function ToolTip($strToolTip, $strPlacement = 'top'){
		$this->objControl->Attr('data-toggle', 'tooltip');
		$this->objControl->Attr('title',$strToolTip);
		$this->objControl->Attr('data-placement',$strPlacement);
	}
	public function Popover($mixContent, $strTitle = '', $strPlacement = 'top', $blnTriggger = false){
		if(is_array($mixContent)){
			$arrOptions = $mixContent;
		}elseif($mixContent instanceof MJaxControlBase){
			$arrOptions = array(
				'content' => $mixContent,
				
			);
		}elseif(is_string($mixContent)){
			$arrOptions = array(
				'content' => $mixContent
			);
		}
		if($arrOptions['content'] instanceof MJaxControlBase){
			$strContent = $arrOptions['content']->Render(false);
			$strContent = trim(str_replace('"','\\"',str_replace("\r","",str_replace("\n", "", $strContent))));
		
			$arrOptions['content'] = $strContent;
			$arrOptions['html'] = true;
		}
		
		$arrOptions['title'] = $strTitle;
		$arrOptions['placement'] = $strPlacement;
		$strTriggerNow = '';
		if(
			
			(
				(!array_key_exists('trigger', $arrOptions)) ||
				(!$blnTriggger)
			)
		){
			$strTriggerNow = ".popover('show')";
		}

		$this->objControl->Form->AddJSCall(
			sprintf(
				"$('#%s').popover(%s)%s;",
				$this->objControl->ControlId,
				json_encode($arrOptions),
				$strTriggerNow
			)
		);
	}
	public function Icon($strIcon, $strIconSize = ''){

		$this->objControl->Text = sprintf('<i class="%s %s"></i>', $strIcon, $strIconSize);
	}
	//public function Popover(){
		//<a href="#" class="btn" data-toggle="popover" data-placement="top" data-content="Vivamus sagittis lacus vel augue laoreet rutrum faucibus." title="Popover on top">Popover on top</a>
	//}
	public function RenderBS($blnPrint = true){
		$strHtml = $this->objControl->Render(false);
		$arrCssClasses = array();
		if(!is_null($this->strInputPrepend)){
			$arrCssClasses[] = 'input-prepend';
		}
		if(!is_null($this->strInputAppend)){
			$arrCssClasses[] = 'input-append';
		}
		
		$strReturn = sprintf(
			'<div class="%s">',
			implode(' ', $arrCssClasses)
		);
		if(!is_null($this->strInputPrepend)){
			$strReturn .= '<span class="add-on">' . $this->strInputPrepend . '</span>';
		}
		  
		$strReturn .= $strHtml;
		if(!is_null($this->strInputAppend)){
			$strReturn .= '<span class="add-on">' . $this->strInputAppend . '</span>';
		}
		$strReturn .= '</div>';
				
		if($blnPrint){
			echo $strReturn;
		}
		return $strReturn;
	}
	/////////////////////////
    // Public Properties: GET
    /////////////////////////
    public function __get($strName) {
    
        switch ($strName) {
            case "InputPrepend": return $this->strInputPrepend;
			case "InputAppend": return $this->strInputAppend;
            default:
               throw new MJaxExtensionMissingPropertyException("No property with name '" . $strName . "'");
        }
    }

    /////////////////////////
    // Public Properties: SET
    /////////////////////////
    public function __set($strName, $mixValue) {
    	
        switch ($strName) {
        	
            case "InputPrepend":
                return ($this->strInputPrepend = $mixValue);
            case "InputAppend":
				return ($this->strInputAppend = $mixValue);
				         
            default:
               throw new MJaxExtensionMissingPropertyException("No property '" . $strName . "'");
        }
    }
	
}
