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
    public $mes             = ['JAN', 'FEV', 'MAR', 'ABR', 'MAI', 'JUN', 'JUL', 'AGO', 'SET', 'OUT', 'NOV', 'DEZ']; // 1-12
    public $dia_da_semana   = ['SEG', 'TER', 'QUA', 'QUI', 'SEX', 'SAB', 'DOM']; // 1-7
    public $dia_do_mes      = ['min' => 1, 'max' => 31]; // 1-31
    public $hora            = ['min' => 0, 'max' => 23];
    public $minuto          = ['min' => 0, 'max' => 59];

    public function init()
    {

        // Register the assets
        WeekyPicker::register($this->view);
        // Input params
        $this->options['class'] = "weekypicker " . $this->type;
        $this->options['type']  = "hidden";
        $this->options['value'] = "";
        $this->getInput();
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        switch ($this->type){
            case "minuto":        $this->mountData($this->type); break;
            case "hora":          $this->mountData($this->type); break;
            case "dia_do_mes":    $this->mountData($this->type); break;
            case "dia_da_semana": $this->mountData($this->type); break;
            default:              $this->mountData($this->type); break;
        }
    }

    private function mountData($values)
    {
        $html = $this->openHtml();

        // Tipo de array associativo
        if ($values == "dia_da_semana" || $values == "mes") {

//            $html .= "<br>";
            $counter = 1;

            foreach($this->$values as $value){
                $html .= "<div class='btn btn-default weekypicker weekypicker-btn'
                            data-$values='$counter' data-type='$values'>
                            $value</div>";
                $counter++;
            }

        } else {

            $value = $this->$values;
            for($i = $value['min']; $i <= $value['max']; $i++){

                // Break lines
//                if ($i%15 == 0 && $values == 'minuto') $html .= "<br>";
//                elseif ($i%12 == 0 && $values == 'hora') $html .= "<br>";
//                elseif ($i%16 == 1 && $values == 'dia_do_mes') $html .= "<br>";

                // Set the values
                $html .= "<div class='btn btn-default weekypicker weekypicker-btn' data-$values='$i' data-type='$values'>
                            ".str_pad($i,2,'0',STR_PAD_LEFT).
                    "</div>";
            }

        }

        echo $html .= $this->closeHtml();
    }

    /**
     * @return string input html
     */
    private function getInput()
    {
        // Recupera os atributos do modelo
        $modelAttr = $this->model->getAttributes();
        if ($this->hasModel()) {
            // Atribui o valor que esta no modelo para o value do input
            $this->options['value'] = $modelAttr[$this->type];
            echo Html::activeTextInput($this->model, $this->attribute, $this->options);
        } else {
            echo Html::textInput($this->name, $this->value, $this->options);
        }
    }

    private function openHtml()
    {
        return "<div class='row'>
                    <div class='col-lg-12'>
                        <button type='button' class='btn btn-info weekypicker-select'>
                            <span class='glyphicon glyphicon-time' aria-hidden='true'></span> Selecionar
                        </button>
                        <button type='button' class='btn btn-success weekypicker-all' title='Marcar Todos'>
                            <span class='glyphicon glyphicon-check' aria-hidden='true'></span>
                        </button>
                        <button type='button' class='btn btn-danger weekypicker-none' title='Desmarcar Todos'>
                            <span class='glyphicon glyphicon-unchecked' aria-hidden='true'></span>
                        </button>
                    </div><br><br>
                    <div class='col-lg-12 weekypicker-menu'>";
    }

    private function closeHtml()
    {
        return "<br></div></div>";
    }
}
