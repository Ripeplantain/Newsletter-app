<?php 

function send_mails($to, $subject, $message) {
    $headers = "From: Manny's Tech World";
    $to_string = implode(",", $to);
    mail($to_string, $subject, $message, $headers);

    return 'Mail sent successfully';    
}


function send_mail($to, $subject, $message) {
    $headers = "From: Manny's Tech World";
    mail($to, $subject, $message, $headers);

    return 'Mail sent successfully';    
}