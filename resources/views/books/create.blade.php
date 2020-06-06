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
            <input type="text" class="form-control" name="title" id="title" placeholder="Book title">
            <br><br />


            <label for="cover">Cover</label>
            <input type="file" class="form-control" name="cover" id="cover" placeholder="Book cover">
            <br><br />



            <label for="description">Description</label>
            <textarea name="description" id="description" class="form-control" placeholder="Give a description about this book"></textarea>
            <br><br />


            <label for="stock">Stock</label>
            <input type="number" class="form-control" name="stock" id="stock" value="0" min="0">
            <br><br />


            <label for="author">Author</label>
            <input type="text" class="form-control" name="author" id="author" placeholder="Book author">
            <br><br />


            <label for="author">Publisher</label>
            <input type="text" class="form-control" name="publisher" id="publisher" placeholder="Book publisher">
            <br><br />


            <label for="price">Price</label>
            <input type="number" class="form-control" name="price" id="price" placeholder="Book Price" min="0">
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