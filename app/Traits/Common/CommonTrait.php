<?php

namespace App\Traits\Common;
use Illuminate\Http\Request;

trait CommonTrait{
    protected static array $_time_arr = [];
    protected array $_select2_data = [];

    public static function formTimeArr(){
        for($i=0; $i<= 23; $i++){
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
}
