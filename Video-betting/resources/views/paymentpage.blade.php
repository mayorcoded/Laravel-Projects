<html>
    <head>
        <title>
            Paystack payment
        </title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
        <style>
            input[type=text] {
                width: 100%;
                padding: 12px 20px;
                margin: 8px 0;
                display: inline-block;
                border: 1px solid #ccc;
                border-radius: 4px;
                box-sizing: border-box;
            }

            input[type=number] {
                width: 100%;
                padding: 12px 20px;
                margin: 8px 0;
                display: inline-block;
                border: 1px solid #ccc;
                border-radius: 4px;
                box-sizing: border-box;
            }
            h4 {
                color: green;
            }

        </style>
    </head>
    <body>

        <form method="POST" action="{{ route("pay") }}" accept-charset="UTF-8" class="form-horizontal" role="form">
            <div class="row" style="margin-bottom:40px;">
                <div class="col-md-8 col-md-offset-2">
                    <p>
                    <div>
                        <h4>Enter Payment details</h4>
                    </div>
                    </p>
                    <input  type="text" name="email" value={{$user->email}} readonly> <br><br>
                    <input type="hidden" name="orderID" value="345">
                    <input type="hidden"  id="amount" type="number" name="amount" value="" >
                    <input  id="ammount" type="number" name="userAmount" value="" placeholder="Enter Deposit Amount in Naira">
                    <input type="hidden" name="quantity" value="1">
                    <input type="hidden" name="reference" value="{{ Paystack::genTranxRef() }}">
                    <input type="hidden" name="key" value="{{ config('paystack.secretKey') }}">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <br><br>
                    <p>
                        <button class="btn btn-success btn-lg btn-block" type="submit" value="Pay Now!">
                            <i class="fa fa-plus-circle fa-lg"></i> Pay Now!
                        </button>
                    </p>
                </div>
            </div>
        </form>

    </body>
    <script>
        $(document).ready(function(){
            $("form").submit(function(){
                var koboAmount = $('#ammount').val() * 100;
                $('#amount').val(koboAmount);
            });
        });
    </script>
</html>