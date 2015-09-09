<?php

/**
 * This is the model class for table "cims_color".
 *
 * The followings are the available columns in table 'cims_color':
 * @property integer $id
 * @property string $name
 * @property string $hex_code
 */
class Common {
    /* bracode */

    public static function getItemBarcode($valueArray) {
        $elementId = $valueArray['itemId'] . "_bcode"; /* the div element id */
        $value = $valueArray['barocde'];
        $type = 'code128'; /* you can set the type dynamically if you want valueArray eg - $valueArray['type'] */
        self::getBarcode(array('elementId' => $elementId, 'value' => $value, 'type' => $type));
        return CHtml::tag('div', array('id' => $elementId));
    }

    /**
     * This function returns the item barcode
     */
    public static function getBarcode($optionsArray) {

        Yii::app()->getController()->widget('ext.barcode.Barcode', $optionsArray);
    }

}
