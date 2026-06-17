<?php
declare(strict_types=1);

const SMTP_HOST = 'mail.hostmeerkat.co.uk';
const SMTP_PORT = 465;
const SMTP_USERNAME = 'info@hostmeerkat.co.uk';
const SMTP_PASSWORD = ';S#@A44qdj=h^,)y';
const SMTP_TO = 'info@hostmeerkat.co.uk';
const FROM_NAME = 'HostMeerkat Contact Form';

function redirectWithStatus(string $status): never
{
    header('Location: index.html?contact=' . rawurlencode($status) . '#contact');
    exit;
}

function prefersJsonResponse(): bool
{
    $requestedWith = $_SERVER['HTTP_X_REQUESTED_WITH'] ?? '';
    $accept = $_SERVER['HTTP_ACCEPT'] ?? '';

    return strcasecmp($requestedWith, 'XMLHttpRequest') === 0
        || stripos($accept, 'application/json') !== false;
}

function respond(string $status, string $message, int $httpStatus = 200): never
{
    if (prefersJsonResponse()) {
        http_response_code($httpStatus);
        header('Content-Type: application/json; charset=UTF-8');
        echo json_encode([
            'success' => $status === 'success',
            'message' => $message,
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }

    redirectWithStatus($status);
}

function readSmtpResponse($socket): string
{
    $response = '';

    while (($line = fgets($socket, 515)) !== false) {
        $response .= $line;
        if (isset($line[3]) && $line[3] === ' ') {
            break;
        }
    }

    return $response;
}

function expectSmtpCode($socket, array $expectedCodes): void
{
    $response = readSmtpResponse($socket);
    $code = (int) substr($response, 0, 3);

    if (!in_array($code, $expectedCodes, true)) {
        throw new RuntimeException('Unexpected SMTP response: ' . trim($response));
    }
}

function sendSmtpCommand($socket, string $command, array $expectedCodes): void
{
    fwrite($socket, $command . "\r\n");
    expectSmtpCode($socket, $expectedCodes);
}

function sanitizeHeaderValue(string $value): string
{
    return trim(str_replace(["\r", "\n"], ' ', $value));
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    respond('error', 'Invalid request method.', 405);
}

$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$subject = trim($_POST['subject'] ?? '');
$message = trim($_POST['message'] ?? '');

if ($name === '' || $email === '' || $subject === '' || $message === '') {
    respond('error', 'Please fill in all required fields.', 422);
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    respond('error', 'Please enter a valid email address.', 422);
}

$safeName = sanitizeHeaderValue($name);
$safeEmail = sanitizeHeaderValue($email);
$safeSubject = sanitizeHeaderValue($subject);

$bodyText = "New contact form enquiry\n\n"
    . "Name: {$safeName}\n"
    . "Email: {$safeEmail}\n"
    . "Subject: {$safeSubject}\n\n"
    . "Message:\n{$message}\n";

$boundary = 'hostmeerkat-' . md5((string) microtime(true));
$encodedSubject = '=?UTF-8?B?' . base64_encode($safeSubject) . '?=';

$headers = [];
$headers[] = 'From: ' . FROM_NAME . ' <' . SMTP_USERNAME . '>';
$headers[] = 'Reply-To: ' . $safeName . ' <' . $safeEmail . '>';
$headers[] = 'MIME-Version: 1.0';
$headers[] = 'Content-Type: multipart/alternative; boundary="' . $boundary . '"';

$mimeMessage = '--' . $boundary . "\r\n"
    . "Content-Type: text/plain; charset=UTF-8\r\n"
    . "Content-Transfer-Encoding: 8bit\r\n\r\n"
    . $bodyText . "\r\n"
    . '--' . $boundary . "--\r\n";

try {
    $socket = stream_socket_client(
        'ssl://' . SMTP_HOST . ':' . SMTP_PORT,
        $errorNumber,
        $errorMessage,
        20,
        STREAM_CLIENT_CONNECT
    );

    if ($socket === false) {
        throw new RuntimeException('SMTP connection failed: ' . $errorMessage);
    }

    stream_set_timeout($socket, 20);

    expectSmtpCode($socket, [220]);
    sendSmtpCommand($socket, 'EHLO hostmeerkat.co.uk', [250]);
    sendSmtpCommand($socket, 'AUTH LOGIN', [334]);
    sendSmtpCommand($socket, base64_encode(SMTP_USERNAME), [334]);
    sendSmtpCommand($socket, base64_encode(SMTP_PASSWORD), [235]);
    sendSmtpCommand($socket, 'MAIL FROM:<' . SMTP_USERNAME . '>', [250]);
    sendSmtpCommand($socket, 'RCPT TO:<' . SMTP_TO . '>', [250, 251]);
    sendSmtpCommand($socket, 'DATA', [354]);

    $data = 'Subject: ' . $encodedSubject . "\r\n"
        . implode("\r\n", $headers) . "\r\n\r\n"
        . $mimeMessage . "\r\n.";

    fwrite($socket, $data . "\r\n");
    expectSmtpCode($socket, [250]);
    sendSmtpCommand($socket, 'QUIT', [221]);
    fclose($socket);

    respond('success', 'Your message has been sent successfully.');
} catch (Throwable $exception) {
    if (isset($socket) && is_resource($socket)) {
        fclose($socket);
    }

    respond('error', 'We could not send your message right now. Please try again.', 500);
}
