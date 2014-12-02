(function() {
    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
    po.src = 'https://apis.google.com/js/client:plusone.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
})();

function signinCallback(authResult) {
    if (authResult['access_token']) {
    // Autorisation réussie
        //$('.fb_iframe_widget').hide();
        //$('#signinButton').hide();
        gapi.client.load('oauth2', 'v2', function() {
            var request = gapi.client.oauth2.userinfo.get();
            request.execute(function (response) {
                console.log(response.email);
                $('#GPlusLoginEmail').val(response.email);
                $('#GPlusLoginLoginForm').submit();
                //$(".logoutBtn").click(disconnectUser(authResult['access_token']));
                //document.getElementById('SignupEmailAddress').disabled = true;
            });
        });
  } else if (authResult['error']) {
    // Une erreur s'est produite.
    // Codes d'erreur possibles :
    //   "access_denied" - L'utilisateur a refusé l'accès à votre application
    //   "immediate_failed" - La connexion automatique de l'utilisateur a échoué
    // console.log('Une erreur s'est produite : ' + authResult['error']);
  }
}

function disconnectUser(access_token) {
    var revokeUrl = 'https://accounts.google.com/o/oauth2/revoke?token=' +
        access_token;

      // Exécuter une requête GET asynchrone.
    $.ajax({
        type: 'GET',
        url: revokeUrl,
        async: false,
        contentType: "application/json",
        dataType: 'jsonp',
        success: function(nullResponse) {
          // Effectuer une action maintenant que l'utilisateur est dissocié
          // La réponse est toujours non définie.
        },
        error: function(e) {
          // Gérer l'erreur
          // console.log(e);
          // Orienter éventuellement les utilisateurs vers une dissociation manuelle en cas d'échec
          // https://plus.google.com/apps
        }
    });
}