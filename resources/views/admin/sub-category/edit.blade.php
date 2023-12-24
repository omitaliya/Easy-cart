@extends('admin.layouts.app')

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Edit Sub Category</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{ url()->previous() }}" class="btn btn-primary">Back</a>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</section>
<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <div class="container-fluid">
        <form id="subcategory" name="subcategory">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="name">Name</label>
                            <input type="text" value="{{ $sub_category->name }}" name="name" id="name" class="form-control" placeholder="Name">
                            <p id="error"></p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="email">Slug</label>
                            <input type="text" value="{{ $sub_category->slug }}" readonly name="slug" id="slug" class="form-control" placeholder="Slug">
                            <p id="error"></p>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="name">Category</label>
                            <select name="category" id="category" class="form-control">
                                <option disabled selected>Select Category</option>
                                     @forelse ($category as $cat)

                                            <option {{ ($sub_category->category_id==$cat->id)? 'selected':'' }} value="{{ $cat->id }}">{{ $cat->name }}</option>
                                     @empty
                                     <option disabled>No category found!</option>

                                        @endforelse
                            </select>
                            <p></p>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="status">Status</label>
                        <select name="status" class="form-control" id="status">
                            <option {{ ($sub_category->status==1)? 'selected':'' }} value="1">Active</option>
                            <option {{ ($sub_category->status==0)? 'selected':'' }} value="0">Inactive</option>
                        </select>
                        </div>
                    </div>

                </div>
            </div>
       
        </div>
        <div class="pb-5 pt-3">
            <button type="submit" class="btn btn-primary">Create</button>
            <a href="#" class="btn btn-outline-dark ml-3">Cancel</a>
        </div>
    </div>
</form>
    <!-- /.card -->
</section>
<!-- /.content -->

@endsection

@section('js')

<script>


    $("#subcategory").submit(function(e) {
            e.preventDefault();

            $("button[type=submit]").prop("disabled", true);


        $.ajax({
            url:"{{ route('sub-category.update',$sub_category->id) }}",
            type:"POST",
            dataType:'json',
            data:$("#subcategory").serializeArray(),
            success:function(response)
            {
                if(response.status==true)
                {

                    window.location.href='{{ route("sub-category.index") }}';
                    
                }else
                {
                  var errors=response.errors;

                  if(errors['name'])
                  {
                    $("#name").siblings('p').addClass("text-danger").text(errors.name);
                }else
                {
                    $("#name").siblings('p').removeClass("text-danger").text("");

                }
                
                if(errors['slug'])
                {
                      $("#slug").siblings('p').addClass("text-danger").text(errors.slug);
                      
                    }else
                    {
                      $("#slug").siblings('p').removeClass("text-danger").text("");

                  }

                  if(errors['category'])
                {
                      $("#category").siblings('p').addClass("text-danger").text(errors.category);
                      
                    }else
                    {
                      $("#category").siblings('p').removeClass("text-danger").text("");

                  }
                }
            },  
            complete:function(){
            $("button[type=submit]").prop("disabled", false);

            }
        })
    });


$("#name").change(function(){
    element=$(this);
    $.ajax({
            url:"{{ route('getSlug') }}",
            type: "get",
            data:{title: element.val()},
            dataType: "json",
            success: function(response){
                if(response['status']==true)
                {
                    $('#slug').val(response['slug']);
                }
            }
        });
    });
</script>
@endsection