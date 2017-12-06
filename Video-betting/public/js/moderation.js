/**
 * Created by DELL on 5/8/2017.
 */

var moderation = function () {

    return {
        active: function (object, id) {

            if($(object).find('#active').is(':checked')){
                console.log( $(object).closest('.videobox2').html() );
                console.log('Active is checked');
                videoModerator.activateVideo(id, '1');
            }else {
                console.clear();
                console.log('active Unchecked');
                videoModerator.activateVideo(id, '0');
            }
        },
        featured: function (object, id) {

            if($(object).find('#featured').is(':checked')){
                console.log('Featured is checked');
                console.log( $(object).closest('.videobox2').html() );
                videoModerator.featureVideo(id, '1');
            }else {
                console.clear();
                console.log('Featured Unchecked');
                videoModerator.featureVideo(id, '0');
            }
        }
    }
}();


var videoModerator = function () {
    return {
        activateVideo: function (video_id, option) {
            $.ajax({
                type: "GET",
                url: "./video/moderate/active_inactive",
                data: {id: video_id, option: option},
                success: function (data) {
                    console.log(data);
                }
            });
        },
        featureVideo:function (video_id, option) {
            $.ajax({
                type: "GET",
                url: "./video/moderate/feature_un-feature",
                data: {id: video_id, option: option},
                success: function (data) {
                    console.log(data);
                }
            });
        }
    }
}();

$(document).ready(function () {

    $('figure').click(function () {
        //console.log( event.target.valueOf().id);
        var id = event.target.valueOf().id;
        var video_id = event.target.valueOf().value;
        if( id === 'featured'){
            moderation.featured( this, video_id);
            console.log(video_id);
        }else if( id  == 'active'){
            moderation.active(this, video_id);
            console.log(video_id);
        }

    });
});
