<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Category;

class BlogController extends Controller
{
    protected $limit = 5;
	public function index(){
		$posts = Post::with('author')
				->latestFirst()
				->published()
				->paginate($this->limit);
				
		return view("blog.index", compact('posts'));
	}
	public function category(Category $category){
		$categoryName = $category->title;
		$posts = $category->posts()
						->with('author')
						->latestFirst()
						->published()
						->paginate($this->limit);
				
		return view("blog.index", compact('posts','categoryName'));
	}

	// method show() in the BlogController using model binding
	public function show(Post $post){

		$post->increment('view_count',1);
		return view("blog.show", compact('post'));
	}

	public function author(User $author){
		$authorName = $author->name;

		$posts = $author->posts()
						->with('category')
						->latestFirst()
						->published()
						->paginate($this->limit);
				
		return view("blog.index", compact('posts','authorName'));
	}
}
