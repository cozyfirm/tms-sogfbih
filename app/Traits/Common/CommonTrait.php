<?php

namespace App\Traits\Common;
use Carbon\Carbon;
use Illuminate\Http\Request;

trait CommonTrait{
    protected static array $_time_arr = [];
    protected array $_select2_data = [];

    /** Days, and months variables */
    protected array $_months_short = ['Jan', 'Feb', 'Mar', 'Apr', 'Maj', 'Jun', 'Jul', 'Aug', 'Sep', 'Okt', 'Nov', 'Dec'];
    protected mixed $_date = null;

    /**
     * Create array of times from 07:00 to 17:46
     *
     * @return array
     */
    public static function formTimeArr($step = 15): array{
        for($i=7; $i<= 17; $i++){
            for($j=0; $j<60; $j+=$step){
                $time = (($i < 10) ? ('0'.$i) : $i) . ':' . (($j < 10) ? ('0'.$j) : $j);
                self::$_time_arr[$time] = $time;
            }
        }

        return self::$_time_arr;
    }

    /**
     * Generate random string of length
     * @param $length
     * @return string
     */
    public function randomString($length): string{
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
        $result = '';
        for ($i = 0; $i < $length; $i++)  $result .= $characters[mt_rand(0, 61)];

        return $result;
    }

    /**
     *  Extract select-2 multiple values and form array of data
     */
    public function extractSelect2($values): array{
        /* Empty array */
        $this->_select2_data = [];

        foreach ($values as $key => $val){
            if(intval($val)){
                $this->_select2_data[] = [
                    'value' => $val,
                    'type' => "valid"
                ];
            }else{
                $this->_select2_data[] = [
                    'value' => $val,
                    'type' => 'unknown'
                ];
            }
        }
        return $this->_select2_data;
    }

    /**
     * Round number to $decimals
     *
     * @param $number
     * @param $decimal
     * @return string
     */
    public function roundNumber($number, $decimal): string{
        return number_format($number, $decimal, '.', '');
    }

    public function generateSlug($string): string{
        $string = str_replace('đ', 'd', $string);
        $string = str_replace('Đ', 'D', $string);
        // $slug = preg_replace("/[^A-Za-z0-9 ]/", '', $slug);
        $string = iconv('UTF-8', 'ISO-8859-1//TRANSLIT', $string);
        $string = iconv('UTF-8', 'ISO-8859-1//IGNORE', $string);
        $string = iconv('UTF-8', 'ISO-8859-1//TRANSLIT//IGNORE', $string);

        $string = str_replace(array('[\', \']'), '', $string);
        $string = preg_replace('/\[.*\]/U', '', $string);
        $string = preg_replace('/&(amp;)?#?[a-z0-9]+;/i', '_', $string);
        $string = htmlentities($string, ENT_COMPAT, 'utf-8');
        $string = preg_replace('/&([a-z])(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig|quot|rsquo);/i', '\\1', $string );
        $string = preg_replace(array('/[^a-z0-9]/i', '/[-]+/') , '_', $string);
        return strtolower(trim($string, '_'));
    }

    /* ------------------------------------------ Date time functions ----------------------------------------------- */
    public function date($date): string{
        $this->_date = Carbon::parse($date);

        return $this->_date->format('d') . '. ' . $this->_months_short[((int)$this->_date->format('m')) - 1] . ' ' . $this->_date->format('Y H:i') . 'h';
    }
    public function onlyDate($date): string{
        $this->_date = Carbon::parse($date);

        return $this->_date->format('d') . '. ' . $this->_months_short[((int)$this->_date->format('m')) - 1] . ' ' . $this->_date->format('Y');
    }
}
