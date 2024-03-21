<?php

namespace Dsi\Helpers\Iblock\CustomProperties;

class Json {
    public static function GetUserTypeDescription() : array {
        return [
            'PROPERTY_TYPE' => 'S',
            'USER_TYPE' => 'JSON',
            'DESCRIPTION' => 'JSON',
            'GetPropertyFieldHtml' => [__CLASS__, 'GetPropertyFieldHtml'],
            'GetSettingsHTML' => [__CLASS__, 'GetSettingsHTML'],
            "ConvertToDB" => array(__CLASS__, "ConvertToDB"),
        ];
    }

    public static function GetPropertyFieldHtml($arProperty, $value, $strHTMLControlName) : string {
        $data = [];
        if($value['VALUE']) {
            $data = json_decode($value['VALUE'], true);
        }

        if(!$data) {
            $data = ['' => ''];
        }

        $html = '';

        foreach($data as $k => $v) {
            $html .= '<div>';
            $html .= '<input type="text" value="'.$k.'" name="'.$strHTMLControlName["VALUE"].'[k][]">';
            $html .= '<input type="text" value="'.$v.'" name="'.$strHTMLControlName["VALUE"].'[v][]">';
            $html .= '</div>';
        }

        $html .= '<input type="button" value="Добавить" onclick="
            let p = this.parentNode;
            let row = p.querySelector(\'div\');
            let clone = row.cloneNode(true);
            clone.querySelectorAll(\'input\').forEach(function(input){input.value=\'\'})
            p.insertBefore(clone, this);
        ">';

        return $html;
    }

    public static function ConvertToDB($arProperty, $arValue) : array {
        $data = [];
        if(is_array($arValue['VALUE'])) {
            if($arValue['VALUE']) {
                foreach($arValue['VALUE']['k'] as $i => $key) {
                    if(!$key) continue;
                    $value = $arValue['VALUE']['v'][$i];

                    $data[$key] = $value;
                }
            }
        }
        else {
            $data = json_decode($arValue['VALUE'], true);
        }

        $arValue['VALUE'] = json_encode($data);

        return $arValue;
    }
}