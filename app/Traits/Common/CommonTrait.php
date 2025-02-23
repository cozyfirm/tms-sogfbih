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
    public static function formTimeArr(): array{
        for($i=7; $i<= 17; $i++){
            for($j=0; $j<60; $j+=15){
                $time = (($i < 10) ? ('0'.$i) : $i) . ':' . (($j < 10) ? ('0'.$j) : $j);
                self::$_time_arr[$time] = $time;
            }
        }

        return self::$_time_arr;
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

    /* ------------------------------------------ Date time functions ----------------------------------------------- */
    public function date($date): string{
        $this->_date = Carbon::parse($date);

        return $this->_date->format('d') . '. ' . $this->_months_short[((int)$this->_date->format('m')) - 1] . ' ' . $this->_date->format('Y H:i') . 'h';
    }
}
