<?php
/**
 * Class MJaxBSDateTimePicker
 * @property string $Format
 * @property string LinkFormat
 */
class MJaxBSDateTimePicker extends MJaxPanel{
    public $arrOptions = array(
        //'language'=>  'fr',
        'weekStart'=> 1,
        'todayBtn'=>  1,
        'autoclose'=> 1,
        'todayHighlight'=> 1,
        'startView'=> 2,
        'forceParse'=> 0,
        'showMeridian'=> 1
    );
    public $arrIsoHack = array(
        'hh' => 'h',
        'ii' => 'i',
        'ss' => 's',
        'dd' => 'd',
        'mm' => 'm',
        'MM' => 'M',
        'yy' => 'y'
    );
    public $strFormat = DATE_ISO8601;//'dd MM yyyy - HH:ii p';//'d M yy - H:i p';
    public $strLinkFormat = null;
    public $txtDate = null;
    public function __construct($objParentControl, $objMDEApp = null) {
        parent::__construct($objParentControl, $objMDEApp);
        //$this->strTemplate = __MJAX_BS_CORE_CTL__ . '/MJaxBSCheckBox.tpl.php';
        $this->objForm->AddHeaderAsset(
            new MJaxJSHeaderAsset(
                MLCApplication::GetAssetUrl('/js/bootstrap-datetimepicker.js', 'MJaxBootstrap')
            )
        );
        $this->objForm->AddHeaderAsset(
            new MJaxCssHeaderAsset(
                MLCApplication::GetAssetUrl('/css/bootstrap-datetimepicker.min.css', 'MJaxBootstrap')
            )
        );
        $this->strTemplate = __MJAX_BS_CORE_VIEW__ . '/' . get_class($this) . '.tpl.php';

        $this->txtDate = new MJaxTextBox($this);
        //<input size="16" type="text" value="" readonly>
        $this->txtDate->Attr('size', '16');
        $this->txtDate->Attr('readonly', 'readonly');
        $this->txtDate->TextMode = MJaxTextMode::Hidden;
    }
    public function DateOnly(){
        $this->strFormat = 'dd MM yyyy';
        $this->strLinkFormat = 'yyyy-mm-dd';
        $this->arrOptions['minView'] = 2;
    }
    public function TimeOnly(){
        $this->strFormat = 'hh:ii';
        $this->strLinkFormat = 'hh:ii';
        $this->arrOptions['minView'] = 0;
        $this->arrOptions['maxView'] = 1;
        $this->arrOptions['startView'] = 1;

    }
    public function Render($blnPrint = true, $blnAjax = false){



        $strHtml = parent::Render(false);


        $strJs = sprintf("
                   $('#%s .form_datetime').datetimepicker(
                        %s
                   );
                ",
            $this->ControlId,
            json_encode($this->arrOptions)
        );
        if($this->objForm->CallType == MJaxCallType::None){
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
        if($blnAjax){
            $strHtml = MLCApplication::XmlEscape(trim($strHtml));
        }
        $this->txtDate->Modified = false;
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
            case "Format":
                return $this->strFormat;
            case "Value":
                return $this->GetValue();
            case "Options":
                return $this->arrOptions;
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
        $this->blnModified = true;
        switch ($strName) {

            case "Value":
                return  $this->SetValue($mixValue);
            case "Format":
                return $this->strFormat = $mixValue;
            case "LinkFormat":
                return $this->strLinkFormat = $mixValue;
            case "Options":
                return $this->arrOptions = $mixValue;
            default:
                return parent::__set($strName, $mixValue);
                //throw new Exception("Not porperty exists with name '" . $strName . "' in class " . __CLASS__);
        }
    }
    public function GetValue(){
        $this->blnModified = true;

        if(strlen($this->txtDate->Text) < 2){
            return null;
        }
        $strDate = MLCDateTime::ConvertFromFormatToFormat($this->strFormat, MLCDateTime::MYSQL_FORMAT, $this->txtDate->Text);
        return $strDate;
    }
    public function SetValue($mixVal){

        return $this->txtDate->Text = $mixVal;
    }
    public function _translate($strDate, $blnReverse = false){
        foreach($this->arrIsoHack as $strFind => $strReplace){
            if(!$blnReverse){
                $strDate = str_replace($strFind, $strReplace, $strDate);
            }else{
                $strDate = str_replace($strReplace, $strFind, $strDate);
            }
        }

        return $strDate;
    }



}
