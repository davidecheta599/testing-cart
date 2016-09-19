<?php

namespace App\Http\Controllers;
use Auth;

class Profile extends Controller {
	public function __construct() {
		$this->middleware('auth');
	}

	public function getProfile() {
		$orders = Auth::user()->orders;
		$orders->transform(function ($order, $key) {
			$order->cart = unserialize($order->cart);
			return $order;
		});

		return view('auth.profile', $order);
	}
}
