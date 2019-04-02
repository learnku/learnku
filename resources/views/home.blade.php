@extends('layouts.app')
@section('title', '首页')
@section('style')
    <link rel="stylesheet" href="{{ assert_cdns('/ext/swiper4/css/swiper.min.css') }}">
    <style type="text/css">
        .ui.top.menu{margin-bottom: 0;}
    </style>
@endsection

@section('content')
    <!-- Swiper -->
    <div class="swiper-container">
        <div class="swiper-wrapper">
            <div class="swiper-slide">
                <img src="{{ assert_cdns('/images/banner/better-world.jpg') }}" alt="">
            </div>
            <div class="swiper-slide">
                <img src="{{ assert_cdns('/images/banner/control-in-programming.jpg') }}" alt="">
            </div>
            <div class="swiper-slide">
                <img src="{{ assert_cdns('/images/banner/create-through-programming.jpg') }}" alt="">
            </div>
        </div>
        <!-- Add Pagination -->
        <div class="swiper-pagination"></div>
        <!-- Add Arrows -->
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
    </div>


    <div style="background-color: #fff">
        <div class="ui vertical stripe segment">
            <div class="ui centered grid container main stackable blog" style="">
                <div class="twelve wide column pull-right main" style="margin-bottom: 3rem;">
                    <div class="ui segment article-content">
                        <div class="extra-padding">
                            <h2 class="ui block header">
                                <img class="ui image" src="{{ assert_cdns('/images/public/school.png') }}">
                                <div class="content">优质文章</div>
                            </h2>

                            @include('pages.blog_articles._article_list')

                            {{-- 分页 --}}
                            {{ $blog_articles->links() }}
                        </div>
                    </div>
                </div>

                @include('pages.blog_articles._sidebar', ['isArticleList'=> true])
            </div>
        </div>
    </div>
@stop

@section('script')
    <script src="{{ assert_cdns('/ext/swiper4/js/swiper.min.js') }}"></script>
    <script type="text/javascript">
        new Swiper('.swiper-container', {
            autoplay:true,
            slidesPerView: 1,
            spaceBetween: 30,
            loop: true,
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
        });
    </script>
@endsection
