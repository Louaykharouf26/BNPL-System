<!DOCTYPE html>
<html>
<head>
    <title>Payment Form</title>
</head>
<body>
    <h1>Payment Form</h1>
    <form class="row g-3 infoform" method="POST" action="{{ route('payment.process') }}">
        @csrf
        <div class="mb-3 row">
            <label for="staticEmail" class="col-sm-2 col-form-label cn">Card Number</label>
            <div class="col-sm-10">
                <input type="text" name="cn" class="form-control" id="staticEmail">
            </div>
        </div>
        <div class="mb-3 row">
            <label for="inputPassword" class="col-sm-2 col-form-label cn">CVV</label>
            <div class="col-sm-10">
                <input type="text" class="form-control cvv" name="cvv" id="inputPassword">
            </div>
        </div>
        <div class="mb-3 row">
            <label for="inputPassword" class="col-sm-2 col-form-label cn1">Expiry date</label>
            <div class="col-sm-10">
                <input type="text" name="ed" class="form-control edate" id="inputPassword">
            </div>
        </div>
        <div class="col-auto">
            <button type="submit" class="btn mb-3 paybtn">Pay today </button>
        </div>
    </form>
</body>
</html>
