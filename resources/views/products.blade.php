<!-- create-product.blade.php -->
<form action="/products" method="POST">
    @csrf
    <div>
        <label for="name">Name:</label>
        <input type="text" id="name" name="name">
    </div>
    <div>
        <label for="description">Description:</label>
        <textarea id="description" name="description"></textarea>
    </div>
    <div>
        <label for="price">Price:</label>
        <input type="number" id="price" name="price" step="0.01">
    </div>
    <!-- Add more fields as needed -->

    <button type="submit">Add Product</button>
</form>
