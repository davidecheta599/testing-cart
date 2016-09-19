<?php

namespace App;

class Cart {
	public $items = null;
	public $totalQty = 0;
	public $totalPrice = 0;

	public function __construct($oldCart)
	/* $oldcart means if this cart already exist in the session...Because
	when you AddToCart it simply means saving it in the session storage
	 * so we wanna know if it already exist in the session then
	new cart as this->items = oldcart
	 */
	{
		if ($oldCart) {
			$this->items = $oldCart->items;
			$this->totalQty = $oldCart->totalQty;
			$this->totalPrice = $oldCart->totalPrice;
		}
	}
	/*so to add a particuler new product to the cart..first we need the qty by initial is zero of that item,
	 * second the price of that product  and lastly the product to add all in a variable calleds $storedItem

	$item here means the product to add */
	public function add($item, $id) {
		$storedItem = ['qty' => '0', 'price' => $item->price, 'item' => $item];
		if ($this->items) {
			if (array_key_exists($id, $this->items)) //checking if the $id wil wanna add alreaddy exit in the $this->items
			{
				$storedItem = $this->items[$id]; //true! then over ride
			}
		} //else
		$storedItem['qty']++;
		$storedItem['price'] = $item->price * $storedItem['qty'];
		$this->items[$id] = $storedItem;
		$this->totalQty++;
		$this->totalPrice += $item->price;
	}

	public function reduceByOne($id) {

		$this->items[$id]['qty']--;
		$this->items[$id]['price'] -= $this->items[$id]['item']['price'];
		$this->totalQty--;
		$this->totalPrice -= $this->items[$id]['item']['price'];

		if ($this->items[$id]['qty'] <= 0) {
			unset($this->items[$id]);
		}
	}

	public function removeitem($id) {

		$this->totalQty -= $this->items[$id]['qty'];
		$this->totalPrice -= $this->items[$id]['price'];
		unset($this->items[$id]);

	}

}
