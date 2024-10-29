<?php
/**
 * SimpleEmailServiceError Class Doc Comment.
 * see http://docs.aws.amazon.com/ses/latest/DeveloperGuide/api-error-codes.html
 *
 * Amazon SimpleEmailService for PHP.
 *
 * @category Class
 * @package  AmazonSimpleEmailService
 * @author   Okamos <okamoto@okamos.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://github.com/okamos/php-ses
 */
class SimpleEmailServiceError
{
    // SES errors
    const CONFIGURATION_SET_DOES_NOT_EXIST = 'The specified configuration set does not exist.A configuration set is an optional parameter that you use to publish email sending events.';
    const INCOMPLETE_SIGNATURE = 'The request signature does not conform to AWS standards.';
    const INTERNAL_FAILURE = 'The request processing has failed because of an unknown error, exception, or failure.';
    const INVALID_ACTION = 'The requested action or operation is invalid. Verify that the action is typed correctly.';
    const INVALID_CLIENT_TOKEN_ID = 'The X.509 certificate or AWS access key ID provided does not exist in our records.';
    const INVALID_PARAMETER_COMBINATION = 'Parameters that must not be used together were used together.';
    const INVALID_PARAMETER_VALUE = 'An invalid or out-of-range value was supplied for the input parameter.';
    const INVALID_QUERY_PARAMETER = 'The AWS query string is malformed, does not adhere to AWS standards.';
    const MAIL_FROM_DOMAIN_NOT_VERIFIED = 'The message could not be sent because Amazon SES could not read the MX record required to use the specified MAIL FROM domain.';
    const MALFORMED_QUERY_STRING = 'The query string contains a syntax error.';
    const MESSAGE_REJECTED = 'Indicates that the action failed, and the message could not be sent.
Check the error stack for a description of what caused the error.';
    const MISSING_ACTION = 'The request is missing an action or a required parameter.';
    const MISSING_AUTHENTICATION_TOKEN = 'The request must contain either a valid (registered) AWS access key ID or X.509 certificate.';
    const MISSING_PARAMETER = 'A required parameter for the specified action is not supplied.';
    const OPT_IN_REQUIRED = 'The AWS access key ID needs a subscription for the service.';
    const REQUEST_EXPIRED = 'The request reached the service more than 15 minutes after the date stamp on the request or more than 15 minutes after the request expiration date (such as for pre-signed URLs), or the date stamp on the request is more than 15 minutes in the future.';
    const SERVICE_UNAVAILABLE = 'The request failed due to a temporary failure of the server.';
    const THROTTLING = 'The request was denied due to request throttling.';
    const VALIDATION_ERROR = '1 validation error detected: Value null at identities failed to satisfy constraint: Member must notbe null';

    // common errors
    const ACCESS_DENIED_EXCEPTION = 'You do not have sufficient access to perform this action.';

    /**
     * Construct
     *
     * @param string $errorCode SES error code
     */
    public function __construct($errorCode, $message)
    {
        $this->code = $errorCode;
        switch ($errorCode) {
        case 'AccessDeniedException':
            $this->description = self::ACCESS_DENIED_EXCEPTION;
            break;
        case 'ConfigurationSetDoesNotExist':
            $this->description = self::CONFIGURATION_SET_DOES_NOT_EXIST;
            break;
        case 'SignatureDoesNotMatch':
            $this->description = self::INCOMPLETE_SIGNATURE;
            break;
        case 'InternalFailure':
            $this->description = self::INTERNAL_FAILURE;
            break;
        case 'InvalidAction':
            $this->description = self::INVALID_ACTION;
            break;
        case 'InvalidClientTokenId':
            $this->description = self::INVALID_CLIENT_TOKEN_ID;
            break;
        case 'InvalidParameterCombination':
            $this->description = self::INVALID_PARAMETER_COMBINATION;
            break;
        case 'InvalidParameterValue':
            $this->description = self::INVALID_PARAMETER_VALUE;
            break;
        case 'InvalidQueryParameter':
            $this->description = self::INVALID_QUERY_PARAMETER;
            break;
        case 'MailFromDomainNotVerified':
            $this->description = self::MAIL_FROM_DOMAIN_NOT_VERIFIED;
            break;
        case 'MalformedQueryString':
            $this->description = self::MALFORMED_QUERY_STRING;
            break;
        case 'MessageRejected':
            $this->description = self::MESSAGE_REJECTED;
            break;
        case 'MissingAction':
            $this->description = self::MISSING_ACTION;
            break;
        case 'MissingAuthenticationToken':
            $this->description = self::MISSING_AUTHENTICATION_TOKEN;
            break;
        case 'MissingParameter':
            $this->description = self::MISSING_PARAMETER;
            break;
        case 'OptInRequired':
            $this->description = self::OPT_IN_REQUIRED;
            break;
        case 'RequestExpired':
            $this->description = self::REQUEST_EXPIRED;
            break;
        case 'ServiceUnavailable':
            $this->description = self::SERVICE_UNAVAILABLE;
            break;
        case 'Throttling':
            $this->description = self::THROTTLING;
            break;
        case 'ValidationError':
            $this->description = self::VALIDATION_ERROR;
            break;
        case 'Destination':
            $this->description = 'The destination composed To: or CC:, Bcc: is required.';
            break;
        case 'EmailSource':
            $this->description = 'The email From: is required.';
            break;
        case 'EmailSubject':
            $this->description = 'The email Subject: is required.';
            break;
        case 'EmailBody':
            $this->description = 'The email Body: is required.';
            break;
        }
        $this->message = $message;
    }
}
