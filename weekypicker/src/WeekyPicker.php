<?php
/**
 * @copyright Copyright (c) 2015 thiagoaugustus! Consulting Group LLC
 * @link http://startuping.co
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */
namespace thiagoaugustus\weekypicker;

use yii\helpers\Html;
use yii\helpers\Json;
use yii\widgets\InputWidget;

/**
 *
 * TinyMCE renders a tinyMCE js plugin for WYSIWYG editing.
 *
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @link http://www.ramirezcobos.com/
 * @link http://www.2amigos.us/
 */
class WeekyPicker extends InputWidget
{
    /**
     * @var string the language to use. Defaults to null (en).
     */
    public $language;
    /**
     * @var string the type of measure to use. Defaults to null (months).
     */
    public $type;
    /**
     * @var array the options for the TinyMCE JS plugin.
     * Please refer to the TinyMCE JS plugin Web page for possible options.
     * @see http://www.tinymce.com/wiki.php/Configuration
     */
    public $clientOptions = [];
    /**
     * @var bool whether to set the on change event for the editor. This is required to be able to validate data.
     * @see https://github.com/2amigos/yii2-tinymce-widget/issues/7
     */
    public $triggerSaveOnBeforeValidateForm = true;

    // Types
    public $months   = ['JAN', 'FEV', 'MAR', 'ABR', 'MAI', 'JUN', 'JUL', 'AGO', 'SET', 'OUT', 'NOV', 'DEZ']; // 1-12
    public $weekDays = ['SEG', 'TER', 'QUA', 'QUI', 'SEX', 'SAB', 'DOM']; // 1-7
    public $days     = ['min' => 1, 'max' => 31]; // 1-31
    public $hours    = ['min' => 0, 'max' => 23];
    public $minutes  = ['min' => 0, 'max' => 59];

    public function init()
    {
        // Input params
        $this->options['class'] = "weekypicker " . $this->type;
        $this->options['type']  = "hidden";
        $this->options['value'] = "";
        WeekyPickerwidgetAssets::register($this->view);
        $this->getImput();
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        switch ($this->type){
            case "minutes":  $this->mountData($this->type); break;
            case "hours":    $this->mountData($this->type); break;
            case "days":     $this->mountData($this->type); break;
            case "weekDays": $this->mountData($this->type); break;
            default:         $this->mountData($this->type); break;
        }
    }

    private function mountData($values)
    {
        $html = $this->openHtml();

        if ($values == "weekDays" || $values == "months") {

            $html .= "<br>";
            $counter = 1;

            foreach($this->$values as $value){
                $html .= "<div class='btn btn-default weekypicker'
                            data-$values='$counter' data-type='$values'>
                            $value</div>";
                $counter++;
            }

        } else {

            $value = $this->$values;
            for($i = $value['min']; $i <= $value['max']; $i++){

                // Break lines
                if ($i%15 == 0 && $values == 'minutes') $html .= "<br>";
                elseif ($i%12 == 0 && $values == 'hours') $html .= "<br>";
                elseif ($i%16 == 1 && $values == 'days') $html .= "<br>";

                // Set the values
                $html .= "<div class='btn btn-default weekypicker' data-$values='$i' data-type='$values'>
                            ".str_pad($i,2,'0',STR_PAD_LEFT).
                         "</div>";
            }

        }

        echo $html .= $this->closeHtml();
    }

    /**
     * @return string input html
     */
    private function getImput()
    {
        if ($this->hasModel()) {
            echo Html::activeTextInput($this->model, $this->attribute, $this->options);
        } else {
            echo Html::textInput($this->name, $this->value, $this->options);
        }
    }

    private function openHtml()
    {
        return "<div class='row'>
                    <div class='col-lg-12'>
                            <div class='btn btn-info weekypicker-select'>Selecionar</div>
                    </div>
                    <br><br>
                    <div class='col-lg-12 weekypicker-menu'>";
    }

    private function closeHtml()
    {
        return "<br></div></div>";
    }
}
