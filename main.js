const urlParams = new URLSearchParams(window.location.search);
if (urlParams.has('success') && urlParams.get('success') === 'true') {
    alert('Thank you for submitting, we will get in touch with you as soon as possible!');
}