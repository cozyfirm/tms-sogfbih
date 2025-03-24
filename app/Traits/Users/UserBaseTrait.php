<?php
namespace App\Traits\Users;

use App\Models\User;
use App\Models\Users\Notification;
use App\Models\Users\SystemAccess;
use App\Traits\Mqtt\MqttTrait;
use Illuminate\Support\Facades\Log;

trait UserBaseTrait{
    use MqttTrait;

    /**
     * Check for users with same username
     *
     * @param $username
     * @return string
     */
    protected function usersByUsername($username) : string{
        try{
            $total = User::where('username', '=', $username)->count();
            if($total == 0) return '';
            else return $total;
        }catch (\Exception $e){ return ''; }
    }

    /**
     * Get all admins from system
     * @return mixed
     */
    public function getAdmins(): mixed{
        /* ToDO :: Check for moderators */
        return User::where('role', '=', 'admin')->get();
    }

    /**
     * Generate slug for username
     *
     * @param $slug
     * @return string
     */
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

    /**
     * Create notification for specific user with all provided data
     *
     * @param $user_id
     * @param $type
     * @param $from
     * @param $text
     * @param $description
     * @param $uri
     * @return void
     */
    public function createNotification($user, $type, $from, $text, $description, $uri): void{
        try{
            $notification = Notification::create([
                'user_id' =>  $user->id,
                'type' => $type,
                'from' => $from,
                'text' => $text,
                'description' => $description,
                'uri' => $uri
            ]);

            /**
             *  Update total number of notifications; Increment for one
             */
            $user->update(['notifications' => ($user->notifications + 1)]);

            /**
             * ToDo:
             *  Create push notification for user
             */
        }catch (\Exception $e){
            Log::info("Greška prilikom kreiranja obavijesti");
        }
    }

    public function logAction($user, $action, $description): void{
        try{
            $access = SystemAccess::create([
                'user_id' => $user->id,
                'action' => $action,
                'description' => $description,
                'ip_address' => $_SERVER['REMOTE_ADDR']
            ]);

            /**
             *  Broadcast over MQTT
             */
            try{
                foreach ($this->getAdmins() as $admin) {
                    $this->publishMessage('system-access', $admin->api_token, '0000', [
                        'action' => $action,
                        'description' => $description,
                        'date' => $access->dateTime()
                    ]);
                }
            }catch (\Exception $e){
                Log::info("UserBaseTrait::logAction() Error while broadcasting action");
            }
        }catch (\Exception $e){
            Log::info("UserBaseTrait::logAction() Error while logging action");
        }
    }
}
