<?php
class MJaxBSTableColumn extends MJaxTableColumn{
    const EDIT_CONTROL_ID = 'mjax-table-edit-ctl';

    protected $strSearchEntity = null;
    protected $strSearchField = null;
    //Designed for auto complete

    //also will work with the MLCDataLayer


    //1) Create the auto complete text box

    //2) Set the url on change


    public function __construct(MJaxTable $objTable, $strKey, $mixTitle){
        parent::__construct( $objTable, $strKey, $mixTitle);
        /*$this->objRenderObject = $this;
        $this->strRenderFunction = '_render';
        $this->strEditCtlInitMethod = '_init';*/
        $this->strEditControlClass = 'MJaxBSAutocompleteTextBox';
        $this->blnEditable = true;
    }
    public function GetEditControl(){
        if(array_key_exists(self::EDIT_CONTROL_ID, $this->objTable->Form->Controls)){
            $ctlEdit = $this->objTable->Form->Controls[self::EDIT_CONTROL_ID];
        }else{
            $strClassName = $this->strEditControlClass;
            $ctlEdit = new $strClassName($this->objTable->Form, self::EDIT_CONTROL_ID);
            /*$ctlEdit->AddAction(
                new MJaxBlurEvent(),
                new MJaxServerControlAction(
                    $this->objTable,
                    '_Editsave'
                )
            );*/
        }
        return $ctlEdit;
    }
    public function UpdateValue(){
        $ctlEdit = $this->GetEditControl();

        $ctlEdit->ParsePostData();
        $mixValue = $ctlEdit->GetValue();
        if(
            (is_object($mixValue)) &&
            ($mixValue instanceof BaseEntity)
        ){
            if(!is_null($this->strSearchField)){
                $mixValue = $mixValue->__get($this->strSearchField);
            }
        }
        $this->objTable->SelectedRow->SetData(
            $this->strKey,
            $mixValue
        );
    }

    public function RenderInner($objRow){
        $strRendered = '';
        $mixData = $objRow->GetData($this->strKey);
        //error_log('!!!' . $this->strKey . '----------' . $mixData);

        if($objRow->IsSelected() && $this->IsSelected() && $this->blnEditable && $this->objTable->EditMode == MJaxTableEditMode::INLINE){



            $ctlEdit = $this->GetEditControl();
            $strSearchExt = $this->strSearchEntity;
            if(!is_null($this->strSearchField)){
                $strSearchExt .= '_' .$this->strSearchField;
            }
            $ctlEdit->SetValue($objRow->GetData($this->strKey));
            $ctlEdit->Url = $this->objTable->Form->objEntityManager->GetUrl(
                '/data/search',
                array(
                    'mjax-route-ext'=> $strSearchExt
                )
            );

            $strHtml = $ctlEdit->Render(false);

        }else{
            if(is_null($mixData)){
                $strHtml = '&nbsp;';
            }else{
                $strHtml = $mixData;
            }
        }
        return $strHtml;

    }
    public function GetTitle(){
        return $this->strTitle;
    }
    public function RenderIndvControl($objRow){
        $mixData = $objRow->GetData($this->strKey);
        if(!array_key_exists($this->strKey, $objRow->arrEditControls)){
            if(!is_null($this->strEditCtlInitMethod)){
                $objRow->arrEditControls[$this->strKey] = $this->objRenderObject->{$this->strEditCtlInitMethod}($objRow, $mixData, $this->strKey);
            }elseif(!is_null($this->strEditControlClass)){
                $strClassName = $this->strEditControlClass;
                $objRow->arrEditControls[$this->strKey] = new $strClassName(
                    $objRow
                );
                $objRow->arrEditControls[$this->strKey]->SetValue($mixData);
            }else{
                //I think this is the remove button
            }
        }

        $strHtml = $objRow->arrEditControls[$this->strKey]->Render(false);
        return $strHtml;
    }

/////////////////////////
    // Public Properties: GET
    /////////////////////////
    public function __get($strName)
    {
        switch ($strName) {
            case "SearchEntity":
                return $this->strSearchEntity;
            case "SearchField":
                return $this->strSearchField;
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
        switch ($strName) {
            case "SearchEntity":
                return $this->strSearchEntity = $mixValue;
            case "SearchField":
                return $this->strSearchField = $mixValue;
            default:
                return parent::__set($strName, $mixValue);
            //throw new Exception("Not porperty exists with name '" . $strName . "' in class " . __CLASS__);
        }
    }



}