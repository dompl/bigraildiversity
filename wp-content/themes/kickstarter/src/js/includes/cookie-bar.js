/**
 * Cookie bar
 * Documantation : https://github.com/kiuz/jquery-cookie-bar/blob/master/index.html
 * ---
 */
$.cookieBar({
    message: 'Please note our website uses cookies to improve your experience.', //Message displayed on bar
    acceptButton: true, //Set to true to show accept/enable button
    acceptText: '<span class="ud">I Understand</span>', //Text on accept/enable button
    acceptFunction: function(cookieValue) {
        if (cookieValue != 'enabled' && cookieValue != 'accepted') window.location = window.location.href;
    }, //Function to run after accept
    declineButton: false, //Set to true to show decline/disable button
    declineText: 'Disable Cookies', //Text on decline/disable button
    declineFunction: function(cookieValue) {
        if (cookieValue == 'enabled' || cookieValue == 'accepted') window.location = window.location.href;
    }, //Function to run after decline
    policyButton: true, //Set to true to show Privacy Policy button
    policyText: 'Privacy Statement & Cookie Notice', //Text on Privacy Policy button
    policyURL: '/privacy-statement', //URL of Privacy Policy
    autoEnable: true, //Set to true for cookies to be accepted automatically. Banner still shows
    acceptOnContinue: false, //Set to true to accept cookies when visitor moves to another page
    acceptOnScroll: false, //Set to true to accept cookies when visitor scrolls X pixels up or down
    acceptAnyClick: false, //Set to true to accept cookies when visitor clicks anywhere on the page
    expireDays: 365, //Number of days for cookieBar cookie to be stored for
    renewOnVisit: false, //Renew the cookie upon revisit to website
    forceShow: false, //Force cookieBar to show regardless of user cookie preference
    effect: 'slide', //Options: slide, fade, hide
    element: 'body', //Element to append/prepend cookieBar to. Remember "." for class or "#" for id.
    append: false, //Set to true for cookieBar HTML to be placed at base of website. Actual position may change according to CSS
    fixed: false, //Set to true to add the class "fixed" to the cookie bar. Default CSS should fix the position
    bottom: false, //Force CSS when fixed, so bar appears at bottom of website
    zindex: '', //Can be set in CSS, although some may prefer to set here
    domain: String(window.location.hostname), //Location of privacy policy
    referrer: String(document.referrer) //Where visitor has come from
});
