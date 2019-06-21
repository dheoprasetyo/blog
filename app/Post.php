<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use GrahamCampbell\Markdown\Facades\Markdown;

class Post extends Model
{
	protected $dates = ['published_at'];
	protected $fillable = ['category_id'];
    public function getImageUrlAttribute($value){

    	$imageUrl = "";
    	if(!is_null($this->image)){
    		$imageUrl = $this->image;
    	}else{
    		$imageUrl = "";
    	}

    	return $imageUrl;
    }

    // Every post has author. 
    public function author(){
		return $this->belongsTo(User::class);
	}

	public function posts(){
    	return $this->hasMany(Post::class);
    }

    public function category(){
	    return $this->belongsTo(Category::class);
	}
 
    public function getRouteKeyName(){
    	return 'slug';
    }
	// Change the static date on the home screen using carbon diffForHumans method.
	public function getDateAttribute($value){
		return is_null($this->published_at) ? '' : $this->published_at->diffForHumans();
	}

	// Order by the latest post, create scopelatestFirst()
	public function scopeLatestFirst($query){
		return $query->orderBy('created_at', 'desc');
	}

	public function scopePublished($query){
		return $query->where("published_at", "<=", Carbon::now());
	}

	public function getBodyHtmlAttribute($value){
		return $this->body ? Markdown::convertToHtml(e($this->body)) : NULL ;
	}

	public function getExcerptHtmlAttribute($value){
		return $this->excerpt ? Markdown::convertToHtml(e($this->excerpt)) : NULL ;
	}

	public function scopePopular($query){
	    return $query->orderBy('view_count', 'desc');
	}

	public function getImageThumbUrlAttribute($value){

	    $imageUrl = "";
	    if(!is_null($this->image)){
	        $ext = substr(strrchr($this->image, '.'), 1);
	        $thumbnail = str_replace(".{$ext}", "_thumb.{$ext}", $this->image);
	        $imagePath = public_path() . "/img/" . $thumbnail;
	        if(file_exists($imagePath)) $imageUrl = asset("img/" . $thumbnail);
	        $imageUrl = $this->image;
	    }else{
	        $imageUrl = "";
	    }

	    return $imageUrl;
	}

}
