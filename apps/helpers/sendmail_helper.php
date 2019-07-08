<?php if(!defined("BASEPATH")) exit("No direct script access allowed");

if(!function_exists("sendmail")){
    function sendmail($to, $ticket_no, $body){   
        $subject = "EODB SUPPORT-[".$ticket_no."]";
        $frmMail = "support@easeofdoingbusinessinassam.in";
        $frmName = "EODB Government of Assam";
	$ci = & get_instance();
        $ci->load->library("email");
        $ci->email->initialize(array(
            "protocol" => "smtp",
            "smtp_host" => "ssl://mail.easeofdoingbusinessinassam.in",
            "smtp_user" => "support@easeofdoingbusinessinassam.in",
            "smtp_pass" => "Ease@20#AIPL18",
            "smtp_port" => 465,
            "mailtype" => "html",
            "charset" => "iso-8859-1",
            "wordwrap" => TRUE,
            "crlf" => "\r\n",
            "newline" => "\r\n"
        ));
        $ci->email->from($frmMail, $frmName);
        $ci->email->to($to);
        $ci->email->subject($subject);
        $ci->email->message($body);
        if ($ci->email->send()) {
            return "Email sent.";
        } else {
            return $ci->email->print_debugger();
        }//End of if else
    } // End of sendmail()
} // End of if