<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Genre;
use App\Models\Country;
use App\Models\Movie;
use App\Models\Episode;
use App\Models\Movie_Genre;
use DB;

class IndexController extends Controller
{
    public function timkiem(){
        if(isset($_GET['search'])){
            $search = $_GET['search'];
            $category = Category::orderBy('id','ASC')->where('status',1)->get();
            $genre = Genre::orderBy('id','ASC')->where('status',1)->get();
            $country = Country::orderBy('id','ASC')->where('status',1)->get();
            $phim_hot_sidebar = Movie::where('phim_hot','1')->where('status','1')->orderBy('update_date', 'DESC')->take('20')->get();
            $phim_hot_trailer = Movie::where('resolution','5')->where('status','1')->orderBy('update_date', 'DESC')->take('10')->get();

            $movie = Movie::where('title','LIKE','%'.$search.'%')->orderBy('update_date', 'DESC')->paginate(10);
            return view('pages.search', compact('category', 'genre', 'country','search','movie','phim_hot_sidebar','phim_hot_trailer'));
        }else{
            return redirect()->to('/');
        }
    }
    public function home(){
        $phim_hot = Movie::where('phim_hot','1')->where('status','1')->orderBy('update_date', 'DESC')->get();
        $phim_hot_sidebar = Movie::where('phim_hot','1')->where('status','1')->orderBy('update_date', 'DESC')->take('20')->get();
        $phim_hot_trailer = Movie::where('resolution','5')->where('status','1')->orderBy('update_date', 'DESC')->take('10')->get();
        $category = Category::orderBy('id','ASC')->where('status',1)->get();
        $genre = Genre::orderBy('id','ASC')->where('status',1)->get();
        $country = Country::orderBy('id','ASC')->where('status',1)->get();
        $category_home = Category::with('movie')->orderBy('id','ASC')->where('status',1)->get();

        return view('pages.home', compact('category', 'genre', 'country','category_home','phim_hot','phim_hot_sidebar','phim_hot_trailer'));
    }
    public function category($slug){
        $category = Category::orderBy('id','ASC')->where('status',1)->get();
        $genre = Genre::orderBy('id','ASC')->where('status',1)->get();
        $country = Country::orderBy('id','ASC')->where('status',1)->get();
        $phim_hot_sidebar = Movie::where('phim_hot','1')->where('status','1')->orderBy('update_date', 'DESC')->take('20')->get();
        $phim_hot_trailer = Movie::where('resolution','5')->where('status','1')->orderBy('update_date', 'DESC')->take('10')->get();
        $cate_slug = Category::where('slug', $slug)->first();
        $movie = Movie::where('category_id',$cate_slug->id)->orderBy('update_date', 'DESC')->paginate(10);
        return view('pages.category', compact('category', 'genre', 'country','cate_slug','movie','phim_hot_sidebar','phim_hot_trailer'));
    }
    public function genre($slug){
        $category = Category::orderBy('id','ASC')->where('status',1)->get();
        $genre = Genre::orderBy('id','ASC')->where('status',1)->get();
        $country = Country::orderBy('id','ASC')->where('status',1)->get();
        $phim_hot_sidebar = Movie::where('phim_hot','1')->where('status','1')->orderBy('update_date', 'DESC')->take('20')->get();
        $phim_hot_trailer = Movie::where('resolution','5')->where('status','1')->orderBy('update_date', 'DESC')->take('10')->get();
        $genre_slug = Genre::where('slug', $slug)->first();
        $movie_genre = Movie_Genre::where('genre_id',$genre_slug->id)->get();
        $many_genre = [];
        foreach($movie_genre as $key => $movi){
            $many_genre[]= $movi->movie_id;
        }

        $movie = Movie::whereIn('id',$many_genre)->orderBy('update_date', 'DESC')->paginate(10);
        return view('pages.genre', compact('category', 'genre', 'country', 'genre_slug','movie','phim_hot_sidebar','phim_hot_trailer'));
    }
    public function country($slug){
        $category = Category::orderBy('id','ASC')->where('status',1)->get();
        $genre = Genre::orderBy('id','ASC')->where('status',1)->get();
        $country = Country::orderBy('id','ASC')->where('status',1)->get();
        $phim_hot_sidebar = Movie::where('phim_hot','1')->where('status','1')->orderBy('update_date', 'DESC')->take('20')->get();
        $phim_hot_trailer = Movie::where('resolution','5')->where('status','1')->orderBy('update_date', 'DESC')->take('10')->get();
        $country_slug = Country:: where('slug', $slug)->first();
        $movie = Movie::where('country_id',$country_slug->id)->orderBy('update_date', 'DESC')->paginate(10);
        return view('pages.country', compact('category', 'genre', 'country', 'country_slug','movie','phim_hot_sidebar','phim_hot_trailer'));
    }
    public function movie($slug){
        $category = Category::orderBy('id','ASC')->where('status',1)->get();
        $genre = Genre::orderBy('id','ASC')->where('status',1)->get();
        $country = Country::orderBy('id','ASC')->where('status',1)->get();
        $movie = Movie::with('category','genre','country','movie_genre')->where('slug',$slug)->where('status',1)->first();
        $phim_hot_sidebar = Movie::where('phim_hot','1')->where('status','1')->orderBy('update_date', 'DESC')->take('20')->get();
        $phim_hot_trailer = Movie::where('resolution','5')->where('status','1')->orderBy('update_date', 'DESC')->take('10')->get();
        // $related = Movie::with('category','genre','country')->where('category_id',$movie->category->id)->orderBy(DB::raw('RAND()'))->whereNotIn('slug',[$slug])->get();
        $related = Movie::where('status',1)->take(4)->orderBy('update_date', 'DESC')->get();
        // $related = Movie::with('category', 'genre', 'country')->where('category_id', $movie->category_id)->where('slug', '!=', $slug)->inRandomOrder()->limit(4)->get();

        return view('pages.movie', compact('category','genre','country','movie','related','phim_hot_sidebar','phim_hot_trailer'));
    }
    public function watch($slug){
        $category = Category::orderBy('id','ASC')->where('status',1)->get();
        $genre = Genre::orderBy('id','ASC')->where('status',1)->get();
        $country = Country::orderBy('id','ASC')->where('status',1)->get();
        $movie = Movie::with('category','genre','country','movie_genre')->where('slug',$slug)->where('status',1)->first();
        $phim_hot_sidebar = Movie::where('phim_hot','1')->where('status','1')->orderBy('update_date', 'DESC')->take('20')->get();
        $phim_hot_trailer = Movie::where('resolution','5')->where('status','1')->orderBy('update_date', 'DESC')->take('10')->get();
        $related = Movie::where('status',1)->take(4)->orderBy('update_date', 'DESC')->get();
        return view('pages.watch', compact('category','genre','country','movie','phim_hot_sidebar','phim_hot_trailer','related'));
    }
    public function episode(){
        return view('pages.episode');
    }
}
