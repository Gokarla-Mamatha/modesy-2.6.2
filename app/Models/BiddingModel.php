<?php namespace App\Models;

class BiddingModel extends BaseModel
{
    protected $builder;

    public function __construct()
    {
        parent::__construct();
        $this->builder = $this->db->table('quote_requests');
    }

    //request quote
    public function requestQuote($product, $quantity, $variantId = null, $extraOptions = [])
    {
        if (empty($quantity)) {
            $quantity = 1;
        }

        $productOptionsModel = new ProductOptionsModel();
        $fileModel = new FileModel();
        $variantHash = null;
        $productOptionsSnapshot = null;

        $productSku = $product->sku;

        if (empty($extraOptions) || !is_array($extraOptions)) {
            $extraOptions = [];
        }

        if (!empty($variantId)) {
            $variant = $productOptionsModel->getVariantById($variantId);
            if (empty($variant) || empty($variant->variant_hash)) {
                return null;
            }
            $variantHash = $variant->variant_hash;
            if (!empty($variant->sku)) {
                $productSku = $variant->sku;
            }
            $productOptionsSnapshot = $productOptionsModel->getVariantSnapshot($variantId, $extraOptions);
        }

        $extraOptionsHash = $productOptionsModel->getCanonicalExtraOptionsJson($extraOptions);

        //set product image
        $imageId = '';
        $productImageData = '';

        $optionsArray = safeJsonDecode($productOptionsSnapshot ?? '');
        if (!empty($optionsArray)) {
            $imageId = $optionsArray->image_id ?? null;
            if (!empty($imageId)) {
                $image = $fileModel->getImage($imageId);
                if (!empty($image)) {
                    $data = [
                        'path' => $image->image_small,
                        'storage' => $image->storage
                    ];
                    $productImageData = safeJsonEncode($data);
                }
            }
        }
        if (empty($imageId) || empty($productImageData)) {
            $image = $fileModel->getProductMainImage($product->id);
            if (!empty($image)) {
                $imageId = $image->id;
                $data = [
                    'path' => $image->image_small,
                    'storage' => $image->storage
                ];
                $productImageData = safeJsonEncode($data);
            }
        }


        $data = [
            'product_id' => $product->id,
            'product_title' => $product->title,
            'product_quantity' => $quantity,
            'seller_id' => $product->user_id,
            'buyer_id' => user()->id,
            'status' => 'new_quote_request',
            'price_offered' => 0,
            'price_currency' => '',
            'product_sku' => $productSku,
            'variant_hash' => $variantHash,
            'extra_options' => !empty($extraOptions) ? safeJsonEncode($extraOptions) : null,
            'extra_options_hash' => $extraOptionsHash ?: null,
            'product_options_snapshot' => !empty($productOptionsSnapshot) ? $productOptionsSnapshot : '',
            'product_options_summary' => formatCartOptionsSummary($productOptionsSnapshot, $this->activeLang->short_form, true),
            'product_image_id' => $imageId,
            'product_image_data' => $productImageData,
            'updated_at' => date('Y-m-d H:i:s'),
            'created_at' => date('Y-m-d H:i:s')
        ];

        if ($this->builder->insert($data)) {
            return $this->db->insertID();
        }
        return false;
    }

    //submit quote
    public function submitQuote($quoteRequest)
    {
        if (!empty($quoteRequest) && user()->id == $quoteRequest->seller_id) {
            $data = [
                'price_offered' => numToDecimal(inputPost('price')),
                'price_currency' => inputPost('currency'),
                'status' => 'pending_quote',
                'updated_at' => date('Y-m-d H:i:s')
            ];

            if (empty($data['price_offered'])) {
                $data['price_offered'] = 0;
            }
            return $this->builder->where('id', $quoteRequest->id)->update($data);
        }
        return false;
    }

    //accept quote
    public function acceptQuote($quoteRequest)
    {
        if (!empty($quoteRequest) && user()->id == $quoteRequest->buyer_id) {
            $data = [
                'status' => 'pending_payment',
                'updated_at' => date('Y-m-d H:i:s')
            ];
            return $this->builder->where('id', $quoteRequest->id)->update($data);
        }
        return false;
    }

