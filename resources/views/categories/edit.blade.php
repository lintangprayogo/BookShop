@extends("layouts.global")
@section("title")Edit Category @endsection

@section("content")
<div class="row">
    <div class="col-md-8">
        @if(session('status'))
        <div class="alert alert-success">
            {{session('status')}}
        </div>
        
        @endif
        <form action="{{route('categories.update',[$category->id])}}" enctype="multipart/form-data" method="POST" class="bg-white shadow-sm p-3">
            @csrf
            <input type="hidden" value="PUT" name="_method" />

            <label>Category name</label>
            <input type="text" class="form-control" value="{{$category->name}}" name="name" />
            <br><br>


            <label>Category slug</label>
            <input type="text" class="form-control" value="{{$category->slug}}" name="slug" />
            <br><br>

            <label>Category slug</label>
            @if($category->image)
            <span>Curent Image</span><br>
            <img src="{{asset('storage/'.$category->image)}}" width="120px" height="120px" <br><br>
            @endif
            
            <input type="file" class="form-control" name="image">
            <small class="text-muted">Leave blank if you don't want to change the picture</small>
            <br><br>

            <input type="submit"  class="btn btn-primary" value="Update"/>
        </form>
    </div>
</div>
@endsection