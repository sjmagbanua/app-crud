<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</head>
<body class="ms-3 me-3">
    <h1>TABLE CRUD</h1>
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
        Add Product
        </button>

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addProductForm" class="row g-3" >
                    <div class="modal-body">
                        @csrf
                        @method('post')
                        <div class="col-auto">
                            <input type="text" class="form-control" name="name" id="name" placeholder="name">
                        </div>
                        <br>
                        <div class="col-auto">  
                            <input type="text" class="form-control" name="qty" id="qty" placeholder="qty">
                        </div>
                        <br>
                        <div class="col-auto">
                            <input type="text" class="form-control" name="price" id="price" placeholder="price">
                        </div>
                        <br>
                        <div class="col-auto">
                            <input type="text" class="form-control" name="description" id="description" placeholder="description">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" id="saveButton">Save changes</button>
            </div>
            </div>
        </div>
        </div>
    <br>
    <br>
    <table  class="table table-dark table-striped">
    <thead>
        <tr>
            <th >id</th>
            <th >name</th>
            <th >qty</th>
            <th >price</th>
            <th >description</th>
            <th >edit</th>
            <th >delete</th>
        </tr>
    </thead>
    <tbody>
        @foreach($products as $product)
            <tr>
                <td>
                    {{$product->id}}
                </td>
                <td>
                    {{$product->name}}
                </td>
                <td>
                    {{$product->qty}}
                </td>
                <td>
                    {{$product->price}}
                </td>
                <td>
                    {{$product->description}}
                </td>
                <td>
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary edit-btn" data-bs-toggle="modal" data-bs-target="#editModal">
                    Edit
                    </button>

                    <!-- Modal -->
                    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">edit product</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form class="row g-3" method="get" id="editModal{{ $product->id }}">
                        <div class="modal-body">
                                @csrf
                                @method('get')
                                <div class="col-auto ">
                                    <input type="text"  class="form-control"  name="name" placeholder="{{$product->name}}">
                                </div>
                                <br>
                                <div class="col-auto">
                                    <input type="text" class="form-control"  name="qty" placeholder="{{$product->qty}}">
                                </div>
                                <br>
                                <div class="col-auto">
                                    <input type="text" class="form-control"  name="price" placeholder="{{$product->price}}">
                                </div>
                                <br>
                                <div class="col-auto">
                                    <input type="text" class="form-control"   name="description" placeholder="{{$product->description}}">
                                </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary edit-btn">Edit Product</button>
                        </div>
                        </form>

                        </div>
                    </div>
                    </div>
                </td>
                <td>
                    <button type="button" class="btn btn-danger">delete</button>
                </td>
            </tr>   
        @endforeach
    </tbody>
    </table>


  

    <script>
        $(document).ready(function() {
            $('#saveButton').click(function() {
            var name = $('#name').val();
            var qty = $('#qty').val();
            var price = $('#price').val();
            var description = $('#description').val();
            // AJAX Request
            $.ajax({
                url: '{{ route('product.store') }}',
                type: 'POST',
                data: {
                "_token": "{{ csrf_token() }}",
                name: name,
                qty: qty,
                price: price,
                description: description,
                },
                success: function(response) {
                $('#exampleModal').modal('hide');
                // Clear form fields
                $('#name').val('');
                $('#qty').val('');
                $('#price').val('');
                $('#description').val('');
                // Display success message
                alert('Post created successfully.');
                console.log(name);

                },
                error: function(xhr) {
                console.error(xhr.responseText);
                // Optionally, display error message
                alert('Error occurred. Please try again.');
                }
            });
            });
        });


        $(document).ready(function() {
        $('.edit-btn').click(function() {
            var productId = $(this).data('product-id');

            // AJAX Request to fetch product data
            $.ajax({
                url: '/product/' + productId + '/edit',
                type: 'GET',
                success: function(response) {
                    // Populate the edit modal with product data
                    $('#editModal' + productId + ' #name').val(response.name);
                    $('#editModal' + productId + ' #qty').val(response.qty);
                    $('#editModal' + productId + ' #price').val(response.price);
                    $('#editModal' + productId + ' #description').val(response.description);
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                    // Optionally, display error message
                    alert('Error occurred. Please try again.');
                }
            });
        });
    });
    </script>

</body>
</html>
