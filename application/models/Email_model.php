<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . "third_party/swiftmailer/vendor/autoload.php";

class Email_model extends CI_Model
{
    //send email
    public function send_email($to, $subject, $message, $show_unsubscribe, $link)
    {
        $data = array(
            'title' => $subject,
            'content' => $message,
            'email' => $to,
            'show_unsubscribe' => $show_unsubscribe,
            'link' => $link
        );
        try {
            // Create the Transport
            $transport = (new Swift_SmtpTransport($this->general_settings->mail_host, $this->general_settings->mail_port, 'tls'))
                ->setUsername($this->general_settings->mail_username)
                ->setPassword($this->general_settings->mail_password);

            // Create the Mailer using your created Transport
            $mailer = new Swift_Mailer($transport);

            // Create a message
            $message = (new Swift_Message($this->settings->application_name))
                ->setFrom(array($this->general_settings->mail_username => $this->settings->application_name))
                ->setTo([$to => ''])
                ->setSubject($subject)
                ->setBody($this->load->view("email/email_template", $data, TRUE), 'text/html');

            //Send the message
            $result = $mailer->send($message);
            if ($result) {
                return true;
            }
        } catch (\Swift_TransportException $Ste) {
            $this->session->set_flashdata('error', $Ste->getMessage());
            return false;
        } catch (\Swift_RfcComplianceException $Ste) {
            $this->session->set_flashdata('error', $Ste->getMessage());
            return false;
        }
    }
}