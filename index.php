<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>B2BInpay Payment</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <div class="row">

            <div class="col-lg-4 col-md-12 col-sm-12"></div>
            <div class="col-lg-4 col-md-12 col-sm-12">

                <form action="paySIMPLE.php" method="post">

                    <div class="form-group">
                        <label for="amount">Amount</label>
                        <input class="form-control" type="text" name="amount" id="amount">
                    </div>
                    <div class="form-group">
                        <label for="currency">Currency</label>
                        <select name="currency" class="form-control">
                            <option value="1">BTC</option>
                            <option value="2">ETH</option>
                            <option value="3">USDT (OMNI)</option>
                            <option value="4">USDT ETH</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="callback_url">Callback URL</label>
                        <input class="form-control" type="text" name="callback_url" id="callback_url">
                    </div>
                    <div class="form-group">
                        <label for="success_url">Success URL</label>
                        <input class="form-control" type="text" name="success_url" id="success_url">
                    </div>
                    <div class="form-group">
                        <label for="fail_url">Failure URL</label>
                        <input class="form-control" type="text" name="fail_url" id="fail_url">
                    </div>

                    <button type="submit" class="btn btn-success btn-block">Pay Now</button>
                
                </form>
            
            </div>
            <div class="col-lg-4 col-md-12 col-sm-12"></div>
        
        </div>
    </div>
</body>
</html>