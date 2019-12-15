<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Auth\authenticated;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Socialite;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */
    /*=============================================================================
    =            Login using username, password and active status user            =
    =============================================================================*/
    
    protected function credentials(Request $request)
    {
        //return $request->only($this->username(), 'password');
        return ['email' => $request->{$this->username()}, 'password' => $request->password, 'status' => 'active'];
    }
    
    /*=====  End of Login using username, password and active status user  ======*/
    
    

    use AuthenticatesUsers {
    logout as performLogout;
    }

        public function authenticated(Request $request, $user) {
            activity()
            ->causedBy(auth()->user())
            ->log('Login successfully'); 
}

    /**
     * Where to redirect users after login.
     *
     * @var string
     */


    protected $redirectTo;

    // $logo = \DB::table('general_settings')->where('id', '1')->value('logo');
    // $loginURL = \DB::table('option_settings')->where('name', 'login-url')->value('option');
    // define('LOGINURL', '/');

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $loginURL = \DB::table('option_settings')->where('name', 'login-url')->value('option');
        $this->redirectTo = $loginURL;
        $this->middleware('guest')->except('logout');
    }




    public function logout(Request $request)
    {
        activity()
        ->causedBy(auth()->user())
        ->log('Logout successfully');
        $this->performLogout($request);

        return redirect()->route('login');
    }

    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback($provider)
    {
        $userSocialite = Socialite::driver($provider)->stateless()->user();

        // search user in users table using socilite email
        $findUser = User::where('email', $userSocialite->getEmail())->first();

        /*----------  Create and login user if not exist  ----------*/
        
        if(!$findUser){
            // New user create
            $user = User::create([ 
                'name' => $userSocialite->getName(),
                'email' => $userSocialite->getEmail(),
            ]);

            Auth::login($user, true); // login user
            activity() // recorded in activities log
                ->causedBy(auth()->user())
                ->log('Login successfully'); 
            return redirect($this->redirectTo); // redirect to after login
        }

        /*----------  Login if exist user  ----------*/
        

        Auth::login($findUser, true); // login user
        activity()  // recorded in activities log
            ->causedBy(auth()->user())
            ->log('Login successfully'); 
        return redirect($this->redirectTo); // redirect to after login
    }
}
