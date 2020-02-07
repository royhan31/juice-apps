<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded = [];

    public function category(){
      return $this->belongsTo(Category::class, 'category_id','id');
    }

    public function productCreated(){
      return $this->created_at->diffForHumans();
    }

    public function productUpdated(){
      return $this->updated_at->diffForHumans();
    }

    public function products($p){
      return [
          'id' => $p->id,
          'name' => $p->name,
          'category' => $p->category->name,
          'price' => $p->price,
          'image' => $p->image,
          'description' => $p->description,
      ];
    }

    public function productPaginate($products){
      return $products;
    }

}
