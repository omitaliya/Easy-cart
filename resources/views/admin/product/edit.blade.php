@extends('admin.layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">					
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Product</h1>
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
        <form name="productForm" id="productForm" enctype="multipart/form-data"> 
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8">
                    <div class="card mb-3">
                        <div class="card-body">	
                            @if(session()->has('success'))
                            <p class="text-success">{{ session()->get('success') }}</p>
                    @endif							
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="title">Title</label>
                                        <input type="text" value="{{ $product->title }}" name="title" id="title" class="form-control" placeholder="Title">	
                                    <p id="error"></p>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="slug">Slug</label>
                                        <input type="text" value="{{ $product->slug }}" readonly name="slug" id="slug" class="form-control" placeholder="Slug">	
                                        <p id="error"></p>
                                     </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="description">Description</label>
                                        <textarea name="description" id="description" cols="30" rows="10" class="form-control" placeholder="Description">
                                            {{ $product->description }}
                                        </textarea>
                                        <p id="error"></p> </div>
                                </div>                                            
                            </div>
                        </div>	                                                                      
                    </div>

                    <div class="card mb-3">
                        <div class="card-body">
                            <h2 class="h4 mb-3">Media</h2>								
                            <input type="file" multiple accept="image/*" name="image[]" class="form-control">
                            
                            @forelse ($product->images as $img)
                            <img src="{{ asset('storage/'.$img->path) }}" class="img-thumbnail" width="50" >
                                
                                <a href="{{ route('product.deleteImage',$img->id) }}" class="text-danger">Remove</a>
                            @empty
                               {{  "No Images Uoloaded" }}
                            @endforelse

                            <p id="error"></p>
                         </div>	                                                                      
                    </div>

                    <div class="card mb-3">
                        <div class="card-body">
                            <h2 class="h4 mb-3">Pricing</h2>								
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="price">Price</label>
                                        <input type="text" value="{{ $product->price }}" name="price" id="price" class="form-control" placeholder="Price">	
                                        <p id="error"></p>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="compare_price">Compare at Price</label>
                                        <input type="text" value="{{ $product->compare_price ?? '' }}" name="compare_price" id="compare_price" class="form-control" placeholder="Compare Price">
                                        <p id="error"></p>
                                         <p class="text-muted mt-3">
                                            To show a reduced price, move the product’s original price into Compare at price. Enter a lower value into Price.
                                        </p>	
                                    </div>
                                </div>                                            
                            </div>
                        </div>	                                                                      
                    </div>
                    <div class="card mb-3">
                        <div class="card-body">
                            <h2 class="h4 mb-3">Inventory</h2>								
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="sku">SKU (Stock Keeping Unit)</label>
                                        <input type="text" value="{{ $product->sku }}" name="sku" id="sku" class="form-control" placeholder="sku">	
                                        <p id="error"></p></div>
                                </div>
                               
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <div class="custom-control custom-checkbox">
                                            <input class="custom-control-input" type="checkbox" id="track_qty" checked name="track_qty">
                                            <label for="track_qty" class="custom-control-label" >Track Quantity</label>
                                        </div>
                                    </div>
                                </div>   
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="qty">Quantity</label>
                                        <input type="number" value="{{ $product->qty ?? '' }}" min="0" name="qty" id="qty" class="form-control" placeholder="Qty">	
                                        <p id="error"></p> </div>
                                </div>                                        
                            </div>
                        </div>	                                                                      
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card mb-3">
                        <div class="card-body">	
                            <h2 class="h4 mb-3">Product status</h2>
                            <div class="mb-3">
                                <select name="status" id="status" class="form-control">
                                    <option {{ ($product->status==1)?'selected' :'' }} value="1">Active</option>
                                    <option {{ ($product->status==0)?'selected' :'' }} value="0">Block</option>
                                </select>
                            </div>
                        </div>
                    </div> 
                    <div class="card">
                        <div class="card-body">	
                            <h2 class="h4  mb-3">Product category</h2>
                            <div class="mb-3">
                                <label for="category">Category</label>
                                <select name="category" id="category" class="form-control">
                                    <option selected disabled>Select Category</option>
                                    @foreach ($category as $cat)
                                    
                                    <option {{ ($product->category_id==$cat->id)? 'selected' : '' }} value="{{ $cat->id }}">{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                                <p id="error"></p> </div>
                            <div class="mb-3">
                                <label for="category">Sub category</label>
                                <select name="sub_category" id="sub_category" class="form-control">
                                    <option selected>Select Sub Category</option>
                                    @if (!empty($sub_category))
                                        @foreach ($sub_category as $sb)
                                            <option {{ ($product->sub_category_id==$sb->id)?'selected' :'' }} value="{{ $sb->id }}">{{ $sb->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div> 
                    <div class="card mb-3">
                        <div class="card-body">	
                            <h2 class="h4 mb-3">Product brand</h2>
                            <div class="mb-3">
                                <select name="brand" id="brand" class="form-control">
                                    <option selected disabled>Select Brand</option>

                                    @foreach ($brand as $b)
                                    
                                    <option {{ ($product->brand_id==$b->id)? 'selected' : '' }}  value="{{ $b->id }}">{{ $b->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div> 
                    <div class="card mb-3">
                        <div class="card-body">	
                            <h2 class="h4 mb-3">Featured product</h2>
                            <div class="mb-3">
                                <select name="is_featured" name="is_featured" id="is_featured" class="form-control">
                                    <option {{ ($product->is_featured==0)? 'selected' : '' }} selected value="0">No</option>
                                    <option {{ ($product->is_featured==1)? 'selected' : '' }} value="1">Yes</option>                                                
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

    $("#productForm").submit(function(e) {
        e.preventDefault();

        var formData=new FormData(this);

        $.ajax({
            url:"{{ route('product.update',$product->id) }}",
            type:"post",
            data:formData,
            dataType:"json",
            contentType: false,
            processData: false,
            success:function(response){
                if(response.status==true)
                {
                    window.location.href="{{ route('product.index') }}";
                }else
                {
                    $("#error").removeClass("invalid-feedback").text('');
                    $("input,select,textarea").removeClass("is-invalid");

                    $.each(response['errors'],function(key,value){
                        if(key=='image')
                        {
                            $("input[type=file]").addClass("is-invalid").siblings("p").
                            addClass('invalid-feedback').text(value[0]);

                        }else
                        {

                            $(`#${key}`).addClass("is-invalid").siblings("p").
                            addClass('invalid-feedback').text(value);
                        }
                    });
                }
            }
        });
    })


    $("#title").change(function(){
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



        $("#category").change(function()
        {
            var category_id=$(this).val();

            $.ajax({
                url:"{{ route('getSubCategory') }}",
                type:'get',
                data:{'category_id':category_id},
                dataType:"json",
                success:function(response){
                    $("#sub_category").find("option").not(":first").remove();
                    $.each(response["sub_category"],function(key,item)
                    {
                        $("#sub_category").append(`<option value='${item.id}'>${item.name}</option>`);
                    });
                }
            });
     })

     $("#track_qty").change(function(){
        if($(this).is(":checked"))
        {
            $("#qty").prop("disabled",false);
            $("#track_qty").attr('value','1');

        }else
        {
            $("#error").removeClass("invalid-feedback").text('');
            $("#qty").removeClass("is-invalid");
            $("#qty").prop("disabled",true);
            $("#qty").val('');

        }
     })

</script>


@endsection