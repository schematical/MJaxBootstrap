<?php
class MJaxBSFormBase extends MJaxExtensionBase{
	protected static $ctlLastAlert = null;
	public function InitControl($objControl){
		$this->objControl = $objControl;
        $this->objControl->Footer = __MJAX_BS_CORE_VIEW__ . '/_footer.inc.php';
		$this->objControl->AddHeaderAsset(new MJaxJSHeaderAsset(
            MLCApplication::GetAssetUrl('/js/MJax.BS.js', 'MJaxBootstrap')
        ));
        if(SERVER_ENV == 'prod'){
            $this->objControl->AddHeaderAsset(new MJaxCssHeaderAsset(
                MLCApplication::GetAssetUrl('/css/bootstrap.css', 'MJaxBootstrap')
            ));
            if(!defined('MLC_BS_SKIP_RESPONSIVE')){
                $this->objControl->AddHeaderAsset(new MJaxCssHeaderAsset(
                    MLCApplication::GetAssetUrl('/css/bootstrap-responsive.css', 'MJaxBootstrap')
                ));
            }
        }else{
            $this->objControl->AddHeaderAsset(new MJaxCssHeaderAsset(
                MLCApplication::GetAssetUrl('/css/bootstrap.min.css', 'MJaxBootstrap')
            ));
            if(!defined('MLC_BS_SKIP_RESPONSIVE')){
                $this->objControl->AddHeaderAsset(new MJaxCssHeaderAsset(
                    MLCApplication::GetAssetUrl('/css/bootstrap-responsive.min.css', 'MJaxBootstrap')
                ));
            }
        }
	}

	public function GetLastAlertedControl(){
		return self::$ctlLastAlert;
	}
	public function Alert($mixObject){
		
		if($mixObject instanceof MJaxControlBase){
			self::$ctlLastAlert = $mixObject;
			$strContent =  $mixObject->Render(false);			
		}elseif(is_string($mixObject)){
			$strContent = $mixObject;
		}else{
			throw new Exception("Alert must have first parameter of type 'MJaxControlBase' or String");
		}
		$strContent = trim(str_replace('"','\\"',str_replace("\r","",str_replace("\n", "\\n", $strContent))));
		$this->objControl->AddJSCall(
			sprintf(
				'MJax.BS.Alert("%s");',
				$strContent
			)
		);
		$this->objControl->ForceRenderFormState = true;
		$this->objControl->SkipMainWindowRender = true;	
			
    }
    public function CtlAlert($mixControl, $mixAlert, $strType = 'error'){
		if($mixControl instanceof MJaxControl){
			$strControlId = $mixControl->ControlId;
		}elseif(is_string($mixControl)){
			$strControlId = $mixControl;
		}else{
			throw new MLCWrongTypeException(__FUNCTION__, 1);
		}
		if($mixAlert instanceof MJaxControlBase){
			$strContent =  $mixAlert->Render(false);			
		}elseif(is_string($mixAlert)){
			$strContent = $mixAlert;
		}else{
			throw new Exception("Alert must have first parameter of type 'MJaxControlBase' or String");
		}
		$strContent = trim(str_replace('"','\\"',str_replace("\r","",str_replace("\n", "", $strContent))));
		$this->objControl->AddJSCall(
			sprintf(
				'MJax.BS.CtlAlert("#%s", "%s", "%s");',
				$strControlId,
				$strContent,
				$strType
			)
		);
		$this->objControl->ForceRenderFormState = true;
		$this->objControl->SkipMainWindowRender = true;		
    }
	public function ClearCtlAlerts(){
		$this->objControl->AddJSCall(			
				'MJax.BS.ClearCtlAlerts();'
		);
	}
    public function HideAlert(){
    	$this->objControl->AddJSCall("MJax.BS.HideAlert();");
		if(!is_null(self::$ctlLastAlert)){
			self::$ctlLastAlert->Remove();
			self::$ctlLastAlert = null;
		}
    	$this->objControl->ForceRenderFormState = true;
		$this->objControl->SkipMainWindowRender = true;
    }
	public function ScrollTo($mixControl){
		if($mixControl instanceof MJaxControl){
			$strControlId = $mixControl->ControlId;
		}elseif(is_string($mixControl)){
			$strControlId = $mixControl;
		}else{
			throw new MLCWrongTypeException(__FUNCTION__, 1);
		}
		$this->objControl->AddJSCall(
			sprintf(
				"MJax.BS.ScrollTo('#%s');",
				$strControlId
			)
		);
		
	}
	public function AnimateOpen($mixControl, $strDirection = 'vert'){
		if($mixControl instanceof MJaxControl){
			$strControlId = $mixControl->ControlId;
		}elseif(is_string($mixControl)){
			$strControlId = $mixControl;
		}else{
			throw new MLCWrongTypeException(__FUNCTION__, 1);
		}
		$this->objControl->AddJSCall(
			sprintf(
				"MJax.BS.AnimateOpen('#%s', '%s');",
				$strControlId,
                $strDirection
			)
		);
		$this->objControl->ForceRenderFormState = true;
		$this->objControl->SkipMainWindowRender = true;		
	}
	public function AnimateClosed($mixControl, $strDirection = 'vert'){
		if($mixControl instanceof MJaxControl){
			$strControlId = $mixControl->ControlId;
		}elseif(is_string($mixControl)){
			$strControlId = $mixControl;
		}else{
			throw new MLCWrongTypeException(__FUNCTION__, 1);
		}
		$this->objControl->AddJSCall(
			sprintf(
				"MJax.BS.AnimateClosed('#%s', '%s');",
				$strControlId,
                $strDirection
			)
		);
		$this->objControl->ForceRenderFormState = true;
		$this->objControl->SkipMainWindowRender = true;		
	}
	
	
}
