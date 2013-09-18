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
        'yy' => 'Y',
        'yy' => 'y',
    );
    public $strDate = null;
    public $blnInited = false;
    //public $strFormat = 'm/d/yy - h:ii p';//'d M yy - H:i p';
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
        $this->arrOptions['format'] = 'm/d/yy - H:ii P';
        $this->strTemplate = __MJAX_BS_CORE_VIEW__ . '/' . get_class($this) . '.tpl.php';

        $this->txtDate = new MJaxTextBox($this, $this->ControlId . '_prxyDate');
        //<input size="16" type="text" value="" readonly>
        $this->txtDate->Attr('size', '16');
        $this->txtDate->Attr('readonly', 'readonly');
        $this->txtDate->TextMode = MJaxTextMode::Hidden;
        $this->Style->Display = 'block';


        //$this->Style->__set('margin-left','18Px;');
        $this->AddCssClass('controls input-append date form_datetime');

        $this->arrOptions['startDate'] = MLCDateTime::Now();

        /*
         *   $arrOptions['data-date'] = $this->strDate;


        $this->arrAttr['data-date-format'] = $this->strFormat;
        $this->arrAttr['data-link-field'] = $this->txtDate->ControlId;
        if(!is_null($this->strLinkFormat)){
            $this->arrAttr['data-link-format'] = $this->strLinkFormat;
        }

         */


    }
    public function DateOnly(){
        $this->arrOptions['format'] = 'mm/dd/yy';

        $this->arrOptions['minView'] = 2;
    }
    public function TimeOnly(){
        $this->arrOptions['format'] = 'H:ii P';
        //$this->strLinkFormat = 'hh:ii';
        $this->arrOptions['minView'] = 0;
        $this->arrOptions['maxView'] = 1;
        $this->arrOptions['startView'] = 1;

    }
    public function Render($blnPrint = true, $blnAjax = false){
        $this->Init();
        $strHtml = parent::Render($blnPrint, $blnAjax);

        return $strHtml;
    }
    public function CallJS($mixFirstArgument, $mixSecondArgument = null){
        if(is_array($mixFirstArgument)){
            $strFirstArgument = json_encode($mixFirstArgument);
        }elseif(is_string($mixFirstArgument)){
            $strFirstArgument = "'". $mixFirstArgument . "'";//
        }elseif(is_numeric($mixFirstArgument)){
            $strFirstArgument =  $mixFirstArgument;
        }else{
            throw new MLCWrongTypeException(__FUNCTION__, $mixFirstArgument);
        }
        $strSecondArgument = '';
        if(!is_null($mixSecondArgument)){
            $strSecondArgument = ', ';
            if(is_array($mixSecondArgument)){
                $strSecondArgument .= json_encode($mixSecondArgument);
            }elseif(is_string($mixSecondArgument)){
                $strSecondArgument .= "'". $mixSecondArgument . "'";//
            }elseif(is_numeric($mixSecondArgument)){
                $strSecondArgument .=  $mixSecondArgument;
            }else{
                throw new MLCWrongTypeException(__FUNCTION__, $mixSecondArgument);
            }
        }


        $strJs = sprintf("
            $(document).one('mjax-page-load', function(){
               $('#%s').datetimepicker(
                    %s
                    %s
               );
            });",
            $this->ControlId,
            $strFirstArgument,
            $strSecondArgument
        );


        $this->objForm->AddJSCall(
            $strJs
        );

    }
    public function Init($arrOptions = array()){
        if(!$this->blnInited){
            foreach($this->arrOptions as $strKey => $mixVal){
                if(!array_key_exists($strKey, $arrOptions)){

                    $arrOptions[$strKey] = $this->arrOptions[$strKey];
                }
            }
            //$this->CallJS($arrOptions);
            $this->objForm->AddJSCall(
                sprintf(
                    "$(document).one('mjax-page-load', function(){
                        MJax.BS.DatetimePicker.Init('#%s', %s);
                    });",
                    $this->strControlId,
                    json_encode($arrOptions)
                )
            );
            $this->blnInited = true;
        }

    }
    public function Show(){

        $this->CallJS('show');

    }
    public function Hide(){

        $this->CallJS('hide');

    }
    public function Place(){

        $this->CallJS('place');

    }
    public function Remove(){

        $this->CallJS('remove');

    }
    public function Update(){

        $this->CallJS('update',  $this->strDate);

    }


    /////////////////////////
    // Public Properties: GET
    /////////////////////////
    public function __get($strName)
    {
        switch ($strName) {
            case "Format":
                return $this->arrOptions['format'];
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
            case "Modified":
                throw new Exception("WTF?");
            case "Value":
                return  $this->SetValue($mixValue);
            case "Format":
                return  $this->arrOptions['format'] = $mixValue;

            case "Options":
                return $this->arrOptions = $mixValue;
            case "StartDate":
                return $this->arrOptions['startDate'] = $mixValue;
            case "EndDate":
                return $this->arrOptions['endDate'] = $mixValue;
            default:
                return parent::__set($strName, $mixValue);
                //throw new Exception("Not porperty exists with name '" . $strName . "' in class " . __CLASS__);
        }
    }
    public function ParsePostData(){
        //parent::ParsePostData();
        if(array_key_exists($this->strControlId, $_POST)){

            $this->strDate = date(MLCDateTime::MYSQL_FORMAT, $_POST [$this->strControlId]);//->format(MLCDateTime::MYSQL_FORMAT);

        }
    }
    public function GetValue(){


        if(strlen($this->strDate) < 2){
            return null;
        }

        //$strDate = MLCDateTime::ConvertFromFormatToFormat($this->strFormat, MLCDateTime::MYSQL_FORMAT, $this->strDate);
        return $this->strDate;
    }
    public function SetValue($mixVal){
        $this->strDate= $mixVal;
        if(!$this->blnInited){
            $this->arrOptions['initialDate'] = $this->strDate;
        }else{
            //$this->CallJS('setValue', $this->strDate);
            $this->txtDate->Text = $this->strDate;
            $this->Update();
        }




    }
    public function RemoveMinStartDate(){
        unset($this->arrOptions['startDate']);
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
