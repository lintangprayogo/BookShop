@extends('layouts.global')
@section('title')Create Book @endsection

@section("content")

<div class="row">
    @if(session('status'))
    <div class="col-md-8">
        <div class="alert alert-success">
            {{session('status')}}
        </div>
    </div>
    @endif
    <div class="col-md-8">
        <form action="{{route('books.store')}}" method="POST" enctype="multipart/form-data" class="shadow-sm p-3 bg-white">
            @csrf
            <label for="title">Title</label>
            <input type="text"  value="{{old('title')}}"  class="form-control {{$errors->first('title') ? "is-invalid":""}}" name="title" id="title" placeholder="Book title">
            <div class="invalid-feedback">
                {{$errors->first('title')}}
            </div>
            <br><br />


            <label for="cover">Cover</label>
            <input type="file"  class="form-control {{$errors->first('cover') ? "is-invalid" :""}}" name="cover" id="cover" placeholder="Book cover" accept="image/*">
            <div class="invalid-feedback">
                {{$errors->first('cover')}}
            </div>
            <br><br />



            <label for="description">Description</label>
            <textarea name="description" value="{{old('description')}}" id="description" class="form-control {{$errors->first('description') ? "is-invalid" :""}}" placeholder="Give a description about this book"></textarea>
            <div class="invalid-feedback">
                {{$errors->first('description')}}
            </div>
            <br><br />


            <label for="stock">Stock</label>
            <input type="number" value="{{old('stock')}}" class="form-control {{$errors->first('stock') ? "is-invalid" :""}}" name="stock" id="stock" value="0" min="0">
            <div class="invalid-feedback">
                {{$errors->first('stock')}}
            </div>
            <br><br />


            <label for="author">Author</label>
            <input type="text"  value="{{old('author')}}" name="author" class="form-control {{$errors->first('author') ? "is-invalid" :""}}" id="author" placeholder="Book author">
            <div class="invalid-feedback">
                {{$errors->first('author')}}
            </div>
            <br><br />


            <label for="publisher">Publisher</label>
            <input type="text" value="{{old('author')}}" name="publisher"  class="form-control {{$errors->first('author') ? "is-invalid" :""}}"  id="publisher" placeholder="Book publisher">
            <div class="invalid-feedback">
                {{$errors->first('author')}}
            </div>
            <br><br />


            <label for="price">Price</label>
            <input type="number" value="{{old('price')}}" class="form-control {{$errors->first('price') ? "is-invalid" :""}}" name="price" id="price" placeholder="Book Price" min="0">
            <div class="invalid-feedback">
                {{$errors->first('price')}}
            </div>
            <br><br />

            <label for="categories">Categories</label><br>

            <select name="categories[]" multiple id="categories" class="form-control">
            </select>

            <br><br />

            <button class="btn btn-primary" name="save_action" value="PUBLISH">Publish</button>
            <button class="btn btn-secondary" name="save_action" value="DRAFT">Save As Draft</button>



        </form>
    </div>
</div>
@endsection
@section('footer-scripts')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<script>
    $('#categories').select2({
        ajax: {
            url: "{{route('categories.ajax')}}",
            processResults: function(data) {
                return {
                    results: data.map(function(item) {
                        return {
                            id: item.id,
                            text: item.name
                        }
                    })
                }
            }
        }
    });
</script>
@endsection