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
    public $months   = ['J', 'F', 'M', 'M', 'J', 'J', 'A', 'S', 'O', 'N', 'D']; // 1-12
    public $weekDays = ['S', 'T', 'Q', 'Q', 'S', 'S', 'D']; // 1-7
    public $days     = ['min' => 1, 'max' => 31]; // 1-31
    public $hours    = ['min' => 0, 'max' => 23];
    public $minutes  = ['min' => 0, 'max' => 59];

    public function init()
    {
        // Input params
        $this->options['class'] = "weekypicker";
        $this->options['type']  = "hidden";
        $this->options['value'] = "example";
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        // Select the measure type
        switch ($this->type){
            case "minutes":
                break;
            case "hours":
                break;
            case "days":
                break;
            case "weekDays":
//                echo $this->type;
                break;
            default:
                break;
        }



        //$this->registerClientScript();
    }

    private function mountData()
    {
        $html = '<div class="row"><div class="col-lg-12">';
        foreach(eval('$'.$this->type) as $value => $key){

        }
    }

    /**
     * @return string input html
     */
    private function getImput()
    {
        if ($this->hasModel()) {
            return Html::activeTextInput($this->model, $this->attribute, $this->options);
        } else {
            return Html::textInput($this->name, $this->value, $this->options);
        }
    }

    /**
     * Registers tinyMCE js plugin
     */
    protected function registerClientScript()
    {
        $js = [];
        $view = $this->getView();

        TinyMceAsset::register($view);

        $id = $this->options['id'];

        $this->clientOptions['selector'] = "#$id";
        // @codeCoverageIgnoreStart
        if ($this->language !== null) {
            $langFile = "langs/{$this->language}.js";
            $langAssetBundle = TinyMceLangAsset::register($view);
            $langAssetBundle->js[] = $langFile;
            $this->clientOptions['language_url'] = $langAssetBundle->baseUrl . "/{$langFile}";
        }
        // @codeCoverageIgnoreEnd

        $options = Json::encode($this->clientOptions);

        $js[] = "tinymce.init($options);";
        if ($this->triggerSaveOnBeforeValidateForm) {
            $js[] = "$('#{$id}').parents('form').on('beforeValidate', function() { tinymce.triggerSave(); });";
        }
        $view->registerJs(implode("\n", $js));
    }
}
