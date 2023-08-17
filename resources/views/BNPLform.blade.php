<!-- form.blade.php -->
<form action="/bnpl/process" method="POST">
    @csrf

    <div>
        <label for="card_number">Card Number:</label>
        <input type="text" id="card_number" name="card_number">
    </div>

    <div>
        <label for="cardholder_name">Cardholder Name:</label>
        <input type="text" id="cardholder_name" name="cardholder_name">
    </div>

    <div>
        <label for="expiration_date">Expiration Date:</label>
        <input type="text" id="expiration_date" name="expiration_date">
    </div>

    <div>
        <label for="cvv">CVV:</label>
        <input type="text" id="cvv" name="cvv">
    </div>    
    <div>
        <label for="cvv">Split the payment for :</label>
        <input type="text" id="cvv" name="cvv">
    </div>

    <!-- Add more card fields as needed -->

    <button type="submit">Submit</button>
</form>
<form action="/bnpl" method="POST">
  @csrf

  <input type="text" name="product" placeholder="Product" required>
  <input type="number" name="price" placeholder="Price" required>
  <button type="submit">Calculate BNPL</button>
</form>
