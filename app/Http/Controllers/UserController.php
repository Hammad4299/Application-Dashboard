<?php

namespace App\Http\Controllers;

use App\Classes\SessionHelper;
use App\Events\SendConfirmationMail;
use App\Http\Middleware\RedirectIfAuthenticated;
use App\Http\Middleware\RedirectIfNotAuthenticated;
use App\Models\ModelAccessor\PasswordResetAccessor;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\ModelAccessor\UserAccessor;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;


class UserController extends Controller
{
    protected $userAccessor;
    protected $passwordAccessor;

    public function __construct(){
        parent::__construct();
        $this->passwordAccessor = new PasswordResetAccessor();
        $this->userAccessor = new UserAccessor();
        $arr = [
            'loginPage',
            'signup',
            'register',
            'login',
            'showForgotPassword',
            'showResetForm',
            'sendResetEmail',
            'saveResetPassword',
            'confirmUser',
            'showInactiveAccount',
            'resendConfirmationEmail'
        ];
        $this->middleware(RedirectIfAuthenticated::class)->only(
            $arr
        );
        
        $this->middleware(RedirectIfNotAuthenticated::class)->except(
            $arr
        );
    }

    public function loginPage(Request $request){
        return view("user.login");
    }

    public function signup(){
        return view("user.signup");
    }

    public function register(Request $request){
        $accessor = new UserAccessor();
        $response = $accessor->registerUser($request->all());
        if($response->getStatus()){
            Session::flash(SessionHelper::$MESSAGE_LOGIN_PAGE, __('messages.confirmation_email_sent'));
            return redirect()->route('login-page');
        } else{
            return redirect()->route('signup-page')
                ->withErrors($response->errors)
                ->withInput($request->except('password'));
        }
    }

    public static function logoutUser(Request $request){
        Auth::logout();
        $request->session()->flush();
        $request->session()->regenerate();
    }

    public function profile($user_id){
        $user = $this->userAccessor->getUser($user_id,false);
        return view('user.edit-profile', ['user' => $user->data]);
    }

    public function logout(Request $request){
        self::logoutUser($request);
        return redirect()->route('root');
    }

    public static function loginUser(Request $request, $user, $remember = false){
        Auth::login($user, $request->has('remember') || $remember);
        $request->session()->regenerate();
    }

    public function login(Request $request){
        $accessor = new UserAccessor();
        $response = $accessor->getUserByCredential($request->all());

        if($response->getStatus()){
            if($response->data->account_status==User::$STATUS_PENDING) {   //Means unconfirmed user
                Session::put(SessionHelper::$USER_ID_UNCONFIRMED_TEMP, $response->data->id);
                return redirect()->route('users.account-unconfirmed');
            }else{
                UserController::loginUser($request,$response->data);
                return redirect()->intended(route('root'));
            }
        } else {
            return redirect()->route('login-page')
                ->withErrors($response->errors)
                ->withInput($request->except('password'));
        }
    }

    public function saveProfile(Request $request, $user_id){
        $response = $this->userAccessor->saveUserInformation($request->all(), $user_id);
        $response->isApi = false;
        if($response->getStatus()){
            UserController::loginUser($request,$response->data);
            $response->redirectUrl = redirect()->intended(route('root'))->getTargetUrl();
        }
        return response()->json($response);
    }

    public function showForgotPassword(){
        return view('user.send-reset-password-email');
    }

    public function showResetForm($token){
        $resp = $this->passwordAccessor->getFromToken($token);
        if($resp->data!=null){
            return view('user.password-reset', ['data' => $resp->data, 'resp' => $resp]);
        }else{
            session()->flash(SessionHelper::$MESSAGE_LOGIN_PAGE,__('messages.hash_expired'));
            return redirect()->route('login-page');
        }
    }

    public function sendResetEmail(Request $request){
        $email = $request->get('email');
        $resp = $this->passwordAccessor->sendResetLinkEmail($email);
        if($resp->getStatus()){
            Session::flash(SessionHelper::$MESSAGE_LOGIN_PAGE, __('messages.reset_email_sent'));
            return redirect()->route('login-page');
        }else{
            return redirect()->back()->withErrors($resp->errors)->withInput($request->all());
        }
    }

    public function saveResetPassword(Request $request,$token){
        $resp = $this->passwordAccessor->getFromToken($token);
        $resp->isApi = false;
        $email = null;
        if($resp->data!=null)
            $email = $resp->data->email;

        $data = $this->userAccessor->saveResetPassword($request->all(),$email);
        if($data->getStatus()){
            if($data->data==null){
                session()->flash(SessionHelper::$MESSAGE_LOGIN_PAGE, __('messages.hash_expired'));
            }else{
                session()->flash(SessionHelper::$MESSAGE_LOGIN_PAGE, __('messages.password_resetted'));
            }
        }
        $data->isApi = false;
        $data->redirectUrl = route('login-page');
        return response()->json($data);
    }

    public function confirmUser($confirmation_hash){
        $data = $this->userAccessor->updateUserConfirmation($confirmation_hash);
        if($data->getStatus()){
            Session::flash(SessionHelper::$MESSAGE_LOGIN_PAGE, __('messages.account_verified'));
        }else{
            Session::flash(SessionHelper::$MESSAGE_LOGIN_PAGE, __('messages.hash_expired'));
        }

        return redirect()->route('login-page');
    }

    public function showInactiveAccount(){
        $data = $this->userAccessor->getUser(session()->get(SessionHelper::$USER_ID_UNCONFIRMED_TEMP),false);
        return view('user.account-inactive-send-confirmation-email', ['user' => $data->data]);
    }

    public function resendConfirmationEmail(){
        $data = $this->userAccessor->getUser(session()->get(SessionHelper::$USER_ID_UNCONFIRMED_TEMP),false);
        $user = $data->data;
        if($user!=null){
            event(new SendConfirmationMail($user));
            Session::flash(SessionHelper::$MESSAGE_LOGIN_PAGE, __('messages.confirmation_email_sent'));
        }

        return redirect()->route('login-page');
    }
}
