<?php

namespace App\Controllers;

use App\Models\CartModel;
use App\Models\CheckoutModel;
use App\Models\CouponModel;
use App\Models\EarningsModel;
use App\Models\LocationModel;
use App\Models\ProfileModel;
use App\Models\BusinessModel;

class ProfileController extends BaseController
{
    protected $profileModel;
    protected $earningsModel;
    protected $businessModel;

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->profileModel = new ProfileModel();
        $this->earningsModel = new EarningsModel();
        $this->businessModel = new BusinessModel();
    }

    /**
     * Profile
     */
    public function profile($slug)
    {
        $data['user'] = $this->authModel->getUserBySlug($slug);
        if (empty($data['user'])) {
            return redirect()->to(langBaseUrl());
        }
        $data['isTranslatable'] = true;

        if (isVendor($data['user'])) {
            $data = setPageMeta(getUsername($data['user']), $data);
            $data['showOgTags'] = true;
            $data['ogTitle'] = $data['title'];
            $data['ogDescription'] = $data['description'];
            $data['ogType'] = 'article';
            $data['ogUrl'] = generateProfileUrl($data['user']->slug);
            $data['ogImage'] = getUserAvatar($data['user']->avatar, $data['user']->storage_avatar);
            $data['ogWidth'] = '200';
            $data['ogHeight'] = '200';
            $data['ogCreator'] = $data['title'];
            $data['isProfilePage'] = true;
            $data['profileStats'] = getUserProfileStats($data['user']);

            $data['category'] = null;
            $data['parentCategory'] = null;
            $categoryId = inputGet('p_cat');
            if (!empty($categoryId)) {
                $data['category'] = $this->categoryModel->getCategory($categoryId);
                if (!empty($data['category']) && $data['category']->parent_id != 0) {
                    $data['parentCategory'] = $this->categoryModel->getCategory($data['category']->parent_id);
                }
            }
            $data['categories'] = $this->categoryModel->getSellerCategories($data['user']->id, $categoryId);
            $data['userSession'] = getUserSession();
            $data['coupon'] = null;
            $couponId = null;
            if (!empty(inputGet('v_coupon'))) {
                $coupon = getCouponByCode(inputGet('v_coupon'));
                if (!empty($coupon) && $coupon->seller_id == $data['user']->id) {
                    $data['coupon'] = $coupon;
                    $couponId = $coupon->id;
                }
            }
            $data['activeTab'] = 'products';

            $data['queryParams'] = $this->request->getGet();

            $objParams = (object)[
                'pageNumber' => getValidPageNumber(inputGet('page')),
                'category' => $data['category'],
                'userId' => $data['user']->id,
                'customFilters' => null,
                'arrayParams' => null,
                'couponId' => $couponId,
                'langId' => $this->activeLang->id
            ];

            $data['products'] = $this->productModel->loadProducts($objParams);

            echo view('partials/_header', $data);
            echo view('profile/profile', $data);
            echo view('partials/_footer');
        } else {
            $this->followers($slug);
        }
    }

    /**
     * Followers
     */
    public function followers($slug)
    {
        $data['user'] = $this->authModel->getUserBySlug($slug);
        if (empty($data['user'])) {
            return redirect()->to(langBaseUrl());
        }
        $data = setPageMeta(getUsername($data['user']) . ' - ' . trans("followers"), $data);

        $data['activeTab'] = 'followers';
        $data['followers'] = $this->profileModel->getFollowers($data['user']->id);
        $data['profileStats'] = getUserProfileStats($data['user']);
        $data['isTranslatable'] = true;

        echo view('partials/_header', $data);
        echo view('profile/followers', $data);
        echo view('partials/_footer');
    }

    /**
     * Following
     */
    public function following($slug)
    {
        $data['user'] = $this->authModel->getUserBySlug($slug);
        if (empty($data['user'])) {
            return redirect()->to(langBaseUrl());
        }
        $data = setPageMeta(getUsername($data['user']) . ' - ' . trans("following"), $data);

        $data['activeTab'] = "following";
        $data['followers'] = $this->profileModel->getFollowedUsers($data['user']->id);
        $data['profileStats'] = getUserProfileStats($data['user']);
        $data['isTranslatable'] = true;

        echo view('partials/_header', $data);
        echo view('profile/followers', $data);
        echo view('partials/_footer');
    }

    /**
     * Reviews
     */
    public function reviews($slug)
    {
        if ($this->generalSettings->reviews != 1) {
            return redirect()->to(langBaseUrl());
        }
        $data['user'] = $this->authModel->getUserBySlug($slug);
        if (empty($data['user']) || !isVendor($data['user'])) {
            return redirect()->to(langBaseUrl());
        }

        $data = setPageMeta(getUsername($data['user']) . ' - ' . trans("reviews"), $data);

        $data["activeTab"] = 'reviews';
        $data['userSession'] = getUserSession();
        $numRows = $this->commonModel->getUserReviewsCount($data['user']->id);
        $data['pager'] = paginate($this->baseVars->perPage, $numRows);
        $data['reviews'] = $this->commonModel->getUserReviewsPaginated($data['user']->id, $this->baseVars->perPage, $data['pager']->offset);
        $data['profileStats'] = getUserProfileStats($data['user']);
        $data['isTranslatable'] = true;

        echo view('partials/_header', $data);
        echo view('profile/reviews', $data);
        echo view('partials/_footer');
    }

    /**
     * My Reviews
     */
    public function myReviews($slug)
    {
        if (!authCheck()) {
            return redirect()->to(langBaseUrl());
        }
        if ($this->generalSettings->reviews != 1) {
            return redirect()->to(langBaseUrl());
        }
        $data['user'] = $this->authModel->getUserBySlug($slug);
        if (empty($data['user']) || $data['user']->id != user()->id) {
            return redirect()->to(langBaseUrl());
        }

        $data = setPageMeta(getUsername($data['user']) . ' - ' . trans("my_reviews"), $data);

        $data["activeTab"] = 'my_reviews';
        $data['userSession'] = getUserSession();
        $data['numRows'] = $this->commonModel->getUserReviewsCount(user()->id, true);
        $data['pager'] = paginate($this->baseVars->perPage, $data['numRows']);
        $data['reviews'] = $this->commonModel->getUserReviewsPaginated(user()->id, $this->baseVars->perPage, $data['pager']->offset, true);
        $data['profileStats'] = getUserProfileStats($data['user']);

        echo view('partials/_header', $data);
        echo view('profile/my_reviews', $data);
        echo view('partials/_footer');
    }

    /**
     * Shop Policies
     */
    public function shopPolicies($slug)
    {
        $data['user'] = $this->authModel->getUserBySlug($slug);
        if (empty($data['user'])) {
            return redirect()->to(langBaseUrl());
        }
        $data = setPageMeta(getUsername($data['user']) . ' - ' . trans("my_reviews"), $data);

        $data['activeTab'] = "shop_policies";
        $data['pages'] = $this->pageModel->getVendorPagesByUserId($data['user']->id);
        if (empty($data['pages']) || $data['pages']->status_shop_policies != 1) {
            return redirect()->to(langBaseUrl());
        }

        $data['profileStats'] = getUserProfileStats($data['user']);
        $data['isTranslatable'] = true;

        echo view('partials/_header', $data);
        echo view('profile/shop_policies', $data);
        echo view('partials/_footer');
    }

    /**
     * Wallet
     */
    public function wallet()
    {
        if (!authCheck() || $this->paymentSettings->wallet_status != 1) {
            return redirect()->to(langBaseUrl());
        }

        checkVendorCommissionDept();

        $data = setPageMeta(trans("wallet"));
        $data['activeTab'] = 'earnings';

        $tab = inputGet('tab');
        if ($tab == 'referral-earnings') {
            if ($this->affiliateSettings->status != 1) {
                return redirect()->to(langBaseUrl());
            }
            $data['activeTab'] = 'referral_earnings';
            $data['numRows'] = $this->earningsModel->getReferralEarningsCount(user()->id);
            $data['pager'] = paginate($this->baseVars->perPage, $data['numRows']);
            $data['earnings'] = $this->earningsModel->getReferralEarningsPaginated(user()->id, $this->baseVars->perPage, $data['pager']->offset);
        } elseif ($tab == 'deposits') {
            $data['activeTab'] = 'deposits';
            $data['numRows'] = $this->earningsModel->getDepositsCount(user()->id);
            $data['pager'] = paginate($this->baseVars->perPage, $data['numRows']);
            $data['deposits'] = $this->earningsModel->getPaginatedDeposits($this->baseVars->perPage, $data['pager']->offset, user()->id);
        } elseif ($tab == 'expenses') {
            $data['activeTab'] = 'expenses';
            $data['numRows'] = $this->earningsModel->getExpensesCount(user()->id);
            $data['pager'] = paginate($this->baseVars->perPage, $data['numRows']);
            $data['expenses'] = $this->earningsModel->getExpensesPaginated(user()->id, $this->baseVars->perPage, $data['pager']->offset);
        } elseif ($tab == 'payouts') {
            $data['activeTab'] = 'payouts';
            $data['numRows'] = $this->earningsModel->getPayoutsCount(user()->id);
            $data['pager'] = paginate($this->baseVars->perPage, $data['numRows']);
            $data['payouts'] = $this->earningsModel->getPaginatedPayouts(user()->id, $this->baseVars->perPage, $data['pager']->offset);
        } elseif ($tab == 'set-payout-account') {
            $data['activeTab'] = 'set_payout_account';
            $data['userPayout'] = getUserPayoutInfo(user());
            $data['payoutTab'] = '';
            $payoutOptions = getActivePayoutOptions();
            $payout = inputGet('payout');
            if (!empty($payout) && in_array($payout, $payoutOptions)) {
                $data['payoutTab'] = $payout;
            }
            if (empty($data['payoutTab']) && !empty($payoutOptions) && !empty($payoutOptions[0])) {
                $data['payoutTab'] = $payoutOptions[0];
            }
        } elseif ($tab == 'loyalty-points') {
            $data['activeTab'] = 'loyalty_points';
            $settings = $this->earningsModel->getLoyaltySettings();
            $data['settings'] = $settings;
            $data['loyaltyRequiredPoints'] = (int) ($settings->loyalty_convert_points ?? 0);
            $data['loyaltyConvertAmount']  = (float) ($settings->loyalty_convert_amount ?? 0);
            $data['numRows'] = $this->earningsModel->getEarnedLoyaltyCount(user()->id);
            $data['pager'] = paginate($this->baseVars->perPage, $data['numRows']);
            $data['loyaltyTransactions'] = $this->earningsModel->getEarnedLoyaltyPaginated(user()->id, $this->baseVars->perPage, $data['pager']->offset);
            $data['userLoyaltyPoints'] = $this->earningsModel->getUserLoyaltyPoints(user()->id);
        } elseif ($tab == 'redeem-history') {
            $data['activeTab'] = 'redeem-history';
            $data['numRows'] = $this->earningsModel->getRedeemLoyaltyCount(user()->id);
            $data['pager']   = paginate($this->baseVars->perPage, $data['numRows']);
            $data['loyaltyTransactions'] = $this->earningsModel->getRedeemLoyaltyPaginated(user()->id, $this->baseVars->perPage, $data['pager']->offset);
        } else {
            if (!isVendor()) {
                return redirect()->to(generateUrl('wallet') . '?tab=deposits');
            }
            $data['numRows'] = $this->earningsModel->getEarningsCount(user()->id);
            $data['pager'] = paginate($this->baseVars->perPage, $data['numRows']);
            $data['earnings'] = $this->earningsModel->getEarningsPaginated(user()->id, $this->baseVars->perPage, $data['pager']->offset);
        }

        echo view('partials/_header', $data);
        echo view('wallet/wallet', $data);
        echo view('partials/_footer');
    }

    /**
     * Add Funds Post
     */
    public function addFundsPost()
    {
        if (!authCheck()) {
            return redirect()->to(langBaseUrl());
        }
        if ($this->paymentSettings->wallet_deposit != 1) {
            return redirect()->to(langBaseUrl());
        }
        $amount = numToDecimal(inputPost('amount'));
        if (empty($amount)) {
            setErrorMessage(trans("invalid_attempt"));
            redirectToBackUrl();
        }
        if (!is_numeric($amount)) {
            setErrorMessage(trans("invalid_attempt"));
            redirectToBackUrl();
        }

        if (numToDecimal($this->paymentSettings->wallet_min_deposit) > $amount) {
            setErrorMessage(trans("invalid_attempt"));
            redirectToBackUrl();
        }

        $checkoutModel = new CheckoutModel();
        $checkoutModel->setServicePaymentSession('add_funds', trans("add_funds"), $amount);

        return redirect()->to(generateUrl('cart', 'payment_method'));
    }

    /**
     * New Payout Request Post
     */
    public function newPayoutRequestPost()
    {
        if (!authCheck()) {
            return redirect()->to(langBaseUrl());
        }
        $data = [
            'user_id' => user()->id,
            'payout_method' => inputPost('payout_method'),
            'amount' => numToDecimal(inputPost('amount')),
            'currency' => inputPost('currency'),
            'status' => 0,
            'created_at' => date('Y-m-d H:i:s')
        ];

        $userPayoutInfo = getUserPayoutInfo(user());

        //check active payouts
        $activePayouts = $this->earningsModel->getActivePayouts(user()->id);
        if (!empty($activePayouts)) {
            setErrorMessage(trans("active_payment_request_error"));
            redirectToBackUrl();
        }
        $min = 0;
        if ($data['payout_method'] == 'paypal') {
            //check PayPal email
            if (empty($userPayoutInfo->paypal_email)) {
                setErrorMessage(trans("msg_payout_paypal_error"));
                redirectToBackUrl();
            }
            $min = $this->paymentSettings->min_payout_paypal;
        }
        if ($data['payout_method'] == 'bitcoin') {
            //check bitcoin address
            if (empty($userPayoutInfo->btc_address)) {
                setErrorMessage(trans("msg_payout_bitcoin_address_error"));
                redirectToBackUrl();
            }
            $min = $this->paymentSettings->min_payout_bitcoin;
        }
        if ($data['payout_method'] == 'iban') {
            $min = $this->paymentSettings->min_payout_iban;
        }
        if ($data['payout_method'] == 'swift') {
            $min = $this->paymentSettings->min_payout_swift;
        }
        if ($data['amount'] <= 0) {
            setErrorMessage(trans("msg_error"));
            redirectToBackUrl();
        }
        if ($data['amount'] < $min) {
            setErrorMessage(trans("invalid_withdrawal_amount"));
            redirectToBackUrl();
        }
        if ($data['amount'] > user()->balance) {
            setErrorMessage(trans("invalid_withdrawal_amount"));
            redirectToBackUrl();
        }
        if ($this->earningsModel->withdrawMoney($data)) {
            setSuccessMessage(trans("msg_request_sent"));
        } else {
            setErrorMessage(trans("msg_error"));
        }
        redirectToBackUrl();
    }

    /**
     * Set Payout Account Post
     */
    public function setPayoutAccountPost()
    {
        if (!authCheck()) {
            return redirect()->to(langBaseUrl());
        }
        $submit = inputPost('submit');
        if ($this->earningsModel->setPayoutAccount(user()->id, $submit)) {
            setSuccessMessage(trans("msg_updated"));
        } else {
            setErrorMessage(trans("msg_error"));
        }
        return redirect()->to(generateUrl('wallet') . '?tab=set-payout-account&payout=' . strSlug($submit));
    }

    /**
     * My Coupons
     */
    public function myCoupons()
    {
        if (!authCheck()) {
            return redirect()->to(langBaseUrl());
        }

        $data = setPageMeta(trans("my_coupons"));

        $model = new CouponModel();
        $data['numRows'] = $model->getCouponsCount(true);
        $data['pager'] = paginate(24, $data['numRows']);
        $data['coupons'] = $model->getCouponsPaginated(24, $data['pager']->offset, true);

        echo view('partials/_header', $data);
        echo view('profile/my_coupons', $data);
        echo view('partials/_footer');
    }

    /**
     * Update Profile
     */
    public function editProfile()
    {
        if (!authCheck()) {
            return redirect()->to(langBaseUrl());
        }

        $data = setPageMeta(trans("update_profile"));
        $data["activeTab"] = 'edit_profile';
        $data['userSession'] = getUserSession();

        echo view('partials/_header', $data);
        echo view('settings/edit_profile', $data);
        echo view('partials/_footer');
    }

    /**
     * Update Profile Post
     */
    public function editProfilePost()
    {
        if (!authCheck()) {
            return redirect()->to(langBaseUrl());
        }

        $val = \Config\Services::validation();

        $val->setRule('email', 'Email', 'required|valid_email|max_length[255]');
        $val->setRule('slug', 'Slug', 'required|alpha_dash|max_length[255]');
        $val->setRule('first_name', 'First Name', 'required|alpha_space|max_length[50]');
        $val->setRule('last_name', 'Last Name', 'required|alpha_space|max_length[50]');
        $val->setRule('phone_number', 'Phone', 'permit_empty|regex_match[/^[0-9]{10,15}$/]');
        $val->setRule('tax_registration_number', 'Tax', 'permit_empty|alpha_numeric|max_length[50]');
        $val->setRule('cover_image_type', 'Cover Type', 'required|in_list[full_width,boxed]');
        $val->setRule('send_email_new_message', 'Email Notify', 'permit_empty|in_list[0,1]');
        $val->setRule('show_email', 'Show Email', 'permit_empty|in_list[0,1]');
        $val->setRule('show_phone', 'Show Phone', 'permit_empty|in_list[0,1]');

        if (!$this->validate($val->getRules())) {
            $this->session->setFlashdata('errors', $val->getErrors());
            return redirect()->back()->withInput();
        }

        $data = [
            'slug' => esc(strSlug(inputPost('slug'))),
            'email' => esc(inputPost('email')),
            'first_name' => esc(trim(inputPost('first_name'))),
            'last_name' => esc(trim(inputPost('last_name'))),
            'phone_number' => esc(inputPost('phone_number')),
            'tax_registration_number' => esc(inputPost('tax_registration_number')),
            'send_email_new_message' => (int) inputPost('send_email_new_message'),
            'cover_image_type' => esc(inputPost('cover_image_type')),
            'show_email' => (int) inputPost('show_email'),
            'show_phone' => (int) inputPost('show_phone')
        ];

        $file = $this->request->getFile('file');

        if ($file && $file->isValid() && !$file->hasMoved()) {

            if (!in_array($file->getMimeType(), ['image/jpeg', 'image/png', 'image/webp'])) {
                setErrorMessage('Invalid file type');
                return redirect()->back();
            }

            if ($file->getSize() > 2 * 1024 * 1024) {
                setErrorMessage('File too large');
                return redirect()->back();
            }

            if (!getimagesize($file->getTempName())) {
                setErrorMessage('Invalid image file');
                return redirect()->back();
            }

            $newName = bin2hex(random_bytes(16)) . '.' . $file->getExtension();
            $file->move(FCPATH . 'uploads/profile/', $newName);

            $data['avatar'] = 'uploads/profile/' . $newName;
        }

        $avatar = inputPost('avatar');
        if (!empty($avatar) && preg_match('/^uploads\/avatars\/[a-zA-Z0-9_\-\.]+$/', $avatar)) {
            $data['avatar'] = $avatar;
        }

        if (!$this->authModel->isEmailUnique($data['email'], user()->id)) {
            setErrorMessage('Email already exists');
            return redirect()->back();
        }

        if (!$this->authModel->isSlugUnique($data['slug'], user()->id)) {
            setErrorMessage('Slug already exists');
            return redirect()->back();
        }

        $db = \Config\Database::connect();
        $old_user = $db->table('users')
            ->where('id', user()->id)
            ->get()
            ->getRowArray();

        if ($this->profileModel->editProfile($data, user()->id)) {
            $request = service('request');
            $agent = $request->getUserAgent();

            $updated_fields = [];

            foreach ($data as $key => $value) {
                $old_value = isset($old_user[$key]) ? trim((string)$old_user[$key]) : '';
                $new_value = trim((string)$value);
                if ($old_value != $new_value) {
                    $updated_fields[] = $key;
                }
            }

            $db->table('users')
                ->where('id', user()->id)
                ->update([
                    'profile_updated_at' => date('Y-m-d H:i:s')
                ]);

            $db->table('user_profile_activities')->insert([
                'user_id' => user()->id,
                'updated_fields' => json_encode($updated_fields),
                'ip_address' => $request->getIPAddress(),
                'browser' => $agent->getAgentString(),
                'created_at' => date('Y-m-d H:i:s')
            ]);
            setSuccessMessage('Profile updated successfully');
        } else {
            setErrorMessage('Something went wrong');
        }
        return redirect()->to(generateUrl('settings', 'edit_profile'));
    }

    //delete cover image
    public function deleteCoverImagePost()
    {
        $this->authModel->deleteCoverImage();
        return jsonResponse();
    }

    /**
     * Location
     */
    public function location()
    {
        if (!authCheck()) {
            return redirect()->to(langBaseUrl());
        }

        $data = setPageMeta(trans("location"));
        $data["activeTab"] = 'location';

        $locationModel = new LocationModel();
        if (!empty(user()->country_id)) {
            $data['states'] = $locationModel->getStatesByCountry(user()->country_id);
        }
        if (!empty(user()->state_id)) {
            $data['cities'] = $locationModel->getCitiesByState(user()->state_id);
        }
        $data['userSession'] = getUserSession();
        echo view('partials/_header', $data);
        echo view('settings/location', $data);
        echo view('partials/_footer');
    }

    /**
     * Location Post
     */
    public function locationPost()
    {
        if (!authCheck()) {
            return redirect()->to(langBaseUrl());
        }
        $paramCart = '';
        $paymentType = inputPost('payment_type');
        if (!empty($paymentType)) {
            $paramCart = '?payment_type=' . $paymentType;
        }
        $val = \Config\Services::validation();
        $val->setRule('country_id', trans("country"), 'required');
        if (!$this->validate(getValRules($val))) {
            $this->session->setFlashdata('errors', $val->getErrors());
            return redirect()->to(generateUrl('settings', 'location') . $paramCart)->withInput();
        } else {
            if ($this->profileModel->updateLocation()) {
                setSuccessMessage(trans("msg_updated"));
            } else {
                setErrorMessage(trans("msg_error"));
            }
        }
        if (!empty($paymentType)) {
            if ($paymentType == 'sale' || $paymentType == 'service') {
                $cartModel = new CartModel();
                $cartModel->setCartCustomerLocation();
                return redirect()->to(generateUrl('cart', 'payment_method') . '?payment_type=' . $paymentType);
            }
        }
        return redirect()->to(generateUrl('settings', 'location'));
    }

    /**
     * Shipping Address
     */
    public function shippingAddress()
    {
        if (!authCheck()) {
            return redirect()->to(langBaseUrl());
        }

        $data = setPageMeta(trans("shipping_address"));

        $data["activeTab"] = 'shipping_address';
        $data['shippingAddresses'] = $this->profileModel->getShippingAddresses(user()->id);
        $data['states'] = $this->locationModel->getStatesByCountry(1);
        $data['userSession'] = getUserSession();

        echo view('partials/_header', $data);
        echo view('settings/shipping_address', $data);
        echo view('partials/_footer');
    }

    /**
     * Add Shipping Address Post
     */
    public function addShippingAddressPost()
    {
        if (!authCheck()) {
            return redirect()->to(langBaseUrl());
        }
        if (!$this->profileModel->addShippingAddress()) {
            setErrorMessage(trans("msg_error"));
        }
        redirectToBackUrl();
    }

    public function csrfToken()
    {
        return $this->response->setJSON([
            'name' => csrf_token(),
            'hash' => csrf_hash()
        ]);
    }

    /**
     * Edit Shipping Address Post
     */
    public function editShippingAddressPost()
    {
        if (!authCheck()) {
            return redirect()->to(langBaseUrl());
        }
        if ($this->profileModel->editShippingAddress()) {
            setSuccessMessage(trans("msg_updated"));
        } else {
            setErrorMessage(trans("msg_error"));
        }
        redirectToBackUrl();
    }

    /**
     * Delete Shipping Address Post
     */
    public function deleteShippingAddressPost()
    {
        if (!authCheck()) {
            exit();
        }
        if ($this->profileModel->deleteShippingAddress()) {
            setSuccessMessage(trans("msg_deleted"));
        } else {
            setErrorMessage(trans("msg_error"));
        }
        return jsonResponse();
    }

    /**
     * Affiliate Links
     */
    public function affiliateLinks()
    {
        if (!authCheck()) {
            return redirect()->to(langBaseUrl());
        }
        if (user()->is_affiliate != 1) {
            return redirect()->to(langBaseUrl());
        }

        $data = setPageMeta(trans("affiliate_links"));
        $data['activeTab'] = 'affiliate_links';

        $numRows = $this->commonModel->getUserAffiliateLinksCount(user()->id);
        $data['pager'] = paginate($this->baseVars->perPage, $numRows);
        $data['links'] = $this->commonModel->getUserAffiliateLinksPaginated(user()->id, $this->baseVars->perPage, $data['pager']->offset);

        echo view('partials/_header', $data);
        echo view('settings/affiliate_links', $data);
        echo view('partials/_footer');
    }

    /**
     * Delete Affiliate Link
     */
    public function deleteAffiliateLinkPost()
    {
        $id = inputPost('link_id');
        if ($this->commonModel->deleteAffiliateLink($id)) {
            setSuccessMessage(trans("msg_deleted"));
        } else {
            setErrorMessage(trans("msg_error"));
        }
        return jsonResponse();
    }

    public function businessDetails()
    {
        if (!authCheck()) {
            return redirect()->to(langBaseUrl());
        }
        $data = setPageMeta(trans("business_details"));
        $data['activeTab'] = 'business_details';
        $data['userSession'] = getUserSession();

        $data['countries'] = $this->locationModel->getActiveCountries();
        $data['business_details'] = $this->businessModel->getBusinessDetails(user()->id);
        echo view('partials/_header', $data);
        echo view('settings/business_details', $data);
        echo view('partials/_footer');
    }

    public function businessDetailsPost()
    {
        if (!authCheck()) {
            return redirect()->to(langBaseUrl());
        }

        log_message('info', '=== BUSINESS DETAILS UPDATE START ===');

        $post = $this->request->getPost();

        // 🔍 Log POST data
        log_message('info', 'POST DATA: ' . json_encode($post));

        // 🔹 Prepare data
        $data = [

            // PERSONAL
            'legal_first_name' => $post['legal_first_name'] ?? null,
            'legal_middle_name' => $post['legal_middle_name'] ?? null,
            'legal_last_name' => $post['legal_last_name'] ?? null,
            'nationality' => $post['nationality'] ?? null,
            'address_line1' => $post['address_line1'] ?? null,
            'address_line2' => $post['address_line2'] ?? null,
            'city' => $post['city'] ?? null,
            'state' => $post['state'] ?? null,
            'zip' => $post['zip'] ?? null,
            'contact_phone' => $post['contact_phone'] ?? null,

            // BUSINESS
            'legal_business_name' => $post['legal_business_name'] ?? null,
            'business_address_line1' => $post['business_address_line1'] ?? null,
            'business_address_line2' => $post['business_address_line2'] ?? null,
            'business_city' => $post['business_city'] ?? null,
            'business_state' => $post['business_state'] ?? null,
            'business_zip' => $post['business_zip'] ?? null,
            'doing_business_as' => $post['doing_business_as'] ?? null,
            'ein_registered' => $post['ein_registered'] ?? null,
       
            // BANK
            'account_number' => $post['account_number'] ?? null,
            'ifsc_code' => $post['ifsc_code'] ?? null,

            // PRIMARY
            'primary_first_name' => $post['primary_first_name'] ?? null,
            'primary_middle_name' => $post['primary_middle_name'] ?? null,
            'primary_last_name' => $post['primary_last_name'] ?? null,
            'primary_dob' => $post['primary_dob'] ?? null,
            'primary_nationality' => $post['primary_nationality'] ?? null,
            'ssn_last4' => $post['ssn_last4'] ?? null,
            'contact_address1' => $post['contact_address1'] ?? null,
            'contact_address2' => $post['contact_address2'] ?? null,
            'contact_city' => $post['contact_city'] ?? null,
            'contact_state' => $post['contact_state'] ?? null,
            'contact_zip' => $post['contact_zip'] ?? null,
        ];

        // JSON fields
        $data['roles'] = json_encode($post['roles'] ?? []);
        $data['stakeholders'] = json_encode($post['stakeholders'] ?? []);

        // 🔍 Log prepared data
        log_message('info', 'UPDATE DATA: ' . json_encode($data));

        // 🔹 Get existing record
        $existing = $this->businessModel
            ->where('user_id', user()->id)
            ->first();

        log_message('info', 'EXISTING DATA: ' . json_encode($existing));

        if (!$existing) {
            log_message('error', 'No existing record found for user_id: ' . user()->id);
            return redirect()->back()->with('error', 'Business details not found.');
        }

        // 🔥 Try update
        $result = $this->businessModel->update($existing['id'], $data);

        if (!$result) {
            // ❌ Update failed
            log_message('error', 'UPDATE FAILED');
            log_message('error', 'DB ERRORS: ' . json_encode($this->businessModel->errors()));
        } else {
            log_message('info', 'UPDATE SUCCESS for ID: ' . $existing['id']);
        }

        log_message('info', '=== BUSINESS DETAILS UPDATE END ===');

        return redirect()->back()->with('success', 'Updated successfully');
    }

    /**
     * Social Media
     */
    public function socialMedia()
    {
        if (!authCheck()) {
            return redirect()->to(langBaseUrl());
        }

        $data = setPageMeta(trans("social_media"));
        $data['activeTab'] = 'social_media';
        $data['userSession'] = getUserSession();

        echo view('partials/_header', $data);
        echo view('settings/social_media', $data);
        echo view('partials/_footer');
    }



    /**
     * Social Media Post
     */
    public function socialMediaPost()
    {
        if (!authCheck()) {
            return redirect()->to(langBaseUrl());
        }
        if ($this->profileModel->updateSocialMedia()) {
            setSuccessMessage(trans("msg_updated"));
        } else {
            setErrorMessage(trans("msg_error"));
        }
        return redirect()->to(generateUrl('settings', 'social_media'));
    }

    /**
     * Change Password
     */
    public function changePassword()
    {
        if (!authCheck()) {
            return redirect()->to(langBaseUrl());
        }

        $data = setPageMeta(trans("change_password"));
        $data['activeTab'] = 'change_password';
        $data['userSession'] = getUserSession();

        echo view('partials/_header', $data);
        echo view('settings/change_password', $data);
        echo view('partials/_footer');
    }

    /**
     * Change Password Post
     */
    public function changePasswordPost()
    {
        if (!authCheck()) {
            return redirect()->to(langBaseUrl());
        }
        $val = \Config\Services::validation();
        if (!empty(user()->password)) {
            $val->setRule('old_password', trans("old_password"), 'required|max_length[255]');
        }
        $val->setRule(
            'password',
            trans("password"),
            'required|min_length[8]|max_length[100]|regex_match[/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[\W_]).+$/]'
        );

        $val->setRule('password_confirm', trans("password_confirm"), 'required|matches[password]');

        if (!$this->validate(getValRules($val))) {
            $this->session->setFlashdata('errors', $val->getErrors());
            return redirect()->back()->withInput();
        }
        $user = user();
        $newPassword = inputPost('password');
        if (!empty($user->password) && password_verify($newPassword, $user->password)) {
            setErrorMessage("New password cannot be same as old password");
            return redirect()->back()->withInput();
        }
        if ($this->profileModel->changePassword()) {
            setSuccessMessage(trans("msg_change_password_success"));
        } else {
            setErrorMessage(trans("msg_change_password_error"));
        }
        return redirect()->to(generateUrl('settings', 'change_password'));
    }

    /**
     * Delete Account
     */
    public function deleteAccount()
    {
        if (!authCheck()) {
            return redirect()->to(langBaseUrl());
        }

        $data = setPageMeta(trans("delete_account"));
        $data['activeTab'] = 'delete_account';
        $data['userSession'] = getUserSession();

        echo view('partials/_header', $data);
        echo view('settings/delete_account', $data);
        echo view('partials/_footer');
    }

    /**
     * Delete Account Post
     */
    public function deleteAccountPost()
    {
        if (!authCheck()) {
            return redirect()->to(langBaseUrl());
        }
        $val = \Config\Services::validation();
        $val->setRule('password', trans("password"), 'required|min_length[4]|max_length[100]');
        if (!$this->validate(getValRules($val))) {
            $this->session->setFlashdata('errors', $val->getErrors());
            return redirect()->back()->withInput();
        } else {
            if (!password_verify(inputPost('password'), user()->password)) {
                setErrorMessage(trans("wrong_password"));
            } else {
                $this->profileModel->addDeleteAccountRequest(user());
                setSuccessMessage(trans("msg_request_received"));
            }
        }
        return redirect()->to(generateUrl('settings', 'delete_account'));
    }

    /**
     * Follow Unfollow User
     */
    public function followUnfollowUser()
    {
        if (!authCheck()) {
            return redirect()->to(langBaseUrl());
        }
        $this->profileModel->followUnfollowUser();
        redirectToBackUrl();
    }
}
