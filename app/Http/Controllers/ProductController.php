<?php

namespace dress_shop\Http\Controllers;

use Illuminate\Http\Request;

use dress_shop\DataLayer;
use dress_shop\Product;
use dress_shop\Review;

class ProductController extends Controller
{
    private static function productsFilter($category = 'all', $keyword = '') {
        return function($product) use ($category, $keyword) {
            $keyword = trim($keyword);
            $category = $category === null ? 'all' : $category;
            $keyword = $keyword === null ? '' : $keyword;
            if ($category != 'all' && $category != $product->category)
                return false;
            $tocheck = [$product->name, $product->description, $product->category, $product->short_description];
            for ($i = 0; $i < count($tocheck); $i++) {
                if ($keyword == '' || strpos(strtolower($tocheck[$i]), strtolower($keyword)) !== false)
                    return true;
            }
            return false;
        };
    }

    public function getProductList(Request $request)
    {
        $filter = ProductController::productsFilter($request->category, $request->keyword);
        return view('product_list', [
            'products' => DataLayer::getProducts($filter),
        ]);
    }

    public function getProduct($id)
    {
        $product = DataLayer::getProduct($id);
        return view('product', [
            'product' => $product,
            'rating' => $product->getRating(),
            'reviews' => $product->reviews()->orderBy('id', 'desc')->get(),
            'related' => DataLayer::getRelatedProducts($product),
        ]);
    }

    public function getEditProduct($id)
    {
        $product = DataLayer::getProduct($id);
        return view('product_form', [
            'product' => $product,
            'add' => false,
        ]);
    }

    public function postUnlistProduct($id)
    {
        $product = DataLayer::getProduct($id);
        DataLayer::unlistProduct($id);
        return response()->json(['success' => true, 'message' => 'Product ' . $product->name . ' deleted successfully']);
    }

    public function postEditProduct(Request $request, $id)
    {
        $this->checkProductForm($request);
        DataLayer::deleteImageFiles($request->todelete_images);
        $request->new_images_names = DataLayer::saveImageFiles($request->new_images);
        // save the product
        DataLayer::editProduct($request, $id);
        return redirect()->route('product', ['id' => $id])->with('success', 'Product edited succesfully');
    }

    public function checkProductForm(Request $request)
    {
        // check that all the $request->new_images are valid images
        if ($request->new_images != null) {
            foreach ($request->new_images as $image) {
                if (!DataLayer::isValidImage($image)) {
                    return redirect()->route('admin_error', ['messages' => ['Invalid image while adding a product'], 'status' => 415]);
                }
            }
        }

        // if $request->category not in $this->categories
        if (!in_array($request->category, $this->categories)) {
            return redirect()->route('admin_error', ['messages' => ['Invalid category while adding a product'], 'status' => 400]);
        }

        // for each $this->sizes as $size; if $request->{$size} == null
        foreach ($this->sizes as $size) {
            if ($request->{$size} == null) {
                return redirect()->route('admin_error', ['messages' => ['Invalid size while adding a product'], 'status' => 400]);
            }
        }
    }

    public function postAddProduct(Request $request)
    {
        if ($request->todelete_images != null) {
            // there is an error
            return redirect()->route('admin_error', ['messages' => ['Cannot delete images while adding a product'], 'status' => 400]);
        }

        $this->checkProductForm($request);

        $request->new_images_names = DataLayer::saveImageFiles($request->new_images);
        // save the product
        DataLayer::newProduct($request);
        return redirect()->route('product_list')->with('success', 'Product added succesfully');
    }

    public function getAddProduct()
    {
        return view('product_form', [
            'product' => new Product(),
            'add' => true,
        ]);
    }

    public function postAddReview(Request $request, $prodid)
    {
        $user = auth()->user();
        if ($user->hasReviewed($prodid)) {
            return redirect()->route('product', ['id' => $prodid])->with('error', 'You have already reviewed this product');
        }
        if (!$user->hasBought($prodid)) {
            return redirect()->route('product', ['id' => $prodid])->with('error', 'You have to own this product before you can review it');
        }
        $request->product_id = $prodid;
        DataLayer::addReview($request);
        return redirect()->route('product', ['id' => $prodid])->with('success', 'Review added succesfully');
    }

    public function postUpdateReview(Request $request, $prodid)
    {
        $user = auth()->user();
        if (!$user->hasReviewed($prodid)) {
            return redirect()->route('product', ['id' => $prodid])->with('error', 'You have not reviewed this product');
        }
        $request->product_id = $prodid;
        DataLayer::updateReview($request, $user->reviewId($prodid));
        return redirect()->route('product', ['id' => $prodid])->with('success', 'Review updated succesfully');
    }

    public function postDeleteReview($id) {
        // check that review exists
        $review = Review::find($id);
        if ($review == null) {
            return redirect()->route('user_error', ['messages' => ['Review does not exist'], 'status' => 404]);
        }
        $prodid = $review->product_id;
        // check that user is the owner of the review or admin
        $user = auth()->user();
        if ($user->id != $review->user_id && !$user->isAdmin()) {
            return redirect()->route('user_error', ['messages' => ['You are not the owner of this review'], 'status' => 403]);
        }
        DataLayer::deleteReview($id);
        return redirect()->route('product', ['id' => $prodid])->with('success', 'Review deleted succesfully');
    }
}
