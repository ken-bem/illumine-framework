<div class="posts">

        <h2>Browse Directory</h2>
    <br/>

    @if(isset($posts) && count($posts))
        <ul class="list-group">
        @foreach($posts as $postObject)


            <li class="list-group-item">
                <a href="{{ get_permalink($postObject->ID) }}" title="{{ $postObject->post_title }}">
                    {{ $postObject->ID }}: {{ $postObject->post_title }}
                </a>
                @foreach($postObject->meta as $metaObject)
                {{  $metaObject->meta_value }}
                @endforeach
            </li>
        @endforeach
    </ul>


    @include('pagination.default-html5',[
        'collection' => $posts
    ])

    @else
    <div class="alert">
    Whoops, we couldn't find any posts.
    </div>
    @endif
</div>
@if(!$request->ajax())
<script>
    $ = jQuery;

    function loadPage() {
        if (window.location.hash) {
            var page = window.location.hash.replace('#', '');
            console.log(page);
            if (page == Number.NaN || page <= 0) {
                return false;
            } else {
                $.ajax({
                    url : '{!! route_url('directory') !!}?wpp_directory='+page,
                    dataType: 'html',
                    method: 'GET'
                }).done(function (data) {
                    $('.posts').html(data);

                }).fail(function () {
                    alert('Posts could not be loaded.');
                });
            }
        }
    }
    $(window).on('hashchange', function() {
        loadPage();
    });
    $(document).ready(function() {
        $(document).on('click', '.pagination a', function (e) {
            location.hash = $(this).attr('href').split('wpp_directory=')[1];
            e.preventDefault();
        });
        loadPage();
    });
</script>
@endif
