<!DOCTYPE html>
<html>
<head>
    <title>Invoice</title>
</head>
<body>
    <h1>Invoice</h1>
    
    <p>Paid today: ${{ number_format($paidAmount, 3) }}</p>
    <p>Next Payment Dates:</p>
       
    <ul>
        
            <li>The next payment will be : {{$final = date("d-m-Y", strtotime("+1 month"));}} </li>
            <li>The last amount will be : {{$final = date("d-m-Y", strtotime("+2 month"));}} </li>
        
    </ul>
    <h2>Items:</h2>
    <ul>
        @foreach ($items as $item)
            <li>{{ $item['title'] }}</li>
            <li>Quantity: {{ $item['quantity'] }}</li>
        @endforeach
    </ul>
</body>
</html>