    //reject quote
    public function rejectQuote($quoteRequest)
    {
        if (!empty($quoteRequest) && user()->id == $quoteRequest->buyer_id) {
            $data = [
                'status' => 'rejected_quote',
                'updated_at' => date('Y-m-d H:i:s')
            ];
            return $this->builder->where('id', $quoteRequest->id)->update($data);
        }
        return false;
    }

    //get quote request
    public function getQuoteRequest($id)
    {
        return $this->builder->where('id', clrNum($id))->get()->getRow();
    }

    //get quote requests count
    public function getQuoteRequestsCount($userId)
    {
        $this->builder->join('products', 'quote_requests.product_id = products.id');
        if ($this->generalSettings->membership_plans_system == 1) {
            $this->builder->join('users', 'quote_requests.seller_id = users.id AND users.banned = 0 AND users.is_membership_plan_expired = 0');
        }
        return $this->builder->where('products.status', 1)->where('products.is_draft', 0)->where('products.is_deleted', 0)
            ->where("((products.product_type = 'physical' AND products.stock > 0) OR products.product_type = 'digital')")->where('quote_requests.buyer_id', clrNum($userId))
            ->where('quote_requests.is_buyer_deleted', 0)->countAllResults();
    }

    //get paginated quote requests
    public function getQuoteRequestsPaginated($userId, $perPage, $offset)
    {
        $this->builder->select('quote_requests.*')->join('products', 'quote_requests.product_id = products.id');
        if ($this->generalSettings->membership_plans_system == 1) {
            $this->builder->join('users', 'quote_requests.seller_id = users.id AND users.banned = 0 AND users.is_membership_plan_expired = 0');
        }
        return $this->builder->where('products.status', 1)->where('products.is_draft', 0)->where('products.is_deleted', 0)
            ->where("((products.product_type = 'physical' AND products.stock > 0) OR products.product_type = 'digital')")->where('quote_requests.buyer_id', clrNum($userId))
            ->where('quote_requests.is_buyer_deleted', 0)->orderBy('updated_at DESC')->limit($perPage, $offset)->get()->getResult();
    }

    //get vendor quote requests count
    public function getVendorQuoteRequestsCount($userId)
    {
        $this->filterQuoteRequests();
        return $this->builder->join('products', 'quote_requests.product_id = products.id')->where('products.status', 1)->where('products.is_draft', 0)
            ->where('products.is_deleted', 0)->where("((products.product_type = 'physical' AND products.stock > 0) OR products.product_type = 'digital')")
            ->where('quote_requests.seller_id', clrNum($userId))->where('quote_requests.is_seller_deleted', 0)->countAllResults();
    }

    //get vendor paginated quote requests
    public function getVendorQuoteRequestsPaginated($userId, $perPage, $offset)
    {
        $this->filterQuoteRequests();
        return $this->builder->select('quote_requests.*')->join('products', 'quote_requests.product_id = products.id')->where('products.status', 1)->where('products.is_draft', 0)
            ->where('products.is_deleted', 0)->where("((products.product_type = 'physical' AND products.stock > 0) OR products.product_type = 'digital')")
            ->where('quote_requests.seller_id', clrNum($userId))->where('quote_requests.is_seller_deleted', 0)->orderBy('updated_at DESC')
            ->limit($perPage, $offset)->get()->getResult();
    }

    //get new quote requests count
    public function getNewQuoteRequestsCount($userId)
    {
        return $this->builder->join('products', 'quote_requests.product_id = products.id')->where('products.status', 1)->where('products.is_draft', 0)
            ->where('products.is_deleted', 0)->where("((products.product_type = 'physical' AND products.stock > 0) OR products.product_type = 'digital')")
            ->where('quote_requests.seller_id', clrNum($userId))->where('quote_requests.is_seller_deleted', 0)->where('quote_requests.status', 'new_quote_request')->countAllResults();
    }

