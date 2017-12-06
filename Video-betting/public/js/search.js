var user = function () {
    return {
        search: function (text) {
            console.log(text);
            /*
            $.ajax({
                type:"GET",
                url:"./search",
                data:{text:text},
                success:function (data) {
                    //console.log(data);
                },
                error:function (data) {
                    console.log(data);
                }
            })
            */
        }
    }
}();

$(document).ready(function () {
    //style="height: 500px; overflow: scroll; overflow-x: hidden;"
    if($('#videos-search').height() > 500){
        //console.log( $('#videos-search').height() );
        var style={height: "500px", overflow: "scroll", }
        $('#videos-search').css(style);
        $('#videos-search').css("overflow-x", "hidden");
    }
    if($('#artists-search').height() > 500){
        //console.log( $('#artists-search').height() );
        var style={height: "500px", overflow: "scroll",}
        $('#artists-search').css(style);
        $('#artists-search').css("overflow-x", "hidden");
    }
});