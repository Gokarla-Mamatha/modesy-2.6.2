<?php

namespace App\Controllers;

use App\Models\AuthModel;
use App\Models\EmailModel;
use PHPMailer\PHPMailer\Exception;

class AuthController extends BaseController
{

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
    }

    /**
     * Login Post
     */
    public function loginPost()
    {
        $response = ['result' => 0];
        // $turnstile = verifyTurnstile();
        // if (!$turnstile) {
        //     return jsonResponse([
        //         'result' => 0,
        //         'response' => '<div class="alert alert-danger">Captcha verification failed</div>'
        //     ]);
        // }
        if (authCheck()) {
            $response['result'] = 1;
            return jsonResponse($response);
        }
        if (!empty($this->request->getPost('hidden_field'))) {
            $this->session->setFlashdata('error', 'Bot detected');
            return redirect()->back();
        }

        $encryptedPassword = $this->request->getPost('password');
        $decryptedPassword = $this->decryptPassword($encryptedPassword);

        if (!$decryptedPassword) {
            $decryptedPassword = $encryptedPassword;
        }

        $this->request->setGlobal('post', array_merge(
            $this->request->getPost(),
            ['password' => $decryptedPassword]
        ));

        $val = \Config\Services::validation();
        $val->setRule('email', trans("email_address"), 'required|valid_email|max_length[255]');
        $val->setRule('password', trans("password"), 'required|max_length[255]');
        if (!$this->validate(getValRules($val))) {
            return jsonResponse([
                'result' => 0,
                'response' => view('partials/_messages')
            ]);
        }
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $this->request->setGlobal('post', array_merge(
            $this->request->getPost(),
            [
                'email' => $email,
                'password' => $password
            ]
        ));

        if ($this->authModel->login()) {
            $response['result'] = 1;
        } else {
            $response['result'] = 0;
            $response['response'] = view('partials/_messages');
        }

        resetFlashData();
        return jsonResponse($response);
    }
    /**
     * Admin Login
     */
    public function adminLogin()
    {
        if (!authCheck()) {
            return redirect()->to('/');
        }

        if (!hasPermission('admin_panel', user())) {
            return redirect()->to('/');
        }

        return redirect()->to(adminUrl());
    }
    /**
     * Admin Login Post
     */
    public function adminLoginPost()
    {
        $turnstile = verifyTurnstile();
        if (!$turnstile) {
            $this->session->setFlashdata('error', 'Captcha verification failed');
            return redirect()->back()->withInput();
        }

        $encryptedPassword = $this->request->getPost('password');
        $decryptedPassword = $this->decryptPassword($encryptedPassword);

        if (!$decryptedPassword) {
            $decryptedPassword = $encryptedPassword;
        }

        $this->request->setGlobal('post', array_merge(
            $this->request->getPost(),
            ['password' => $decryptedPassword]
        ));

        $val = \Config\Services::validation();
        $val->setRule('email', trans("form_email"), 'required|valid_email|max_length[255]');
        $val->setRule('password', trans("form_password"), 'required|max_length[255]');

        if (!$this->validate($val->getRules())) {
            return redirect()->back()->withInput();
        }

        $authModel = new AuthModel();
        $user = $authModel->getUserByEmail(inputPost('email'));

        if (empty($user) || !hasPermission('admin_panel', $user)) {
            $this->session->setFlashdata('error', 'Unauthorized access');
            return redirect()->back();
        }

        if ($authModel->login()) {
            return redirect()->to(adminUrl());
        }

        return redirect()->back();
    }
    /**
     * Connect with Facebook
     */
    public function connectWithFacebook()
    {
        $state = generateToken();
        $fbUrl = "https://www.facebook.com/v2.10/dialog/oauth?client_id=" . $this->generalSettings->facebook_app_id . "&redirect_uri=" . langBaseUrl() . "facebook-callback&scope=email&state=" . $state;
        $this->session->set('oauth2state', $state);
        $this->session->set('fbLoginReferrer', previous_url());
        return redirect()->to($fbUrl);
    }

    /**
     * Facebook Callback
     */
    public function facebookCallback()
    {
        require_once APPPATH . "ThirdParty/facebook/vendor/autoload.php";
        $provider = new \League\OAuth2\Client\Provider\Facebook([
            'clientId' => $this->generalSettings->facebook_app_id,
            'clientSecret' => $this->generalSettings->facebook_app_secret,
            'redirectUri' => langBaseUrl() . 'facebook-callback',
            'graphApiVersion' => 'v2.10',
        ]);
        if (!isset($_GET['code'])) {
            echo 'Error: Invalid Login';
            exit();
            // Check given state against previously stored one to mitigate CSRF attack
        } elseif (empty($_GET['state']) || ($_GET['state'] !== $this->session->get('oauth2state'))) {
            $this->session->remove('oauth2state');
            echo 'Error: Invalid State';
            exit();
        }
        $token = $provider->getAccessToken('authorization_code', [
            'code' => $_GET['code']
        ]);
        try {
            $user = $provider->getResourceOwner($token);
            $fbUser = new \stdClass();
            $fbUser->id = $user->getId();
            $fbUser->email = $user->getEmail();
            $fbUser->name = $user->getName();
            $fbUser->firstName = $user->getFirstName();
            $fbUser->lastName = $user->getLastName();
            $fbUser->pictureURL = $user->getPictureUrl();
            $model = new AuthModel();
            $model->loginWithSocialProvider('facebook', $fbUser);
            if (!empty($this->session->get('fbLoginReferrer'))) {
                return redirect()->to($this->session->get('fbLoginReferrer'));
            } else {
                return redirect()->to(langBaseUrl());
            }
        } catch (\Exception $e) {
            echo 'Error: Invalid User';
            exit();
        }
    }

    /**
     * Connect with Google
     */
    public function connectWithGoogle()
    {
        $ref = trim(inputGet('ref') ?? '');
        if (!empty($ref)) {
            session()->set('referral_code', $ref);
        }

        require_once APPPATH . 'ThirdParty/google/vendor/autoload.php';

        $provider = new \League\OAuth2\Client\Provider\Google([
            'clientId'     => $this->generalSettings->google_client_id,
            'clientSecret' => $this->generalSettings->google_client_secret,
            'redirectUri'  => base_url('connect-with-google'),
            'scopes'       => ['openid', 'email', 'profile'],
        ]);

        if (!empty($_GET['error'])) {
            session()->remove('oauth2state');
            return redirect()->to(langBaseUrl());
        }

        if (empty($_GET['code'])) {
            $authUrl = $provider->getAuthorizationUrl();
            session()->set('oauth2state', $provider->getState());

            $this->session->set('gLoginReferrer', previous_url());

            return redirect()->to($authUrl);
        }

        if (empty($_GET['state']) || $_GET['state'] !== session()->get('oauth2state')) {
            session()->remove('oauth2state');
            return redirect()->to(langBaseUrl());
        }

        session()->remove('oauth2state');

        try {
            $token = $provider->getAccessToken('authorization_code', [
                'code' => $_GET['code']
            ]);

            $googleUser = $provider->getResourceOwner($token);

            $gUser = new \stdClass();
            $gUser->id        = $googleUser->getId();
            $gUser->email     = $googleUser->getEmail();
            $gUser->name      = $googleUser->getName();
            $gUser->firstName = $googleUser->getFirstName();
            $gUser->lastName  = $googleUser->getLastName();
            $gUser->avatar    = $googleUser->getAvatar();

            $model = new AuthModel();
            $model->loginWithSocialProvider('google', $gUser);

            if (!empty($this->session->get('gLoginReferrer'))) {
                return redirect()->to($this->session->get('gLoginReferrer'));
            }

            return redirect()->to(langBaseUrl());

        } catch (\Exception $e) {
            log_message('error', 'GOOGLE LOGIN ERROR: ' . $e->getMessage());
            return redirect()->to(langBaseUrl());
        }
    }



    /**
     * Connect with VK
     */
    public function connectWithVK()
    {
        require_once APPPATH . "ThirdParty/vkontakte/vendor/autoload.php";
        $provider = new \J4k\OAuth2\Client\Provider\Vkontakte([
            'clientId' => $this->generalSettings->vk_app_id,
            'clientSecret' => $this->generalSettings->vk_secure_key,
            'redirectUri' => base_url('connect-with-vk'),
            'scopes' => ['email'],
        ]);
        // Authorize if needed
        if (PHP_SESSION_NONE === session_status()) session_start();
        $isSessionActive = PHP_SESSION_ACTIVE === session_status();
        $code = !empty($_GET['code']) ? $_GET['code'] : null;
        $state = !empty($_GET['state']) ? $_GET['state'] : null;
        $sessionState = 'oauth2state';
        // No code – get some
        if (!$code) {
            $authUrl = $provider->getAuthorizationUrl();
            if ($isSessionActive) $_SESSION[$sessionState] = $provider->getState();
            $this->session->set('vkLoginReferrer', previous_url());
            return redirect()->to($authUrl);
        } // Anti-CSRF
        elseif ($isSessionActive && (empty($state) || ($state !== $_SESSION[$sessionState]))) {
            unset($_SESSION[$sessionState]);
            throw new \RuntimeException('Invalid state');
        } else {
            try {
                $providerAccessToken = $provider->getAccessToken('authorization_code', ['code' => $code]);
                $user = $providerAccessToken->getValues();
                //get user details with cURL
                $url = 'http://api.vk.com/method/users.get?uids=' . $providerAccessToken->getValues()['user_id'] . '&access_token=' . $providerAccessToken->getToken() . '&v=5.95&fields=photo_200,status';
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
                $response = curl_exec($ch);
                curl_close($ch);

                $userDetails = json_decode($response);
                $vkUser = new \stdClass();
                $vkUser->id = $providerAccessToken->getValues()['user_id'];
                $vkUser->email = $providerAccessToken->getValues()['email'];
                $vkUser->name = @$userDetails->response['0']->first_name . " " . @$userDetails->response['0']->last_name;
                $vkUser->firstName = @$userDetails->response['0']->first_name;
                $vkUser->lastName = @$userDetails->response['0']->last_name;
                $vkUser->avatar = @$userDetails->response['0']->photo_200;

                $model = new AuthModel();
                $model->loginWithSocialProvider('vkontakte', $vkUser);
                if (!empty($this->session->get('vkLoginReferrer'))) {
                    return redirect()->to($this->session->get('vkLoginReferrer'));
                } else {
                    return redirect()->to(langBaseUrl());
                }
            } catch (IdentityProviderException $e) {
                error_log($e->getMessage());
            }
        }
    }

    /**
     * Register
     */
    public function register()
    {
        if (authCheck()) {
            return redirect()->to(langBaseUrl());
        }

        $ref = trim(inputGet('ref') ?? '');
        if (!empty($ref)) {
            session()->set('referral_code', $ref);
        }

        $data = setPageMeta(trans("register"));
        $data['userSession'] = getUserSession();
        $data['isTranslatable'] = true;

        echo view('partials/_header', $data);
        echo view('auth/register');
        echo view('partials/_footer');
    }


    /**
     * Register Post
     */
    public function registerPost()
    {
        helper(['security', 'text']);

        if (authCheck()) {
            return redirect()->to(langBaseUrl());
        }

        // Get and sanitize reCAPTCHA token
        $token = trim($this->request->getPost('recaptcha_token'));

        // Validation rules
        $validation = \Config\Services::validation();

        $validation->setRules([
            'email' => [
                'label' => trans("email_address"),
                'rules' => 'required|valid_email|max_length[255]',
                'errors' => [
                    'required'    => 'Email address is required.',
                    'valid_email' => 'Please enter a valid email address.',
                    'max_length'  => 'Email must not exceed 255 characters.'
                ]
            ],
            'password' => [
                'label' => trans("password"),
                'rules' => 'required|min_length[8]|max_length[64]|regex_match[/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[\W]).+$/]'
            ],
            'confirm_password' => [
                'label' => trans("password_confirm"),
                'rules' => 'required|matches[password]'
            ]
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()
                ->to(generateUrl('register'))
                ->withInput()
                ->with('errors', $validation->getErrors());
        }

        $email = strtolower(trim(strip_tags(inputPost('email'))));

        if (!$this->authModel->isEmailUnique($email)) {
            setErrorMessage(trans("msg_email_unique_error"));
            return redirect()->to(generateUrl('register'))->withInput();
        }

        if ($this->authModel->register()) {
            setSuccessMessage(trans("msg_register_success"));
            return redirect()->to(generateUrl('settings', 'edit_profile'));
        }

        setErrorMessage(trans("msg_error"));
        return redirect()->to(generateUrl('register'))->withInput();
    }


    /**
     * Register Success
     */
    public function registerSuccess()
    {
        if (authCheck()) {
            return redirect()->to(langBaseUrl());
        }
        $data['title'] = trans("register");
        $data['description'] = trans("register") . ' - ' . $this->baseVars->appName;
        $data['keywords'] = trans("register") . ',' . $this->baseVars->appName;
        $token = session()->get('register_token');
        $data['user'] = $this->authModel->getUserByToken($token);
        
        if (empty($data['user']) || $data['user']->email_status == 1) {
            return redirect()->to(langBaseUrl());
        }

        echo view('partials/_header', $data);
        echo view('auth/register_success', $data);
        echo view('partials/_footer');
    }

    /**
     * Confirm Account
     */
    public function confirmAccount()
    {
        $data['title'] = trans("confirm_your_account");
        $data['description'] = trans("confirm_your_account") . " - " . $this->baseVars->appName;
        $data['keywords'] = trans("confirm_your_account") . "," . $this->baseVars->appName;

        $token = trim(inputGet('token') ?? '');
        $data['user'] = $this->authModel->getUserByToken($token);
        if (empty($data['user'])) {
            return redirect()->to(langBaseUrl());
        }
        if ($data['user']->email_status == 1) {
            return redirect()->to(langBaseUrl());
        }
        if ($this->authModel->verifyEmail($data['user'])) {
            $data['success'] = trans("msg_confirmed");
        } else {
            $data['error'] = trans("msg_error");
        }

        echo view('partials/_header', $data);
        echo view('auth/confirm_email', $data);
        echo view('partials/_footer');
    }

    /**
     * Forgot Password
     */
    public function forgotPassword()
    {
        if (authCheck()) {
            return redirect()->to(langBaseUrl());
        }

        $data = setPageMeta(trans("forgot_password"));
        $data['isTranslatable'] = true;

        echo view('partials/_header', $data);
        echo view('auth/forgot_password');
        echo view('partials/_footer');
    }

    /**
     * Forgot Password Post
     */
    public function forgotPasswordPost()
    {
        verifyTurnstile();

        if (authCheck()) {
            return redirect()->to(langBaseUrl());
        }

        $session = session();

        $attempts = $session->get('forgot_attempts') ?? 0;
        $lastAttempt = $session->get('forgot_last_attempt');

        if ($attempts >= 5 && (time() - $lastAttempt) < 300) {
            setErrorMessage('Too many requests. Try again after 5 minutes.');
            return redirect()->to(generateUrl('forgot_password'));
        }

        $email = inputPost('email');
        $user = $this->authModel->getUserByEmail($email);

        if (empty($user)) {
            setErrorMessage(trans("msg_reset_password_error"));
            return redirect()->to(generateUrl('forgot_password'));
        }

        $token = $user->token;
        if (empty($token)) {
            $token = generateToken();
            $this->authModel->updateUserToken($user->id, $token);
        }

        $emailData = [
            'email_type' => 'reset_password',
            'email_address' => $user->email,
            'email_data' => serialize([
                'content' => trans("email_reset_password"),
                'url' => generateUrl("reset_password") . '?token=' . $token,
                'buttonText' => trans("reset_password")
            ]),
            'email_priority' => 1,
            'email_subject' => trans("reset_password"),
            'template_path' => 'email/main'
        ];

            addToEmailQueue($emailData);
            $session->set('forgot_attempts', $attempts + 1);
            $session->set('forgot_last_attempt', time());

            setSuccessMessage(trans("msg_reset_password_success"));
            return redirect()->to(generateUrl('forgot_password'));
    }

    /**
     * Reset Password
     */
    public function resetPassword()
    {
        if (authCheck()) {
            return redirect()->to(langBaseUrl());
        }

        $data = setPageMeta(trans("reset_password"));

        $token = inputGet('token');
        $data['user'] = $this->authModel->getUserByToken($token);
        $data['success'] = $this->session->getFlashdata('success');
        if (empty($data['user']) && empty($data['success'])) {
            return redirect()->to(langBaseUrl());
        }

        echo view('partials/_header', $data);
        echo view('auth/reset_password');
        echo view('partials/_footer');
    }

    /**
     * Reset Password Post
     */
    public function resetPasswordPost()
    {
        $success = inputPost('success');
        if ($success == 1) {
            return redirect()->to(langBaseUrl());
        }
        $val = \Config\Services::validation();
        $val->setRule('password', trans("new_password"), 'required|min_length[4]|max_length[255]');
        $val->setRule('password_confirm', trans("password_confirm"), 'required|matches[password]');
        if (!$this->validate(getValRules($val))) {
            $this->session->setFlashdata('errors', $val->getErrors());
            return redirect()->back()->withInput();
        } else {
            $token = inputPost('token');
            $user = $this->authModel->getUserByToken($token);
            if (!empty($user)) {
                if ($this->authModel->resetPassword($user)) {
                    setSuccessMessage(trans("msg_change_password_success"));
                    return redirect()->back();
                }
                setErrorMessage(trans("msg_change_password_error"));
                return redirect()->back()->withInput();
            }
        }
    }

    /**
     * Send Activation Email
     */
    public function sendActivationEmailPost()
    {
        $request = service('request');
        $cache   = \Config\Services::cache();

        $ip    = $request->getIPAddress();
        $token = trim(inputPost('token'));

        if (empty($token)) {
            return jsonResponse([
                'result' => 0,
                'errorMessage' => '<div class="text-danger text-center">Invalid request</div>'
            ]);
        }

        $ipKey   = 'act_ip_' . md5($ip);
        $userKey = 'act_user_' . md5($token);

        $ipData   = $cache->get($ipKey) ?? ['attempts' => 0, 'time' => 0];
        $userData = $cache->get($userKey) ?? ['attempts' => 0, 'time' => 0];

        $currentTime = time();
        $cooldown    = 300;

        if (($currentTime - $ipData['time']) > $cooldown) {
            $ipData = ['attempts' => 0, 'time' => $currentTime];
        }

        if (($currentTime - $userData['time']) > $cooldown) {
            $userData = ['attempts' => 0, 'time' => $currentTime];
        }

        if ($ipData['attempts'] >= 5) {
            return jsonResponse([
                'result' => 0,
                'errorMessage' => '<div class="text-danger text-center">Too many requests from your network. Try after 5 minutes.</div>'
            ]);
        }

        if ($userData['attempts'] >= 3) {
            return jsonResponse([
                'result' => 0,
                'errorMessage' => '<div class="text-danger text-center">Too many attempts for this account. Try after 5 minutes.</div>'
            ]);
        }

        $user = $this->authModel->getUserByToken($token);

        $cache->save($ipKey, [
            'attempts' => $ipData['attempts'] + 1,
            'time' => $currentTime
        ], $cooldown);

        $cache->save($userKey, [
            'attempts' => $userData['attempts'] + 1,
            'time' => $currentTime
        ], $cooldown);

        if (!$user) {
            return jsonResponse([
                'result' => 0,
                'errorMessage' => '<div class="text-danger text-center">Invalid request</div>'
            ]);
        }

        if ((int)$user->email_status === 1) {
            return jsonResponse([
                'result' => 0,
                'errorMessage' => '<div class="text-danger text-center">Email already verified</div>'
            ]);
        }

        $this->authModel->addActivationEmail($user);
        (new \App\Models\EmailModel())->runEmailQueue();

        return jsonResponse([
            'result' => 1,
            'successMessage' => '<div class="text-success text-center">Activation email sent successfully</div>'
        ]);
    }

    /**
     * Join Affiliate Program Post
     */
    public function joinAffiliateProgramPost()
    {
        if (!authCheck()) {
            return redirect()->to(langBaseUrl());
        }
        $this->authModel->joinAffiliateProgram();
        return redirect()->to(generateUrl('affiliate_program'));
    }

    /**
     * Logout
     */
    public function logout()
    {
        $this->authModel->logout();
        redirectToBackUrl();
    }

    public function decryptPassword($encrypted)
    {
        $key = "727038272e80abd99e7d05b9e40cd5ad";

        $data = base64_decode($encrypted);

        if (substr($data, 0, 8) !== "Salted__") {
            return false;
        }

        $salt = substr($data, 8, 8);
        $ciphertext = substr($data, 16);

        $key_iv = $this->evpKDF($key, $salt);

        return openssl_decrypt(
            $ciphertext,
            'aes-256-cbc',
            $key_iv['key'],
            OPENSSL_RAW_DATA,
            $key_iv['iv']
        );
    }

    private function evpKDF($password, $salt)
    {
        $key = '';
        $iv = '';
        $dx = '';

        while (strlen($key . $iv) < 48) {
            $dx = md5($dx . $password . $salt, true);
            $key .= $dx;
        }

        return [
            'key' => substr($key, 0, 32),
            'iv'  => substr($key, 32, 16)
        ];
    }
}
