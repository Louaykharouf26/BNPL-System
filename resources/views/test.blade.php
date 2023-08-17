<form action="{{ route('update_cvv') }}" method="POST">
    @csrf
    <label for="cvv">CVV:</label>
    <input type="text" id="cvv" name="cvv" value="{{ old('cvv') ?? auth()->user()->cvv }}" required>
    <button type="submit">Update CVV</button>
</form>
