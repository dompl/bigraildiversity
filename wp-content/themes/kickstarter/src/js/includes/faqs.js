$('.faq-question').on('click', function() {
    $(this).next('.faq-answer').slideToggle();
    $('.faq-question').not(this).next('.faq-answer').slideUp();
});
