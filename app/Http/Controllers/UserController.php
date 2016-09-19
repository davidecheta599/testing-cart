<?php

namespace App\Http\Controllers;

use Auth;

class UserController extends Controller {
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct() {
		$this->middleware('auth');
	}

	/**
	 * Show the application dashboard.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function index() {

		$orders = Auth::user()->orders;
		$orders->transform(function ($order, $key) {
			$order->cart = unserialize($order->cart);
			return $order;
		});

		return view('auth.profile', $order);
	}

}