    //check active quote request
    public function checkActiveQuoteRequest($productId, $buyerId)
    {
        $row = $this->builder->where('product_id', clrNum($productId))->where('buyer_id', clrNum($buyerId))->where('status', 'new_quote_request')->get()->getRow();
        if (!empty($row)) {
            return false;
        }
        return true;
    }

    //delete quote request
    public function deleteQuoteRequest($id)
    {
        $quoteRequest = $this->getQuoteRequest($id);
        if (!empty($quoteRequest)) {
            if (user()->id == $quoteRequest->seller_id || user()->id == $quoteRequest->buyer_id) {
                if (user()->id == $quoteRequest->buyer_id) {
                    $data = [
                        'is_buyer_deleted' => 1,
                        'status' => 'closed',
                        'updated_at' => date('Y-m-d H:i:s')
                    ];
                    if ($quoteRequest->status == 'completed') {
                        $data['status'] = 'completed';
                    }
                    return $this->builder->where('id', $quoteRequest->id)->update($data);
                } elseif (user()->id == $quoteRequest->seller_id) {
                    $data = [
                        'is_seller_deleted' => 1,
                        'status' => 'closed',
                        'updated_at' => date('Y-m-d H:i:s')
                    ];
                    if ($quoteRequest->status == 'completed') {
                        $data['status'] = 'completed';
                    }
                    return $this->builder->where('id', $id)->update($data);
                }
            }
        }
        return false;
    }

    //delete quote if both deleted
    public function deleteQuoteRequestIfBothDeleted($id)
    {
        $quoteRequest = $this->getQuoteRequest($id);
        if (!empty($quoteRequest)) {
            if (user()->id == $quoteRequest->seller_id || user()->id == $quoteRequest->buyer_id) {
                if ($quoteRequest->is_buyer_deleted == 1 && $quoteRequest->is_seller_deleted == 1) {
                    return $this->builder->where('id', $id)->delete();
                }
            }
        }
        return false;
    }

    //set bidding quotes as completed after purchase
    public function setBiddingQuotesAsCompletedAfterPurchase($checkoutItems)
    {
        if (!empty($checkoutItems)) {
            foreach ($checkoutItems as $item) {
                if (!empty($item->quote_request_id)) {
                    $data = [
                        'status' => 'completed',
                        'updated_at' => date('Y-m-d H:i:s')
                    ];
                    $this->builder->where('id', clrNum($item->quote_request_id))->update($data);
                }
            }
        }
    }

    //get admin quote requests count
    public function getQuoteRequestCountAdmin()
    {
        $this->filterQuoteRequests();
        return $this->builder->countAllResults();
    }

    //get admin quote requests
    public function getQuoteRequestsPaginatedAdmin($perPage, $offset)
    {
        $this->filterQuoteRequests();
        return $this->builder->orderBy('created_at DESC')->limit($perPage, $offset)->get()->getResult();
    }

