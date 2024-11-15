<!-- Footer Starts Here -->
<footer>
    <div class="container">
        <div class="row">
            <div class="col-md-3 footer-item">
                <h4 id="footerlogotext">
                    <span>Yogeshwar profile</span>
                    <span class="footerlogotextspan"> Progressive and innovative by nature </span>
                </h4>
                <p><i class="fa fa-clock-o"></i> Opening Time</p>
                <p>Mon-Sat 09:00 AM-05:00 PM</p>
                <p><i class="fa fa-map-marker"></i> Address</p>
                <p>Plot No. 1215, Phase 3, Vatva GIDC, Ahmedabad, Gujarat 382445</p>
                <ul class="social-icons">
                    <li><a href="tel:+919824006091"><i class="fa fa-phone"></i></a></li>
                    <li><a href="mailto:yogeshwarprofile@gmail.com"><i class="fa fa-envelope"></i></a></li>
                </ul>
            </div>
            <div class="col-md-3 footer-item">
                <h4>Our Products</h4>
                <ul class="menu-list">
                    <li><a href="#products">Mild steel plates</a></li>
                    <li><a href="#products">Boiler and Pressure vessel steel</a></li>
                    <li><a href="#products">Structural steel plates</a></li>
                    <li><a href="#products">High tensile steel plates</a></li>
                    <li><a href="#products">C-45 plates</a></li>
                </ul>
            </div>
            <div class="col-md-3 footer-item">
                <h4>Additional Pages</h4>
                <ul class="menu-list">
                    <li><a href="#about">About Us</a></li>
                    <li><a href="#products">Our Products</a></li>
                    <!-- <li><a href="#">Quick Support</a></li> -->
                    <li><a href="#getquote">Contact Us</a></li>
                    <li><a href="#">Privacy Policy</a></li>
                </ul>
            </div>
            <div class="col-md-3 footer-item last-item">
                <h4>Request a Callback</h4>
                <div class="contact-form">
                    <form id="contact footer-contact" class="php-email-form" action="contactform.php" method="post">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <fieldset>
                                    <input type="hidden" name="form-name" value="contactform">
                                    <input name="name" type="text" class="form-control" id="name"
                                        placeholder="Full Name*" required="">
                                    <div class="error-msg" id="error-name"></div>
                                </fieldset>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <fieldset>
                                    <input name="contact_number" type="text" class="form-control" id="contact_number"
                                        oninput="this.value = this.value.replace(/[^0-9]/g, '');" maxlength="12"
                                        placeholder="Contact Number*" required="">
                                    <div class="error-msg" id="error-contact_number"></div>
                                </fieldset>
                            </div>
                            <div class="col-lg-12">
                                <fieldset>
                                    <textarea name="message" rows="6" class="form-control" id="message"
                                        placeholder="Your Message"></textarea>
                                    <div class="error-msg" id="error-message"></div>
                                </fieldset>
                            </div>
                            <div class="col-lg-12">
                                <fieldset>
                                    <button type="submit" id="form-submit" class="filled-button">
                                        Request
                                    </button>
                                </fieldset>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</footer>

<div class="sub-footer">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <p>Copyright &copy; <?= date('Y') ?> Yogeshwar Profile

                    - Designed & Developed By <a rel="nofollow noopener" href="https://oceanmnc.com"
                        target="_blank">Ocean MNC</a>
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap core JavaScript -->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Additional Scripts -->
<script src="assets/js/jquery.singlePageNav.min.js"></script>
<script src="assets/js/custom.js"></script>
<script src="assets/js/owl.js"></script>
<script src="assets/js/slick.js"></script>
<script src="assets/js/accordions.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script>
    $(function () {
        // Single Page Nav
        $('#navbarResponsive').singlePageNav({
            'offset': 100,
            'filter': ':not(.external)'
        });

        // On mobile, close the menu after nav-link click
        $('#navbarResponsive .navbar-nav .nav-item .nav-link').click(function () {
            $('#navbarResponsive').removeClass('show');
        });
    });
</script>

<script language="text/Javascript">
    cleared[0] = cleared[1] = cleared[2] = 0; //set a cleared flag for each field
    function clearField(t) { //declaring the array outside of the
        if (!cleared[t.id]) { // function makes it static and global
            cleared[t.id] = 1; // you could use true and false, but that's more typing
            t.value = ''; // with more chance of typos
            t.style.color = '#fff';
        }
    }
</script>

<script>
    $('document').ready(function () {

        $(document).on('click', 'a.filled-button', function () {
            var this_product = $(this);
            var productValue = this_product.data('value');
            $('#product').val(productValue);
        });

        $('form.php-email-form').on('submit', function (e) {
            e.preventDefault();  // Prevent the default form submission
            var this_form = $(this); // Store the form for later use
            this_form.find('.error-msg').text('');  // Clear previous error messages

            var formData = new FormData(this); // Form data for the AJAX request
            var action = $(this).attr('action'); // Get the action URL from the form attribute
            var submitBtn = this_form.find("input[type='submit'], button[type='submit']")
            var oldSubmitBtnText = submitBtn.text(); // Get submit button text
            // Hide submit buttons during AJAX request
            submitBtn.prop('disabled', true).text('Please Wait...'); // disable submit btn

            // Get the reCAPTCHA token
            grecaptcha.execute('<?= $RECAPTCHA_SITE_KEY ?>', { action: 'submit' }).then(function (token) {
                // Add the token to the form data
                formData.append('g-recaptcha-response', token);

                // Perform the AJAX request
                $.ajax({
                    url: action,
                    type: 'POST',
                    data: formData,
                    processData: false,  // Don't process data
                    contentType: false,  // Don't set content type (important for FormData)
                    success: function (response) {
                        // Handle server response
                        if (response.status == 200) {
                            // Success, reset the form and show a success message
                            submitBtn.prop('disabled', false).text(oldSubmitBtnText);
                            this_form[0].reset();  // Reset the form
                            toastr.success(response.message);
                        } else {
                            // Handle server error (500)
                            toastr.error(response.message || "Internal server error.");
                        }
                    },
                    error: function (xhr, status, error) {
                        // Enable the submit buttons after an error occurs
                        this_form.find("input[type='submit'], button[type='submit']").prop('disabled', false).text(oldSubmitBtnText);
                        if (xhr.status === 422) {
                            // Validation errors returned by the server (422 Unprocessable Entity)
                            var errors = xhr.responseJSON.errors;
                            $.each(errors, function (key, value) {
                                // Display the validation error for each field
                                this_form.find('#error-' + key).text(value);
                            });
                        } else if (xhr.status === 500) {
                            // Handle general server error (500)
                            var errorMessage = xhr.responseText ? xhr.responseText : "Internal server error.";
                            toastr.error(errorMessage);
                        } else {
                            // Handle other errors (network issues, etc.)
                            var errorMessage = "An unexpected error occurred.";
                            toastr.error(errorMessage);
                        }
                    }
                });
            });
        });
    });
</script>



</body>

</html>