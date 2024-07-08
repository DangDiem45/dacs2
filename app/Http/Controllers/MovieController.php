<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\Category;
use App\Models\Genre;
use App\Models\Country;
use App\Models\Movie_Genre;
use Carbon\Carbon;
use Storage;
use Illuminate\Support\Facades\File;
class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
{
    $list = Movie::with('category','movie_genre','country','genre')->orderBy('id','DESC')->get();

    $destinationPath = public_path("json_file");
    if(!is_dir($destinationPath)) {  
        mkdir($destinationPath, 0777, true);
    }
    
    $filePath = $destinationPath . DIRECTORY_SEPARATOR . 'movies.json';
    File::put($filePath, json_encode($list));

    // Kiểm tra đường dẫn file đã tạo
    dd($filePath);

    return view('admincp.movie.index', compact('list'));
}
    // public function update_topview(Request $request){
    //     $data = $request->all();
    //     $movie = Movie::find($data['id_phim']);
    //     $movie->topview = $data['topview'];
    //     $movie->save();
    // }
    // public function filter_topview(Request $request){
    //     $data = $request->all();
    //     $movie = Movie::where('topview',$data['value'])->orderBy('update_date','DESC')->take(20)->get();
    //     $output = '';
    //     foreach($movie as $key => $mov){
    //         if($mov->resolution==0){
    //             $text = 'HD';
    //         }elseif($mov->resolution==1){
    //             $text = 'SD';
    //         }elseif($mov->resolution==2){
    //             $text = 'HDCam';
    //         }else{
    //             $text = 'Cam';
    //         }
    //         $output.= '<div class="item post-37176">
    //                           <a href="'.url('phim/'.$mov->slug).'" title="'.$mov->title.'">
    //                              <div class="item-link">
    //                                 <img src="'.url('uploads/movie/'.$mov->image).'" title="'.$mov->title.'" />
    //                                 <span class="is_trailer">
    //                                     '.$text.'
    //                                 </span>
    //                              </div>
    //                              <p class="title">'.$mov->title.'</p>
    //                           </a>
    //                           <div class="viewsCount" style="color: #9d9d9d;">3.2K lượt xem</div>
    //                           <div style="float: left;">
    //                              <span class="user-rate-image post-large-rate stars-large-vang" style="display: block;/* width: 100%; */">
    //                              <span style="width: 0%"></span>
    //                              </span>
    //                           </div>
    //                        </div>';
    //     }
    //     echo $output;
    // }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category = Category::pluck('title', 'id');
        $genre = Genre::pluck('title', 'id');
        $country = Country::pluck('title','id');
        $list = Movie::with('category','genre','country')->orderBy('id','ASC')->get();
        $list_genre = Genre::all();
        return view('admincp.movie.form', compact('list','category','genre','country','list_genre'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $movie = new Movie();
        $movie->title = $data['title'];
        $movie->episode = $data['episode'];
        $movie->trailer = $data['trailer'];
        $movie->thoi_luong = $data['thoi_luong'];
        $movie->resolution= $data['resolution'];
        $movie->subtitle= $data['subtitle'];
        $movie->name_eng = $data['name_eng'];
        $movie->phim_hot = $data['phim_hot'];
        $movie->slug = $data['slug'];
        $movie->description = $data['description'];
        $movie->status = $data['status'];
        $movie->category_id = $data['category_id'];
        $movie->country_id = $data['country_id'];
        $movie->create_date = Carbon::now('Asia/Ho_Chi_Minh');
        $movie->update_date = Carbon::now('Asia/Ho_Chi_Minh');
        foreach($data['genre'] as $key => $gen){
            $movie->genre_id = $gen[0];
        }

        $get_image = $request->file('image');


        if($get_image){
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.',$get_name_image));
            $new_image = $name_image.rand(0,999).'.'.$get_image->getClientOriginalExtension();
            $get_image->move('uploads/movie/',$new_image);
            $movie->image = $new_image;
        }
        $movie->save();
        $movie->movie_genre()->attach($data['genre']);
        return redirect()->back();

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::pluck('title', 'id');
        $genre = Genre::pluck('title', 'id');
        $country = Country::pluck('title','id');
        $list = Movie::with('category','genre','country')->orderBy('id','ASC')->get();
        $movie = Movie::find($id);
        if(isset($movie->movie_genre)){
            $movie_genre = $movie->movie_genre;
        }
        $list_genre = Genre::all();
        return view('admincp.movie.form', compact('list','category','genre','country','movie','list_genre','movie_genre'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();
        $movie = Movie::find($id);
        $movie->title = $data['title'];
        $movie->episode = $data['episode'];
        $movie->trailer = $data['trailer'];
        $movie->thoi_luong = $data['thoi_luong'];
        $movie->resolution= $data['resolution'];
        $movie->subtitle= $data['subtitle'];
        $movie->name_eng = $data['name_eng'];
        $movie->phim_hot = $data['phim_hot'];
        $movie->slug = $data['slug'];
        $movie->description = $data['description'];
        $movie->status = $data['status'];
        $movie->category_id = $data['category_id'];
        $movie->country_id = $data['country_id'];
        $movie->update_date = Carbon::now('Asia/Ho_Chi_Minh');
        foreach($data['genre'] as $key => $gen){
            $movie->genre_id = $gen[0];
        }

        $get_image = $request->file('image');


        if($get_image){
            if(!empty($movie->image)){
                unlink('uploads/movie/'.$movie->image);
            }
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.',$get_name_image));
            $new_image = $name_image.rand(0,999).'.'.$get_image->getClientOriginalExtension();
            $get_image->move('uploads/movie/',$new_image);
            $movie->image = $new_image;
        }
        $movie->save();
        $movie->movie_genre()->sync($data['genre']);
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $movie = Movie::find($id);
        if(!empty($movie->image)){
            unlink('uploads/movie/'.$movie->image);
        }

        Movie_Genre::whereIn('movie_id',[$movie->id])->delete();
        $movie->delete();
        return redirect()->back();
    }
}
