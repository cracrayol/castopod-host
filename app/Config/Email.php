<?php

declare(strict_types=1);

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Email extends BaseConfig
{
    public $fromEmail;

    public $fromName;

    public $recipients;

    /**
     * The "user agent"
     */
    public $userAgent = 'CodeIgniter';

    /**
     * The mail sending protocol: mail, sendmail, smtp
     */
    public $protocol = 'mail';

    /**
     * The server path to Sendmail.
     */
    public $mailPath = '/usr/sbin/sendmail';

    /**
     * SMTP Server Address
     */
    public $SMTPHost;

    /**
     * SMTP Username
     */
    public $SMTPUser;

    /**
     * SMTP Password
     */
    public $SMTPPass;

    /**
     * SMTP Port
     */
    public $SMTPPort = 25;

    /**
     * SMTP Timeout (in seconds)
     */
    public $SMTPTimeout = 5;

    /**
     * Enable persistent SMTP connections
     */
    public $SMTPKeepAlive = false;

    /**
     * SMTP Encryption. Either tls or ssl
     */
    public $SMTPCrypto = 'tls';

    /**
     * Enable word-wrap
     */
    public $wordWrap = true;

    /**
     * Character count to wrap at
     */
    public $wrapChars = 76;

    /**
     * Type of mail, either 'text' or 'html'
     */
    public $mailType = 'text';

    /**
     * Character set (utf-8, iso-8859-1, etc.)
     */
    public $charset = 'UTF-8';

    /**
     * Whether to validate the email address
     */
    public $validate = false;

    /**
     * Email Priority. 1 = highest. 5 = lowest. 3 = normal
     */
    public $priority = 3;

    /**
     * Newline character. (Use “\r\n” to comply with RFC 822)
     */
    public $CRLF = "\r\n";

    /**
     * Newline character. (Use “\r\n” to comply with RFC 822)
     */
    public $newline = "\r\n";

    /**
     * Enable BCC Batch Mode.
     */
    public $BCCBatchMode = false;

    /**
     * Number of emails in each BCC batch
     */
    public $BCCBatchSize = 200;

    /**
     * Enable notify message from server
     */
    public $DSN = false;
}
