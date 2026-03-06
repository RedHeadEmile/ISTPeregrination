<?php

namespace ISTPeregrination\Services\Email;

interface IEmailService
{
    /**
     * Sends an email to the specified destination address with the given subject and body.
     * @param string $destAddress The email address of the recipient
     * @param string $destName The name of the recipient
     * @param string $subject The subject of the email
     * @param string $body The content of the email (can be HTML)
     * @return bool True if the email was sent successfully, False otherwise
     */
    function send(string $destAddress, string $destName, string $subject, string $body): bool;
}