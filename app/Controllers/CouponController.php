<?php
namespace App\Controllers;

class CouponController extends BaseController
{
    public function coupons()
    {
        $categoryId = inputGet('category');
        $category = null;

        // Get category if provided
        if (!empty($categoryId)) {
            $category = $this->categoryModel->getCategory(clrNum($categoryId));
            if (empty($category)) {
                $categoryId = null;
            } else {
                $categoryId = $category->id;
            }
        }

        // Get category data
        $data = $this->categoryModel->getCachedCategoryPageData($this->activeLang->id, $category);

        // Set page meta
        $pageTitle = !empty($category) ? $category->cat_name . ' - ' . trans('coupons') : trans('coupons');
        $data = setPageMeta($pageTitle, $data);
        $data['title'] = $pageTitle;
        $data['categories'] = $this->parentCategories;
        $data['parentCategoriesTree'] = !empty($category) ? $this->categoryModel->getCategoryParentTree($category->id) : null;
        $data['userSession'] = getUserSession();
        $data['isTranslatable'] = true;
        $data['category'] = $category;
        $data['queryParams'] = $this->request->getGet();

        // Pagination
        $perPage = $this->productSettings->pagination_per_page ?? 24;

        // Get products with coupons
        $data['numRows'] = $this->productModel->getProductsWithCouponsCount($categoryId);
        $data['pager'] = paginate($perPage, $data['numRows']);
        $data['products'] = $this->productModel->getProductsWithCoupons($categoryId, $perPage, $data['pager']->offset);

        echo view('partials/_header', $data);
        echo view('coupon/coupons', $data);
        echo view('partials/_footer');
    }
    public function applyCoupon()
    {
        $couponCode = $this->request->getPost('coupon_code');
        $productId = $this->request->getPost('product_id');

        // Validate coupon
        $coupon = $this->couponModel->couponByCode($couponCode);

        if (empty($coupon)) {
            return json_encode([
                'status' => 'error',
                'message' => 'Invalid coupon code.',
                'csrf_token' => csrf_hash(),
            ]);
        }

        // Check if assigned
        if (!$this->couponModel->isCouponAssignedToProduct($coupon->id, $productId)) {
            return json_encode([
                'status' => 'error',
                'message' => 'Coupon is not applicable for this product.',
                'csrf_token' => csrf_hash(),
            ]);
        }

        // Check expiry
        if ($coupon->expiry_date < date('Y-m-d')) {
            return json_encode([
                'status' => 'error',
                'message' => 'This coupon has expired.',
                'csrf_token' => csrf_hash(),
            ]);
        }

        // Get product
        $product = $this->productModel->getProduct($productId);
        if (empty($product)) {
            return json_encode([
                'status' => 'error',
                'message' => 'Product not found.',
                'csrf_token' => csrf_hash(),
            ]);
        }

        $basePrice = !empty($product->price_discounted) && $product->price_discounted > 0 ? $product->price_discounted : $product->price;

        // Calculate final price
        $discountRate = $coupon->discount_rate ?? 0;
        $discountAmount = ($basePrice * $discountRate) / 100;
        $finalPrice = $basePrice - $discountAmount;

        return json_encode([
            'status' => 'success',
            'message' => 'Coupon applied successfully!',
            'discounted_price' => number_format($finalPrice, 2, '.', ''),
            'csrf_token' => csrf_hash(), 
        ]);
    }
}
