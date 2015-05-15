<?php
/**
 * @author: he11dog
 * @date:   15.05.15
 */
class WCHP_Helper {

    /**
     * @param $name string
     * @param $data array format [value=>text]
     * @param $selected string|bool
     * @param $class string
     * @param $format string print | export
     * @return string
     */
    public static function dropdown($name , $data, $selected = false , $class = '', $format = 'print')
    {
        $out = '<select name="'.$name.'" class="'.$class.'">';
        foreach($data as $value => $text){
            $active = $selected == $value ? 'selected' : '';
            $out .= '<option value="'.$value.'" '.$active.'>'.$text.'</option>';
        }
        $out .= '</select>';

        return self::get_format($out,$format);

    }

    private static function get_format($out, $format){
        switch($format){
            case 'print':
                echo $out;
                break;
            case 'export':
                return $out;
                break;
        }
    }
}