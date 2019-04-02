@extends('layouts.app')

@section('content')
    <div class="ui centered grid container stackable">
        <div class="wide column">
            <div class="ui stacked segment">
                <div class="content px-3 py-3">
                    <h1><i class="bell outline icon"></i> 我的订单</h1>
                    <div class="ui divider mb-0"></div>
                    @if($orders->count())
                    <div class="wide column ui stacked segment">
                        <div class="ui divided items">
                            @foreach($orders as $order)
                                <div class="item">
                                    <a class="image" href="{{ route('course.books.show', $order->course_book_id) }}">
                                        <img class="lazy" data-original="{{ $order->book->image['path'] }}">
                                    </a>
                                    <div class="content">
                                        <a class="header" href="{{ route('course.books.show', $order->course_book_id) }}">{{ $order->book->title }}</a>
                                        <div class="meta">
                                            <span class="cinema">{{ $order->book->excerpt }}</span>
                                        </div>
                                        <div class="description">
                                            <p></p>
                                        </div>
                                        <div class="extra">
                                            @if($order->flag == '1')
                                                <div class="ui right floated green button">
                                                    已付款
                                                </div>
                                            @else
                                                <a href="{{ route('course.purchases.index', $order->course_book_id) }}" class="ui right floated primary button">
                                                    去付款 <i class="right chevron icon"></i>
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    @else
                    <div class="ui feed notifications mt-0 rm-link-color text-decoration-underline">
                        <div>暂无订单 ~</div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
