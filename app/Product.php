<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model {
	protected $fillable = ['imagePath', 'title', 'description', 'price'];

}
/*telling the seeder all the colunms  it should  fill*/