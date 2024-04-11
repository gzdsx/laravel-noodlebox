<div>
    <h2>Search</h2>
    <div>
        <input type="text" class="form-control" placeholder="Search">
    </div>
    <div class="mt-4">
        <a href="{{url('points-mall')}}" class="btn btn-bull-cyan text-white">Points Mall</a>
    </div>
    <ul class="product-right-categories">
        @foreach($categories as $category)
            <li><a href="{{$category->url}}">{{$category->name}}</a></li>
        @endforeach
    </ul>
</div>