@extends('layout')
@section('content')
<div class="row container" id="wrapper">
   <div class="halim-panel-filter">
      <div class="panel-heading">
         <div class="row">
            <div class="col-xs-6">
               <div class="yoast_breadcrumb hidden-xs"><span><span><a href="{{route('category',$movie->category->slug)}}">{{$movie->category->title}}</a> » 
                  <span><a href="{{route('country',$movie->country->slug)}}">{{$movie->country->title}}</a> » 
                  @foreach($movie->movie_genre as $gen)
                     <a href="{{route('genre',$gen->slug)}}">
                        {{$gen->title}}
                     </a> » 
                  @endforeach  
                  <span class="breadcrumb_last" aria-current="page">{{$movie->title}}</span></span></span></span></div>
            </div>
         </div>
      </div>
      <div id="ajax-filter" class="panel-collapse collapse" aria-expanded="true" role="menu">
         <div class="ajax"></div>
      </div>
   </div>
   <main id="main-contents" class="col-xs-12 col-sm-12 col-md-8">
      <section id="content" class="test">
         <div class="clearfix wrap-content">
            <div class="halim-movie-wrapper">
               <div class="title-block">
                  <div id="bookmark" class="bookmark-img-animation primary_ribbon" data-id="38424">
                     <div class="halim-pulse-ring"></div>
                  </div>
                  <div class="title-wrapper" style="font-weight: bold;">
                     Bookmark
                  </div>
               </div>
               <div class="movie_info col-xs-12">
                  <div class="movie-poster col-md-3">
                     <img class="movie-thumb" src="{{asset('uploads/movie/'.$movie->image)}}" alt="{{$movie->title}}">
                     @if($movie->resolution!=5)
                     <div class="bwa-content">
                        <div class="loader"></div>
                        <a href="{{route('watch',$movie->slug)}}" class="bwac-btn">
                        <i class="fa fa-play"></i>
                        </a>
                     </div>
                     @endif
                  </div>
                  <div class="film-poster col-md-9">
                     <h1 class="movie-title title-1" style="display:block;line-height:35px;margin-bottom: -14px;color: #ffed4d;text-transform: uppercase;font-size: 18px;">{{$movie->title}}</h1>
                     <h2 class="movie-title title-2" style="font-size: 12px;">{{$movie->name_eng}}</h2>
                     <ul class="list-info-group">
                        <li class="list-info-group-item"><span>Trạng Thái</span> : 
                        <span class="quality">
                           @if($movie->resolution==0)
                              HD
                           @elseif($movie->resolution==1)
                              SD
                           @elseif($movie->resolution==2)
                              HDCam
                           @elseif($movie->resolution==3)
                              Cam
                           @elseif($movie->resolution==4)
                              FullHD 
                           @else
                              Trailer
                           @endif
                        @if($movie->resolution!=5)
                        </span><span class="episode">
                           @if($movie->subtitle==0)
                              Phụ đề
                           @else
                              Thuyết minh
                           @endif  
                        </span>
                        @endif
                     </li>
                        <li class="list-info-group-item"><span>Thời lượng</span> : 
                           {{$movie->thoi_luong}}
                        </li>
                        <li class="list-info-group-item"><span>Tập phim</span> : 
                           {{$movie->episode}}
                        </li>
                        <li class="list-info-group-item"><span>Thể loại</span> : 
                           
                              @foreach($movie->movie_genre as $gen)
                                 <a href="{{route('genre',$gen->slug)}}" rel="category tag">
                                    {{$gen->title}}
                                 </a>
                              @endforeach   
                           
                        </li>   
                         <li class="list-info-group-item"><span>Danh mục phim</span> : 
                           <a href="{{route('category',$movie->category->slug)}}" rel="category tag">{{$movie->category->title}}</a>
                        </li>  
                        <li class="list-info-group-item"><span>Quốc gia</span> : 
                           <a href="{{route('country',$movie->country->slug)}}" rel="tag">{{$movie->country->title}}</a>
                        </li>
                     </ul>
                     <div class="movie-trailer hidden"></div>
                  </div>
               </div>
            </div>
            <div class="clearfix"></div>
            <div id="halim_trailer"></div>
            <div class="clearfix"></div>
            <div class="section-bar clearfix">
               <h2 class="section-title"><span style="color:#ffed4d">Nội dung phim</span></h2>
            </div>
            <div class="entry-content htmlwrap clearfix">
               <div class="video-item halim-entry-box">
                  <article id="post-38424" class="item-content">
                     {{$movie->description}}
                  </article>
               </div>
            </div>
            <div class="section-bar clearfix">
               <h2 class="section-title"><span style="color:#ffed4d">Trailer phim</span></h2>
            </div>
            <div class="entry-content htmlwrap clearfix">
               <div class="video-item halim-entry-box">
                  <article id="post-38424" class="item-content">
                     <iframe width="560" height="315" src="https://www.youtube.com/embed/{{$movie->trailer}}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                  </article>
               </div>
            </div>
         </div>
      </section>
      <section class="related-movies">
         <div id="halim_related_movies-2xx" class="wrap-slider">
            <div class="section-bar clearfix">
               <h3 class="section-title"><span>CÓ THỂ BẠN MUỐN XEM</span></h3>
            </div>
            <div class="halim_box">
               @foreach($related as $key => $relate)
                  <article class="col-md-3 col-sm-3 col-xs-6 thumb grid-item post-27021">
                        <div class="halim-item">
                           <a class="halim-thumb" href="{{route('movie',$relate->slug)}}" title="{{$relate->title}}">
                              <figure><img class="lazy img-responsive" src="{{asset('uploads/movie/'.$relate->image)}}" title="{{$relate->title}}"></figure>
                              <span class="status">
                                 @if($relate->resolution==0)
                                    HD
                                 @elseif($relate->resolution==1)
                                    SD
                                 @elseif($relate->resolution==2)
                                    HDCam
                                 @elseif($relate->resolution==3)
                                    Cam
                                 @else($relate->resolution==4)
                                    FullHD 
                                 @endif
                              </span>
                              <span class="episode"><i class="fa fa-play" aria-hidden="true"></i>
                                 @if($movie->subtitle==0)
                                    Phụ đề
                                 @else
                                    Thuyết minh
                                 @endif 
                              </span> 
                              <div class="icon_overlay"></div>
                              <div class="halim-post-title-box">
                                 <div class="halim-post-title ">
                                    <p class="entry-title">{{$relate->title}}</p>
                                    <p class="original_title">{{$relate->name_eng}}</p>
                                 </div>
                              </div>
                           </a>
                        </div>
                  </article>
               @endforeach
            </div> 
            <script type="text/javascript">
               $(document).ready(function($) {            
               var owl = $('#halim_related_movies-2');
               owl.owlCarousel({loop: true,margin: 4,autoplay: true,autoplayTimeout: 4000,autoplayHoverPause: true,nav: true,navText: ['<i class="hl-down-open rotate-left"></i>', '<i class="hl-down-open rotate-right"></i>'],responsiveClass: true,responsive: {0: {items:2},480: {items:3}, 600: {items:4},1000: {items: 5}}})});
            </script>
         </div>
      </section>
   </main>
   @include('pages.include.sidebar');
</div>
@endsection