<?php

// Validation function
function validate($item, $field_name)
{
    global $error;

    // Check if the field is empty
    if (empty($item) && !in_array($field_name, ['email', 'subject', 'product'])) {
        $error[$field_name] = ucfirst($field_name) . " is required.";
        return false;
    }

    // Additional validation for name (no numbers allowed)
    if ($field_name == 'name') {
        // Ensure the name only contains letters, spaces, apostrophes, or hyphens
        if (!preg_match("/^[a-zA-Z\s'-]+$/", $item)) {
            $error[$field_name] = "The $field_name contains only letters.";
            return false;
        }
    }

    // Additional validation for email
    if ($field_name == 'email' && !empty($item)) {
        if (!filter_var($item, FILTER_VALIDATE_EMAIL)) {
            $error[$field_name] = "Please enter a valid email address.";
            return false;
        }
    }

    // Additional validation for subject (max length 30 characters)
    if ($field_name == 'subject' && !empty($item)) {
        if (strlen($item) > 30) {
            $error[$field_name] = "The $field_name should not exceed 30 characters.";
            return false;
        }

        // Ensure the subject only contains letters, spaces, apostrophes, or hyphens
        if (!preg_match("/^[a-zA-Z\s'-]+$/", $item)) {
            $error[$field_name] = "The $field_name contains only letters.";
            return false;
        }
    }

    // Additional validation for contact number (max length 30 characters)
    if ($field_name == 'contact_number') {
        if (strlen($item) > 12 || strlen($item) < 10) {
            $error[$field_name] = "The contact number should be between 10 to 12 digits.";
            return false;
        }

        // Ensure the contact number contains only numbers
        if (!preg_match("/^[0-9]{10,12}$/", $item)) {
            $error[$item] = "The contact number should only contain numbers.";
            return false;
        }
    }



    // Additional validation for message (max length 200 characters)
    if ($field_name == 'message') {
        if (strlen($item) > 200) {
            $error[$field_name] = "The requirement details should not exceed 200 characters.";
            return false;
        }
    }


    return true;
}

// Error response function
function errorResponse($error, $status, $message = null)
{
    http_response_code($status);
    // Prepare JSON response
    $response = json_encode([
        'status' => $status,
        'errors' => $error,
        'message' => $message
    ]);

    // Return the response
    return $response;
}


// Success response function
function successResponse($status, $message)
{
    http_response_code(200);
    // Prepare JSON response
    $response = json_encode([
        'status' => $status,
        'message' => $message
    ]);

    // Return the response
    return $response;
}


// build email body 

function buildEmailBody($message)
{
    return "
    <!DOCTYPE html>
    <html lang='en'>

    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <meta http-equiv='X-UA-Compatible' content='ie=edge'>
        <title>Yogeshwar Profile - Inquiry</title>
        <style>
            /* Body Style */
            body {
                font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
                background-color: #f4f4f4;
                margin: 0;
                padding: 0;
            }

            /* Table Layout */
            table {
                width: 100%;
                border: 0;
                cellpadding: 0;
                cellspacing: 0;
            }

            td {
                padding: 15px;
                vertical-align: top;
            }

            .container {
                max-width: 600px;
                margin: 0 auto;
                background-color: #ffffff;
            }

            /* Button Styles */
            .btn {
                display: inline-block;
                font-weight: 400;
                text-align: center;
                vertical-align: middle;
                cursor: pointer;
                background-color: #007bff;
                color: #fff !important;
                padding: 0.375rem 0.75rem;
                border-radius: 0.2rem;
                text-decoration: none;
            }

            /* Responsive Media Query for Mobile */
            @media (max-width: 600px) {
                td {
                    width: 100% !important;
                    display: block !important;
                }
            }
        </style>
    </head>

    <body>
        <div class='container'>
            <!-- Row 1: Logo -->
            <table role='presentation'>
                <tr>
                    <td style='text-align: center;'>
                        <a href='http://localhost/YogeshwarProfile/index.php'>
                            <img src='assets/images/logo.svg' alt='Yogeshwar Profile'
                                style='max-width: 100%; height: auto;'>
                        </a>
                    </td>
                </tr>
            </table>

            <!-- Row 2: Subject -->
            <table role='presentation'>
                <tr>
                    <td style='text-align: center;'>
                        <h2>Inquiry</h2>
                    </td>
                </tr>
            </table>

            <hr>

            <!-- Row 3: Main Content -->
            <table role='presentation'>
                <tr>
                    <td style='text-align: center;'>
                        <div class='row'>
                            <div class='col text-center'> 
                                <table>
                                    <tbody>
                                        $message
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </td>
                </tr>
            </table>

            <hr>

            <!-- Row 5: Footer -->
            <table role='presentation'>
                <tr>
                    <td style='text-align: center;'>
                        <p>Copyright &copy; <?= date('Y') ?> Yogeshwar Profile

                            - Designed & Developed By <a rel='nofollow noopener' href='https://oceanmnc.com'
                                target='_blank'>OceanMNC</a>
                        </p>
                    </td>
                </tr>
            </table>
        </div>
    </body>

    </html>
 ";
}