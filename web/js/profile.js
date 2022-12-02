

Profile = {
    initMyProfile: function() {
        $('#collapse-summary').click(function(){
           $('#profile-summary').slideToggle();
           $('#collapse-summary').toggleClass('togarw-up-lgt togarw-dn-lgt');
        });
    },
    
    initQuickUserProfile: function() {
        if($('#quick-user-info').length) {
            $('#collapse-qui-detail').click(function(){
                $('#qui-detail').slideToggle();
                $('#collapse-qui-detail').toggleClass('togarw-up-drk togarw-dn-drk');
            });
        }   
    }
};


$(document).ready(function(){

    if($('#my-profile').length) {
        Profile.initMyProfile();
    }
});

