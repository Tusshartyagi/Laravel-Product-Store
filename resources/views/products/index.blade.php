<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Inventory</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Product Inventory</h2>
        <form id="productForm">
            @csrf
            <div class="mb-3">
                <label for="productName" class="form-label">Product Name</label>
                <input type="text" class="form-control" id="productName" name="product_name" required>
            </div>
            <div class="mb-3">
                <label for="quantity" class="form-label">Quantity in Stock</label>
                <input type="number" class="form-control" id="quantity" name="quantity" required>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Price per Item</label>
                <input type="number" class="form-control" id="price" name="price" step="0.01" required>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>        

        <h3 class="mt-5">Submitted Products</h3>
        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Quantity in Stock</th>
                    <th>Price per Item</th>
                    <th>Datetime Submitted</th>
                    <th>Total Value</th>
                </tr>
            </thead>
            <tbody id="productTable">
                @foreach($products as $product)
                <tr>
                    <td>{{ $product->product_name }}</td>
                    <td>{{ $product->quantity }}</td>
                    <td>{{ $product->price }}</td>
                    <td>{{ $product->created_at }}</td>
                    <td>{{ $product->quantity * $product->price }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="4">Total Value Sum</th>
                    <th id="totalValueSum">{{ $totalValueSum }}</th>
                </tr>
            </tfoot>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            // Handle form submission
            $('#productForm').on('submit', function(e) {
                e.preventDefault(); // Prevent the default form submission
    
                $.ajax({
                    url: '/products', // Laravel route to handle form submission
                    type: 'POST', // HTTP method
                    data: $(this).serialize(), // Serialize the form data
                    success: function(response) {
                        alert('Product added successfully!');
                        location.reload(); // Reload the page to reflect new data
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', xhr.responseText);
                        alert('An error occurred while adding the product. Please check the console for more details.');
                    }
                });
            });
        });
    </script>    
</body>
</html>