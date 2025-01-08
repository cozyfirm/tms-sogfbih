<?php
namespace App\Traits\Users;

use App\Models\User;

trait UserBaseTrait{
    protected function usersByUsername($username) : string{
        try{
            $total = User::where('username', '=', $username)->count();
            if($total == 0) return '';
            else return $total;
        }catch (\Exception $e){ return ''; }
    }
    public function getSlug($slug): string{
        $slug = str_replace('đ', 'd', $slug);
        $slug = str_replace('Đ', 'D', $slug);
        // $slug = preg_replace("/[^A-Za-z0-9 ]/", '', $slug);
        $slug = iconv('UTF-8', 'ISO-8859-1//TRANSLIT', $slug);
        $slug = iconv('UTF-8', 'ISO-8859-1//IGNORE', $slug);
        $slug = iconv('UTF-8', 'ISO-8859-1//TRANSLIT//IGNORE', $slug);

        $string = str_replace(array('[\', \']'), '', $slug);
        $string = preg_replace('/\[.*\]/U', '', $string);
        $string = preg_replace('/&(amp;)?#?[a-z0-9]+;/i', '-', $string);
        $string = htmlentities($string, ENT_COMPAT, 'utf-8');
        $string = preg_replace('/&([a-z])(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig|quot|rsquo);/i', '\\1', $string );
        $string = preg_replace(array('/[^a-z0-9]/i', '/[-]+/') , '-', $string);
        $string = strtolower(trim($string, '-'));

        return ($string . ($this->usersByUsername($string)));
    }
}
