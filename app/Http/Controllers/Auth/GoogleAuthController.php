<?php


namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Exception;
use App\Models\User;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function redirectToGoogle()      // this function direct go to google
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Create a new controller instance.
     *
     * @return string
     */
    public function handleGoogleCallback()  // this function get user login of google
    {
        try {
            $user = Socialite::driver('google')->user();
            $finduser = User::where('google_id', $user->id)->first();
            if($finduser){
                Auth::login($finduser);
//                return ('login success');
                return redirect('/auth/me');
            }
            else
            {
                $newUser = User::create([
                    'name' => $user->getName(),
                    'email' => $user->getEmail(),
                    'password' => encrypt('123'),
                    'google_id'=> $user->getId()
                ]);

                Auth::login($newUser);
                return redirect('/auth/me');
//                return ('login success');
            }

        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
}
