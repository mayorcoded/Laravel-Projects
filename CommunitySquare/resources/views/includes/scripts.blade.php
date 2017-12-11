<script>
    $(document).ready(function(){
        $("#about-button, #about1").click(function(){
            $("#about-dropdown").slideToggle("fast");
            $('[data-toggle="tooltip"]').tooltip();
        });
    });
    $(window).scroll(function() {
        if ($(this).scrollTop() > 100){
            $('header').addClass("sticky");
            $('.topper').hide(100);
        }
        else{
            $('header').removeClass("sticky");
            $('.topper').fadeIn(200);
        }

        return false;
    });

    function login(){
        var username = $('#login input#username').val();
        var password = $('#login input#password').val();
        var token = $('input[name="_token"]').val();
        $('.login_error').html('');
        $('button[type="submit"]').addClass("disabled");
        if(email != '' && password != ''){
//            alert("username="+username+"&password="+password+"&_token="+token+"&ajax=true");
            $.ajax({
                url: "login",
                type: "POST",
                data: "username="+username+"&password="+password+"&_token="+token+'&ajax=true',
                success: function(data){
//                    alert(data);
                    var got = JSON.parse(data);
                    if(!got['status']){
                        displayError(false, got['message'],'login_error');
                        // alert('i wont');
                    }else{
                        displayError(true, got['message']+" you will be redirected",'login_error');
                        // alert('about to');
                        pageRedirect('/');
                    }
                },
                error: function(){
                    displayError(false, 'Could not connect to the server','login_error');
                }
            });

        }else{
            displayError(false, 'You left one or more fields empty', 'login_error');
        }

        $('button[type="submit"]').removeClass("disabled");
        return false;
    }


    function displayError(status, value, _class){
        if(status) {
            var col = 'success';
            var msg = 'Success!';
        }
        else {
            var col = 'danger';
            var msg = 'Error!';
        }
        if(_class == ''){
            var _class = 'error';
        }
//        alert(_class);
        var data = '<div class="alert alert-'+col+'"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>' +
                '<strong>'+msg+'</strong> '+value+' </div>';
        $('.'+_class+'').html(data);
    }

    function loadLG(){
        $('.reg_error').html('');
        var state = $('select.states option:selected').val();
        $('.lg').html('Loading local governments...');
        $.ajax({
            url: "geo/lg/"+state,
            type: "GET",
            data: "state="+state,
            success: function(data) {
//                alert(data);
                var decoded = JSON.parse(data);
                var lg = '';
                for(var i=0; i < decoded['data'].length; i++)
                    lg += '<option val="'+decoded['data'][i].id+'">'+decoded['data'][i].lg+'</option>';
                $('select.loadlg').html(lg);
            },
            error: function(){
                displayError(false, 'could not load local governments because could not connect to the server','reg_error');
            }
        });

    }

    function register(){
        $('.error').html('');
        var username = $('#register input[name="username"]').val();
        var email = $('#register input[name="email"]').val();
        var age = $('#register select[name="age"] option:selected').val();
        var state = $('#register select[name="state"] option:selected').val();
        var lg = $('#register select[name="lg"] option:selected').val();
        var password = $('#register input[name="password"]').val();
        var password2 = $('#register input[name="password_confirmation"]').val();
        var token = $('#register input[name="_token"]').val();
        var address = $('#register textarea[name="address"]').val();
        var area = $('#register textarea[name="area"]').val();
//        alert('username='+username+'&email='+email+'&age='+age+'&lg='+lg+'&password='+password+'&password_confirmation='+password2+'&_token='+token);
        if(username != '' && email != '' && age != '' && state != '' && lg != '' && password != '' &&
                username != undefined && email != undefined && age != undefined && state != undefined && lg != undefined && password != undefined
        ){
            var data = 'area='+area+'&username='+username+'&email='+email+'&age='+age+'&local_government='+lg+'&password='+password+'&password_confirmation='+password2+'&_token='+token+'&state='+state+'&address='+address;
            $.ajax({
                url: "register",
                type: "POST",
                data: data,
                success: function(data) {
                    console.log(data);
                    var decoded = JSON.parse(data);
                    if(decoded['status']){
                        //THEN SUCCESSFULLY REGISTERED
                        $('.register').html(decoded['body']);
                    }else{
                        if(typeof decoded['message']['username'] != undefined)
                            $('.username_er').html( decoded['message']['username']);
                        if(typeof decoded['message']['email'] != undefined)
                            $('.email_er').html( decoded['message']['email']);
                        if(typeof decoded['message']['age'] != undefined)
                            $('.age_er').html( decoded['message']['age']);
                        if(typeof decoded['message']['state'] != undefined)
                            $('.state_er').html( decoded['message']['state']);
                        if(typeof decoded['message']['local_government'] != undefined)
                            $('.lg_er').html( decoded['message']['local_government']);
                        if(typeof decoded['message']['password'] != undefined)
                            $('.password_er').html( decoded['message']['password']);
                        if(typeof decoded['message']['address'] != undefined)
                            $('.address_er').html( decoded['message']['address']);
                        if(typeof decoded['message']['area'] != undefined)
                            $('.address_er').html( decoded['message']['area']);
                    }
                },
                error: function(){
                    displayError(false, 'Oops... could not connect to the server','reg_error');
                }
            });

        }else{
            displayError(false, 'No field can be left blank, please fill all appropiately','reg_error');
        }
        return false;
    }

    function addTopic(){
        $('.topic_er').html('');
        $('.error').html('');
        var topic_title = $('#addTopic input[name="title"]').val();
        var topic_content = $('#addTopic textarea[name="content"]').val();
        var lg = $('#addTopic input[name="lg"]').val();
        var age= $('#addTopic select[name="age"] option:selected').val();
        var _token = $('#addTopic input[name="_token"]').val();
//        alert('content='+topic_content+'&topic='+topic_title+'&lg='+lg+'&_token='+_token);
        if(topic_content != undefined && topic_title != undefined && lg != undefined &&
                topic_content != undefined && topic_title != undefined && lg != undefined
        ){
            var data = 'content='+topic_content+'&topic='+topic_title+'&lg='+lg+'&_token='+_token+'&age='+age;
            $.ajax({
                url: "topic/add",
                type: "POST",
                data: data,
                success: function (data) {
                    console.log(data);
                    var decoded = JSON.parse(data);

                    if(typeof decoded['message']['content'] != undefined)
                        $('.content_er').html( decoded['message']['content']);
                    if(typeof decoded['message']['topic'] != undefined)
                        $('.topic_er').html( decoded['message']['topic']);
                    if(typeof decoded['message']['age'] != undefined)
                        $('.age_er').html( decoded['message']['age']);
                    if(typeof decoded['message']['lg'] != undefined && decoded['message']['lg'] != undefined) {
                        displayError(false, 'You cant add a topic to this community', 'topic_error');
                    }
                    if(decoded['status']){
                        displayError(true, decoded['message'],'topic_error');
                        $('#addTopic input[name="title"]').val('');
                        $('#addTopic textarea[name="content"]').val('');
                    }
                },
                error:function(){
                    displayError(false, 'could not connect to the server. reloading page might fix','topic_error');
                }
            });
        }else{
            displayError(false, 'No field can be left blank, please fill all appropiately','topic_error');
        }
    }

    function pageRedirect(page) {
        window.location.replace(page);
    }
    function Confirm(){
        $tr = confirm("Are you sure you want to delete this?");
        return $tr;
    }
</script>
