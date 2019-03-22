@if(count($blog_articles))
    <div class="ui feed topic-list rm-link-color mt-0">
        @foreach($blog_articles as $article)
            <div class="event pt-3 pb-0 mb-0">
                <div class="label mt-1" style="width: 3.2em;">
                    <a href="{{ route('users.show', [$article->user_id]) }}">
                        <img class="lazy" data-original="{{ assert_images($article->avatar_path) }}" alt="" style="border: 1px solid #ddd;padding: 2px;">
                    </a>
                </div>
                <div class="content ml-3">
                    <div class="summary " style="color: #555;">
                        <a href="{{ route('blog.articles.show', [$article->id]) }}" title="{{ $article->title }}" class="title">
                            {{ $article->title }}
                        </a>
                    </div>
                    <div class="meta mt-2 mb-2">
                        {{--<div class="tags" style="margin: -2px 0 0;">
                            @foreach($article->tags as $item)
                            <a class="ui label small"
                               href="{{ route('users.tags.show', ['user'=> $article->user_id, 'tag'=> $item->id]) }}"
                               style="margin-left: 0 !important;">{{ $item->name }}</a>
                            @endforeach
                        </div>--}}

                        <div class="date" style="font-size: 13px;margin: 7px 0 0 0;">
                            <a href="{{ route('blog.categories.show', ['category'=> $article->category_id]) }}"
                               data-tooltip="分类" title="{{ $article->category->name }}">
                                <i class="icon folder outline"></i> {{ $article->category->name }}
                            </a>
                            <span class="divider">|</span>
                            <a class="" data-tooltip="2019-02-27 11:07:02">
                                发布于 <span title="2019-02-27 11:07:02">{{ $article->created_at->diffForHumans() }}</span>
                            </a>
                            <span class="divider">|</span>
                            <a>
                                阅读 {{ $article->view_count }}
                            </a>
                            <span class="divider">|</span>
                            <a>
                                评论 {{ $article->reply_count }}
                            </a>
                        </div>
                    </div>
                </div>

                <div class="item-meta mt-2 text-right" style="color:#ccc;font-size: 12px;width: 150px;">
                    <a class="ui " href="{{ route('blog.articles.show', [$article->id]) }}"><i class="mr-1 icon thumbs up"></i> {{ $article->zan_count }} </a>
                    <span style="margin: 0px 4px;text-align: center;font-size: 13px;">/</span>
                    <a class="ui  popover" data-content="活跃于：{{ $article->updated_at->diffForHumans() }}"
                       href="{{ route('blog.articles.show', [$article->id]) }}">
                        {{ $article->updated_at->diffForHumans() }}
                    </a>
                </div>
            </div>
        @endforeach
    </div>
@else
    <div>暂无数据 ~_~ </div>
@endif
