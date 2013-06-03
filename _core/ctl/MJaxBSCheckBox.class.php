<?php
class MJaxBSCheckBox extends MJaxCheckBox{
	 public function __construct($objParentControl, $objMDEApp = null) {
		parent::__construct($objParentControl, $objMDEApp);        
		//$this->strTemplate = __MJAX_BS_CORE_CTL__ . '/MJaxBSCheckBox.tpl.php';
		$this->objForm->AddHeaderAsset(
			new MJaxJSHeaderAsset(
				MLCApplication::GetAssetUrl('/js/bootstrapSwitch.js', 'MJaxBootstrap')
			)
		);
		$this->objForm->AddHeaderAsset(
			new MJaxCssHeaderAsset(
				MLCApplication::GetAssetUrl('/css/bootstrapSwitch.css', 'MJaxBootstrap')
			)
		);
		
	 }
	 public function Render($blnPrint = true, $blnAjaxFormating = false){
	 	$strHtml = parent::Render(false, $blnAjaxFormating);
		$strReturn = '<div class="switch switch-mini">';
		$strReturn .= $strHtml;
		$strReturn .= '</div>';
		if($blnPrint){
			echo $strReturn;
		}
		return $strReturn;
	 }
}
