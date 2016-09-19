<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Order;
use App\Product;
use Auth;
use Illuminate\Http\Request;
use Session;
use Stripe\Charge;
use Stripe\Stripe;

class ProductController extends Controller {
	public function getIndex() {
		$products = Product::all();
		return view('shop.index', compact('products'));
	}

	public function getAddToCart(Request $request, $id) {
		$product = Product::find($id);
		$oldCart = Session::has('cart') ? Session::get('cart') : null;
		$cart = new Cart($oldCart);
		$cart->add($product, $product->id);
		$request->session()->put('cart', $cart);

		return redirect('/');
	}

	public function getReduceByOne(Request $request, $id) {

		$oldCart = Session::has('cart') ? Session::get('cart') : null;
		$cart = new Cart($oldCart);
		$cart->reduceByOne($id);
		if (count($cart->items) > 0) {
			$request->session()->put('cart', $cart);} else {
			Session::forget('cart');
		}
		return redirect()->route('product.shoppingCart');

	}

	public function getRemoveItem(Request $request, $id) {

		$oldCart = Session::has('cart') ? Session::get('cart') : null;
		$cart = new Cart($oldCart);
		$cart->removeitem($id);
		if (count($cart->items) > 0) {
			$request->session()->put('cart', $cart);} else {
			Session::forget('cart');
		}
		return redirect()->route('product.shoppingCart');

	}

	public function getCart() {
		if (!Session::has('cart')) {
			return view('shop.shopping-cart');
		}
		$oldCart = Session::get('cart');
		$cart = new Cart($oldCart);
		return view('shop.shopping-cart', ['products' => $cart->items, 'totalPrice' => $cart->totalPrice]);
	}

	public function getCheckout() {
		if (!Session::has('cart')) {
			return view('shop.shopping-cart'); //you hav no item wil display..else
		}
		$oldCart = Session::get('cart');
		$cart = new Cart($oldCart);
		$total = $cart->totalPrice;
		return view('shop.checkout', compact('total'));
	}

	public function postCheckout(Request $request) {
		if (!Session::has('cart')) {
			return redirect('shopping-cart');
		}
		$oldCart = Session::get('cart');
		$cart = new Cart($oldCart);
		Stripe::setApiKey('sk_test_a3z4ZeGj5kxVBCLIi2TEJSk2');
		try {
			$charge = Charge::create(array(
				"amount" => $cart->totalPrice * 100,
				"currency" => "usd",
				"source" => $request->input('stripeToken'), // obtained with Stripe.js
				"description" => "Test Charge",
			));
			$order = new Order;
			$order->cart = serialize($cart);
			$order->address = $request->address;
			$order->name = $request->name;
			$order->payment_id = $charge->id;

			Auth::user()->orders()->save($order);
		} catch (\Exception $e) {
			return redirect('checkout')->with('error', $e->getMessage());
		}
		Session::forget('cart');
		return redirect('/')->with('success', 'Successfully purchased products!');
	}
	public function getProfile() {

		$orders = Auth::user()->orders;
		$orders->transform(function ($order, $key) {
			$order->cart = unserialize($order->cart);
			return $order;
		});

		return view('auth.profile', ['orders' => $orders]);
	}
}
