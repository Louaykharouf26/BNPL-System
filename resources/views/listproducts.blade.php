@foreach ($productslist as $products)
{{$products->name}}
{{$products->price}}
<a href="{{ route('products.bnpl', ['id' => $products->id]) }}" class="add-product-btn">Add Product</a>

@endforeach