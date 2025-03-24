<?php

namespace App\Observers;

use App\Mail\Users\ConfirmEmail;
use App\Mail\Users\Welcome;
use App\Models\User;
use App\Traits\Users\UserBaseTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class UserObserver{
    use UserBaseTrait;

    /**
     * Handle the User "created" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function created(User $user): void {
        if(!isset($user->email_verified_at)){
            /**
             *  User is created by "Register now"
             *  Send email to user when profile is created
             */
            $message = "Confirm email to " . ($user->name);
            try{
                Mail::to($user->email)->send(new ConfirmEmail($user->email, $user->name, $user->api_token));

                $message .= " is successfully sent!";
            }catch (\Exception $e){
                $message .= " was not sent! Error: " . $e->getMessage();
            }
            Log::info($message);

            /**
             *  Create notifications for admins and moderators
             *  Notify them that new profile was created, allow access
             */
            $admins = User::whereIn('role', ['admin', 'moderator'])->get();
            foreach ($admins as $admin) {
                $this->createNotification($admin, 'new_profile', $user->id, ($user->name ?? 'John Doe') . ' je ' . (($user->gender == 1) ? 'kreirao' : 'kreirala') . ' profil. Više informacija', 'Obavijest o kreiranju novog profila', route('system.admin.users.preview', ['username' => $user->username]));
            }
        }

        /**
         *  Create notifications for users (User manual)
         */
        if($user->role == 'user'){
            /* Initial number of notifications */
            $user->notifications = 0;

            $this->createNotification($user, 'user_manual', Auth::user()->id, 'Dobrodošli. Kliknite ovdje za pregled korisničkog uputstva', 'Dobrodošli na TMS SOGFBiH sistem', '/files/instructions/users-manual.pdf');
        }
    }
}
