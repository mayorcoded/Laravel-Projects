/**
 * Created by KayLee on 08/04/2017.
 */
var Profile = {
    init: function(){

    }
};

$(document).ready(function(){
    Profile.init();
});

var form = '';


function checkIfAccountExist(transaction) {

    $.ajax({
        type: "GET",
        url: "./checkaccount",
        data: "",
        success: function (data) {
            if(data == 'none'){
                bootbox.alert('<h4><p style="color: #d10909">Please set up your account details first!<br>Thanks!</p></h4>');
                $('#wallet-bar').removeClass('active');
                $('#profile').removeClass('active');
                $('#settings-bar').addClass('active');
                $('#settings').addClass('active');
            }else{
                switch (transaction){
                    case 'withdrawal':
                        withdraw();
                        break;
                    case 'deposit':
                        deposit();
                        break;
                }
            }
        }
    });

}
function deposit() {

    $.ajax({
        type: "GET",
        url: "./showpay",
        data: "",
        success: function (data) {
            var dialog = bootbox.dialog({
                message: data,
                closeButton: true
            });
        }
    });
}

function withdraw() {

    bootbox.prompt({
        title: 'Enter Amount! <p style="color: #d10909">Amount must be in multiple of ₦1000</p>',
        inputType: 'number',
        callback: function (result) {
                amount = result;
                console.log(typeof amount);
            if (result != null && amount.length != 0 && (amount % 1000 == 0)){

                bootbox.confirm({
                    title: "Confirm Withdrawal Amount",
                    message: '<p style="color: #d10909">**Are you sure you want to withdraw: ₦' + result +'</p>',
                    buttons: {
                        cancel: {
                            label: '<i class="fa fa-times"></i> Cancel'
                        },
                        confirm: {
                            label: '<i class="fa fa-check"></i> Confirm'
                        }
                    },
                    callback: function (result) {

                        if(result == true){
                            $.ajax({
                                type: "GET",
                                url: "./withdraw",
                                data:{amount:amount},
                                success: function (data) {
                                    //console.info(typeof data);
                                    if( data[0] == 'success') {
                                        //console.info(data[0]);
                                        $('#balance').text('#' + data[1].balance);
                                        $('#transactiontable tr:last').after(data[2]);
                                        bootbox.alert('<h4><p style="color: #4cae4c">Transaction Successful</p></h4>');
                                    }
                                    else bootbox.alert('<p style="color: #d10909">'+ data + '</p>');
                                }
                            });
                        }
                    }
                });

            } else if (result != null) {bootbox.alert('<h4><p style="color: #d10909">' +
                'Invalid Input!<br>Amount must be Integers!<br>Amount must be in multiple of N1000!</p></h4>');}
        }
    });

}

function getOtp(transferCode) {
    bootbox.prompt({
        size: "small",
        title: "Enter OTP code sent to your phone!",
        inputType: 'number',
        callback: function (result) {
            if(result != null) {
                var otp = result;
                $.ajax({
                    type: "GET",
                    url: "./finalize",
                    data: {code: transferCode, otp: otp},
                    success: function (data) {
                        console.info(data);

                        bootbox.alert({
                            message: data,
                            size: 'small'
                        });
                    }
                });
            }
        }
    });
}