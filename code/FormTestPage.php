<?php

class FormTestPage extends Page
{
}

class FormTestPage_Controller extends Page_Controller
{
        
    public function init()
    {
        parent::init();
    }
    
    public static $allowed_actions = array(
        'MyForm'
    );
    
    public function MyForm()
    {
        $form = Form::create(
            $this, // controller
            "MyForm", // form name
            new FieldList(// fields
                TextField::create("FirstName")
                    ->setTitle('First name')
                    ->setAttribute("placeholder", "Min. 3 znaky")
                    ->setAttribute("data-validation-required-message", "nezabudnite vpísať vaše meno")
                    ->setAttribute("required", true),
                TextField::create("Surname")
                    ->setTitle('Last name')
                    ->setMaxLength(50)
                    ->setAttribute("required", true),
                EmailField::create("Email")
                    ->setTitle("Email address")
                    ->setAttribute("required", true)
                    ->setAttribute("data-validation-email-message", "nezabudnite napísať existujúci majl")
                    ->setAttribute('type', 'email'),
                DropdownField::create("Cisla")
                    ->setTitle("Čísla")
                    ->setSource(array("jedna", "dva", "tri"))
                    ->addExtraClass("expand")
                    ->setEmptyString("musíš vybrať jedno numero"),
                CheckboxField::create("Donkey")
                    ->setTitle("Si donkey?"),
                CheckboxField::create("Donkey2")
                    ->setTitle("Si veľmi dlhý a vráskavý donkey s malými ušami?"),
                ReadonlyField::create("ReadOnly")
                    ->setTitle("Toto nezmeníte.... readonly")
                    ->setValue("nemeniteľné"),
               TextareaField::create("Text")
                   ->setTitle("Poznámka"),
                DateField::create("Dátum")
                    ->setConfig("showcalendar", true)
                    ->setConfig("jQueryUI.firstDay", 1)
                    ->setConfig("jQueryUI.dayNamesMin", array("Ne", "Po", "Ut", "St", "Št", "Pi", "So"))
                    ->setLocale('sk_SK'),
                DatetimeField::create('DátumČas', 'Dátum a čas')
                    ->setConfig('datavalueformat', 'yyyy-MM-dd HH:mm')
                    ->setConfig('showcalendar', 1),
                GroupedDropdownField::create("grouped")
                    ->setTitle("Zoskupený dropdown")
                    ->setSource(array("numbers" => array("1", "2", "3"), "letters"=>array("a", "b", "c"))),
                OptionsetField::create("options")
                    ->setTitle("Čísla 2")
                    ->setSource(array("jedna", "dva", "tri")),
                HeaderField::create("header", "Toto je nadpis")
                    ->setTitle("overwritten nadpissss"),
                LiteralField::create("dataless", "html here")
                    ->setTitle("dataless")
                    ->setContent("<p>Or overwritten here</p><ul><li>item 1</li><li>item 2</li></ul>"),
                FileField::create("Nahraj")
            ),
            new FieldList(// actions
                FormAction::create("doMyForm")
                    ->setTitle("Odoslať")
                    ->addExtraClass("button radius"),
                ResetFormAction::create("resetMyForm", "Reset")
                    ->addExtraClass("button secondary small radius")
            ),
            new RequiredFields(// validation
                "Email", "FirstName", "Text"
            )
        )
        ->setAttribute("novalidate", "novalidate")
        ->addExtraClass("custom horizontal")
        ;
        return $form;
    }
    
    public function doMyForm(array $data, Form $form)
    {
        //return $this->render();

           if ($form->validate()) {
               if (Director::is_ajax()) {
                   return "Nice!";
               } else {
                   $this->customise(array("MyForm" => "Nice!"));
               }
           }
        return;
    }
}