    //filter quote requests
    public function filterQuoteRequests()
    {
        $status = inputGet('status');
        $q = inputGet('q');
        if ($status == 'new_quote_request' || $status == 'pending_quote' || $status == 'pending_payment' || $status == 'rejected_quote' || $status == 'closed' || $status == 'completed') {
            $this->builder->where('quote_requests.status', $status);
        }
        if (!empty($q)) {
            $this->builder->groupStart()->like('quote_requests.product_title', $q)->orLike('quote_requests.id', $q)->groupEnd();
        }
        $this->builder->select('quote_requests.*, 
        (SELECT username FROM users WHERE quote_requests.seller_id = users.id) AS seller_username,
        (SELECT slug FROM users WHERE quote_requests.seller_id = users.id) AS seller_slug,
        (SELECT username FROM users WHERE quote_requests.buyer_id = users.id) AS buyer_username,
        (SELECT slug FROM users WHERE quote_requests.buyer_id = users.id) AS buyer_slug');
    }

    //delete admin quote request
    public function deleteQuoteRequestAdmin($id)
    {
        if (isAdmin()) {
            $quoteRequest = $this->getQuoteRequest($id);
            if (!empty($quoteRequest)) {
                return $this->builder->where('id', $id)->delete();
            }
        }
        return false;
    }
   // Get a single bid with seller information
    public function getBid($id)
    {
        return $this->db->table('bids b')
            ->select('b.*, p.user_id AS seller_id')
            ->join('products p', 'p.id = b.product_id')
            ->where('b.id', clrNum($id))
            ->get()
            ->getRow();
    }

    // Place a bid for a product with validation and notifications
    public function placeBid($productId, $amount)
    {
        $product = getProduct($productId);

        if (empty($product) || $product->listing_type !== 'productbid') {
            return ['success' => false, 'message' => "Invalid product for bidding."];
        }

        if ($product->user_id == user()->id) {
            return ['success' => false, 'message' => "You cannot place a bid on your own product."];
        }

        if ($product->bidding_status !== 'active') {
            return ['success' => false, 'message' => "Bidding is closed for this product."];
        }
        $existingUserBid = $this->db->table('bids')
                ->where('product_id', $productId)
                ->where('bidder_id', user()->id)
                ->where('status', 'active')
                ->get()
                ->getRow();

        if (!empty($existingUserBid)) {
            return [
                'success' => false,
                'message' => trans("already_have_active_request")
            ];
        }
        $highestBid = $this->getHighestBid($productId);

        if ($highestBid && $amount <= $highestBid->bid_amount) {
            return ['success' => false, 'message' => "Your bid must be higher than the current highest bid."];
        }

        if (!empty($highestBid)) {
            $this->db->table('bids')
                ->where('id', $highestBid->id)
                ->update(['status' => 'outbid']);

            $this->sendOutbidEmail($highestBid, $product);
        }

        $this->db->table('bids')->insert([
            'product_id' => $productId,
            'bidder_id'  => user()->id,
            'bid_amount' => $amount,
            'status'     => 'active',
            'created_at' => date('Y-m-d H:i:s')
        ]);
        $bidId = $this->db->insertID();
        return ['success' => true,'bid_id'  => $bidId];
    }

    // Get the highest bid for a product excluding rejected and closed bids
    public function getHighestBid($productId)
    {
        return $this->db->table('bids')
            ->select('id, bidder_id, bid_amount')
            ->where('product_id', $productId)
            ->where('status', 'active')
            ->orderBy('bid_amount', 'DESC')
            ->limit(1)
            ->get()
            ->getRow();
    }

    // Accept the highest bid and close bidding for the product
    public function acceptHighestBid($productId)
    {
        $product = getProduct($productId);

        if (empty($product) || user()->id != $product->user_id) {
            return false;
        }

        $highestBid = $this->getHighestBid($productId);
        if (!$highestBid) {
            return false;
        }

        $this->db->table('products')
            ->where('id', $productId)
            ->update([
                'bidding_status' => 'closed',
                'accepted_bid_id' => $highestBid->id
            ]);

        $this->db->table('bids')
            ->where('id', $highestBid->id)
            ->update(['status' => 'accepted']);

        return true;
    }

    // Get total bid count for admin with optional filters
    public function getBiddingCountAdmin($status = null, $search = null)
    {
        $builder = $this->db->table('bids b')
            ->join('products p', 'p.id = b.product_id')
            ->join('product_details pd', 'pd.product_id = p.id AND pd.lang_id = 1', 'left');

        if (!empty($status)) {
            $builder->where('b.status', $status);
        }

        if (!empty($search)) {
            $builder->like('pd.title', $search);
        }

        return $builder->countAllResults();
    }

    // Get paginated list of all bids for admin
    public function getAdminAllBids($limit, $offset, $status = null, $search = null)
    {
        $builder = $this->db->table('bids b')
            ->select('
                b.id AS id,
                b.product_id,
                b.bidder_id,
                b.bid_amount,
                b.status,
                b.created_at,
                p.user_id AS seller_id,
                p.slug,
                pd.title
            ')
            ->join('products p', 'p.id = b.product_id')
            ->join('product_details pd', 'pd.product_id = p.id AND pd.lang_id = 1', 'left');

        if (!empty($status)) {
            $builder->where('b.status', $status);
        }

        if (!empty($search)) {
            $builder->like('pd.title', $search);
        }

        return $builder
            ->orderBy('b.created_at', 'DESC')
            ->limit($limit, $offset)
            ->get()
            ->getResult();
    }

    // Permanently delete a bid if both seller and bidder marked it deleted
    public function deleteBidIfBothDeleted($id)
    {
        $bid = $this->getBid($id);

        if (!empty($bid)
            && $bid->is_seller_deleted == 1
            && $bid->is_bidder_deleted == 1
        ) {
            return $this->db->table('bids')
                ->where('id', clrNum($id))
                ->delete();
        }

        return false;
    }

    // Get all bids for a specific product
    public function getProductBidsList($productId)
    {
        return $this->db->table('bids')
            ->where('product_id', $productId)
            ->get()
            ->getResult();
    }

    // Delete a bid directly by admin
    public function deleteBiddingAdmin($id)
    {
        if (isAdmin()) {
            return $this->db->table('bids')
                ->where('id', clrNum($id))
                ->delete();
        }
        return false;
    }

    // Get count of new active bid requests for a seller
    public function getNewProductBidRequestsCount($sellerId)
    {
        return $this->db->table('bids b')
            ->select('b.id')
            ->join('products p', 'p.id = b.product_id')
            ->where('p.listing_type', 'productbid')
            ->where('p.user_id', clrNum($sellerId))
            ->where('b.status', 'active')
            ->countAllResults();
    }

    // Get all bids for seller products with optional filters
    public function getSellerProductBids($userId, $status = null, $search = null)
    {
        $builder = $this->db->table('products p')
            ->select('
                p.id AS product_id,
                b.id AS bid_id,
                p.slug,
                pd.title,
                b.bidder_id,
                b.bid_amount,
                b.status,
                b.created_at
            ')
            ->join('bids b', 'b.product_id = p.id')
            ->join('product_details pd', 'pd.product_id = p.id AND pd.lang_id = 1', 'left')
            ->where('p.listing_type', 'productbid')
            ->where('p.user_id', clrNum($userId))
            ->where('b.is_seller_deleted', 0);

        if (!empty($status)) {
            $builder->where('b.status', $status);
        }

        if (!empty($search)) {
            $builder->like('pd.title', $search);
        }

        return $builder
            ->orderBy('b.created_at', 'DESC')
            ->get()
            ->getResult();
    }

    //delete a bid based on whether seller or bidder performed the action
    public function deleteBid($id)
    {
        $bid = $this->getBid($id);

        if (empty($bid)) {
            return false;
        }

        if (user()->id == $bid->seller_id) {
            return $this->db->table('bids')
                ->where('id', clrNum($id))
                ->update([
                    'is_seller_deleted' => 1,
                    'status' => 'rejected'
                ]);
        }

        if (user()->id == $bid->bidder_id) {
            return $this->db->table('bids')
                ->where('id', clrNum($id))
                ->update([
                    'is_bidder_deleted' => 1,
                    'status' => 'closed'
                ]);
        }

        return false;
    }

    // Get total bid count for a buyer
    public function getBiddingCount($userId)
    {
        return $this->db->table('bids b')
            ->join('products p', 'b.product_id = p.id')
            ->where('p.status', 1)
            ->where('p.is_draft', 0)
            ->where('p.is_deleted', 0)
            ->where('p.listing_type', 'productbid')
            ->where('b.bidder_id', clrNum($userId))
            ->countAllResults();
    }

    // Get paginated bid list for a buyer
    public function getBiddingPaginated($buyerId, $limit, $offset)
    {
        return $this->db->table('bids b')
            ->select('
                b.id AS bid_id,
                b.product_id,
                b.bid_amount,
                b.status,
                b.created_at,
                p.slug,
                pd.title
            ')
            ->join('products p', 'b.product_id = p.id')
            ->join(
                'product_details pd',
                'pd.product_id = p.id AND pd.lang_id = 1',
                'left'
            )
            ->where('p.status', 1)
            ->where('p.is_draft', 0)
            ->where('p.is_deleted', 0)
            ->where('p.listing_type', "productbid")
            ->where('b.is_bidder_deleted', 0)
            ->where('b.bidder_id', clrNum($buyerId))
            ->orderBy('b.created_at', 'DESC')
            ->limit($limit, $offset)
            ->get()
            ->getResult();
    }

    // Send email notification when a bidder is outbid
    private function sendOutbidEmail($bid, $product)
    {
        if (empty($bid->bidder_id)) {
            return;
        }

        $user = getUser($bid->bidder_id);
        if (empty($user)) {
            return;
        }

        if ($this->generalSettings->productbid_system != 1) {
            return;
        }

        $emailData = [
            'email_type'    => 'bid',
            'email_address' => $user->email,
            'email_subject' => "You Have Been Outbid",
            'template_path' => 'email/main',
            'email_data'    => serialize([
                'content' =>
                    "You have been outbid on a product."  . "<br><br>" .
                    trans("product") . ": <strong>" . esc($product->title) . "</strong><br>" .
                    trans("message") . ": " ."Another user has placed a higher bid. You can place a higher bid to stay in the bidding.",
                'url' => generateProductUrl($product),
                'buttonText' => trans("Place a Higher Bid")

            ])
        ];

        log_message('error', 'Outbid mail queued for user ID: ' . $user->id);

        addToEmailQueue($emailData);
    }


    // Get the highest active bid amount for a product
    public function getHighestBidByProduct($productId)
    {
        return $this->db->table('bids')
            ->select('MAX(bid_amount) AS highest_bid')
            ->where('product_id', $productId)
            ->where('status', 'active')
            ->get()
            ->getRow();
    }
    // Get the accepted bid for a product
    public function getAcceptedBidByProduct($productId)
    {
        return $this->db->table('bids')
            ->where('product_id', $productId)
            ->where('status', 'accepted')
            ->get()
            ->getRow();
    }
    public function acceptBid($productId)
    {
        $product = $this->db->table('products')
            ->where('id', $productId)
            ->get()
            ->getRow();

        if (empty($product) || $product->bidding_status === 'closed') {
            return false;
        }

        $highestBid = $this->db->table('bids')
            ->where('product_id', $productId)
            ->where('status', 'active')
            ->orderBy('bid_amount', 'DESC')
            ->limit(1)
            ->get()
            ->getRow();

        if (empty($highestBid)) {
            $this->db->table('products')
                ->where('id', $productId)
                ->update(['bidding_status' => 'closed']);

            return false;
        }

        $this->db->table('bids')
            ->where('id', $highestBid->id)
            ->update(['status' => 'accepted']);

        $this->db->table('bids')
            ->where('product_id', $productId)
            ->where('id !=', $highestBid->id)
            ->update(['status' => 'rejected']);

        $this->db->table('products')
            ->where('id', $productId)
            ->update([
                'bidding_status'  => 'closed',
                'accepted_bid_id' => $highestBid->id
            ]);

        return $highestBid;
    }

    //set  bidding product as completed after purchase
    public function setProductBidsAsCompletedAfterPurchase($checkoutItems)
    {
        if (!empty($checkoutItems)) {
            foreach ($checkoutItems as $item) {

                // PRODUCT BID ONLY
                if ($item->listing_type === 'productbid') {

                    $this->db->table('bids')
                        ->where('product_id', (int)$item->product_id)
                        ->where('status', 'accepted')
                        ->update([
                            'status' => 'completed',
                            'updated_at' => date('Y-m-d H:i:s')
                        ]);
                }
            }
        }
    }
    public function autoCloseBiddingIfExpired($productId)
    {
        $product = getProduct($productId);

        if (
            empty($product) ||
            $product->listing_type !== 'productbid' ||
            empty($product->bidding_end_time) ||
            $product->bidding_status === 'closed'
        ) {
            return;
        }
        $end = new \DateTime($product->bidding_end_time);
        $now = new \DateTime('now');
        if ($now < $end) {
            return;
        }
        $this->acceptBid($productId);
    }
}
