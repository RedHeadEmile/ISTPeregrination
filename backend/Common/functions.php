<?php

use JetBrains\PhpStorm\NoReturn;

function currentTimeInMillis(): int
{
    return intval(round(microtime(true) * 1000));
}

/**
 * Get the JSON content sent by the client
 *
 * @param string[] $mandatory_fields The fields that must be present in the JSON (otherwise a 400 error is returned)
 * @param string[] $optional_fields The optional fields that can be present in the JSON
 * @return array The JSON content in the same order as the mandatory fields concatenated with the optional fields
 */
function json_body(array $mandatory_fields = [], array $optional_fields = []): array {
    $content = file_get_contents('php://input');
    $decoded = $content === false || strlen($content) === 0 ? [] : json_decode($content, true);
    if ($decoded === null)
        bad_request();

    $missing_fields = [];
    $sorted_fields = [];
    foreach ($mandatory_fields as $field) {
        if (!array_key_exists($field, $decoded))
            $missing_fields[] = $field;
        else {
            $sorted_fields[] = $decoded[$field];
            unset($decoded[$field]);
        }
    }

    if (count($missing_fields) > 0)
        bad_request('Missing field in JSON: ' . implode(', ', $missing_fields));

    foreach ($optional_fields as $field) {
        if (!array_key_exists($field, $decoded))
            $sorted_fields[] = null;
        else
            $sorted_fields[] = $decoded[$field];
    }

    return $sorted_fields;
}

/**
 * Send an error to the client with the given status code and reason
 * @param int $status_code The status code to send
 * @param ?string $reason The reason of the error
 * @return void
 */
#[NoReturn] function error(int $status_code, ?string $reason): void {
    http_response_code($status_code);
    echo json_encode(['status_code' => $status_code, 'error_message' => $reason]);
    exit();
}

/**
 * Return the status code 400 (bad request) with the given reason
 * @param string|null $reason The reason of the bad request
 * @return void
 */
#[NoReturn] function bad_request(?string $reason = null): void
{
    error(400, $reason);
}

#region Verify

/**
 * Check and process a give text
 * @param mixed $text The text to process
 * @param int $min_length The inclusive minimum length of the text
 * @param int $max_length The inclusive maximum length of the text
 * @param bool $allow_null If true, null is allowed
 * @param bool $allow_empty If true, empty string is allowed
 * @param bool $convert_to_null_if_empty If true, empty string will be converted to null
 * @param bool $trim If true, the text will be trimmed
 * @return string|null The processed text
 */
function verify_text(mixed $text, int $min_length = -1, int $max_length = -1, bool $allow_null = false, bool $allow_empty = false, bool $convert_to_null_if_empty = true, bool $trim = true): string|null
{
    if ($convert_to_null_if_empty && $text === '')
        $text = null;

    if ($text === null && !$allow_null)
        bad_request('Null text');

    if ($text === null)
        return null;

    if (gettype($text) !== 'string')
        bad_request('Invalid text');

    if ($trim)
        $text = trim($text);

    if ($text === '' && !$allow_empty)
        bad_request('Empty text');

    if ($min_length !== -1 && strlen($text) < $min_length)
        bad_request('Text too short');

    if ($max_length !== -1 && strlen($text) > $max_length)
        bad_request('Text too long');

    return $text;
}

/**
 * Check and process a given color
 * The color must be an integer between 0 and 16777215
 * @param mixed $color The color to process
 * @return int The processed color
 */
function verify_color(mixed $color): int
{
    if (gettype($color) === 'string') {
        if (preg_match('/\d+/', $color) === 1)
            $color = intval($color);
        else
            bad_request('Invalid color');
    }

    if (gettype($color) !== 'integer')
        bad_request('Invalid color');

    if ($color < 0 || $color > 16777215)
        bad_request('Invalid color');

    return $color;
}

/**
 * Check and process a given number
 * @param mixed $number The number to process
 * @param bool $must_be_positive If true, the number must be positive
 * @param bool $allow_zero If true, zero is allowed
 * @param bool $allow_null If true, null is allowed
 * @param ?int $min_value The minimum value the number should be (null to not check)
 * @param ?int $max_value The maximum value the number should be (null to not check)
 * @return ?int The processed number
 */
function verify_number(mixed $number, bool $must_be_positive = true, bool $allow_zero = false, bool $allow_null = false, ?int $min_value = null, ?int $max_value = null): ?int
{
    if (gettype($number) === 'string') {
        if (preg_match('/\d+/', $number) === 1)
            $number = intval($number);
        else if (strlen($number) !== 0)
            bad_request('Number cannot be empty: ' . $number);
        else
            $number = null;
    }

    if ($number === null && !$allow_null)
        bad_request('Number cannot be null: ' . $number);

    if ($number !== null) {
        if (gettype($number) !== 'integer')
            bad_request('Number is not an integer: ' . $number);

        if ($number < 0 && $must_be_positive)
            bad_request('Number must be positive: ' . $number);

        if ($number === 0 && !$allow_zero)
            bad_request('Number cannot be zero: ' . $number);

        if ($min_value !== null && $number < $min_value)
            bad_request('Number is too small: ' . $number);

        if ($max_value !== null && $number > $max_value)
            bad_request('Number is too big: ' . $number);
    }

    return $number;
}

/**
 * Verify a date input is in the format YYYY-MM-DD with valid values
 * @param mixed $raw_datetime The date to check
 * @param bool $with_time TRUE to have the hh:mm:ss.nnnnnn part, FALSE to just have YYYY-MM-DD
 * @param bool $allowEmpty TRUE to return null if the raw_datetime is empty or null, FALSE to raise a bad request if null or empty raw_datetime
 * @return ?string The date in the format YYYY-MM-DD hh:mm:ss.nnnnnn depending on "with_time"
 */
function verify_date(mixed $raw_datetime, bool $with_time = true, bool $remove_time = true, bool $allowEmpty = false): ?string {
    if ($allowEmpty && $raw_datetime === null || $raw_datetime === '')
        return null;

    if (gettype($raw_datetime) !== 'string')
        bad_request('Bad date format: ' . $raw_datetime);

    if (!$with_time && $remove_time && strlen($raw_datetime) > 10)
        $raw_datetime = substr($raw_datetime, 0, 10);

    $regex = '/^\d{4}-\d{2}-\d{2}$/';
    if ($with_time)
        $regex = '/^\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}\.\d{6}$/';

    if (preg_match($regex, $raw_datetime) !== 1)
        bad_request('Bad date format: ' . $raw_datetime);

    if ($with_time)
        list($date, $time) = explode(' ', $raw_datetime);
    else
        $date = $raw_datetime;

    list($year, $month, $day) = explode('-', $date);

    $year = intval($year);
    $month = intval($month);
    $day = intval($day);

    if ($year < 1970 || $year > 2037)
        bad_request('Date year is out of range');

    if ($month < 1 || $month > 12)
        bad_request('Date month is out of range');

    $max_day = [
        1 => 31,
        2 => 27,
        3 => 31,
        4 => 30,
        5 => 31,
        6 => 30,
        7 => 31,
        8 => 31,
        9 => 30,
        10 => 31,
        11 => 30,
        12 => 31
    ];
    if ($year % 400 === 0 || ($year % 4 === 0 && $year !== 100))
        $max_day[2] = 28;

    if ($day < 1 || $day > $max_day[$month])
        bad_request('Date day is out of range');

    if ($with_time) {
        list($hour, $minutes, $sec_and_nano) = explode(':', $time);
        list($seconds, $nano) = explode('.', $sec_and_nano);

        $hour = intval($hour);
        $minutes = intval($minutes);
        $seconds = intval($seconds);
        $nano = intval($nano);

        if ($hour > 23)
            bad_request('Date hour is out of range');

        if ($minutes > 59)
            bad_request('Date minute is out of range');

        if ($seconds > 59)
            bad_request('Date second is out of range');
    }

    return $date;
}

/**
 * @param mixed $value
 * @param bool $allow_null
 * @return bool|null
 */
function verify_bool(mixed $value, bool $allow_null = false): bool|null
{
    if ($value === null && !$allow_null)
        bad_request('Invalid boolean');

    if (gettype($value) === 'string') {
        if ($value === 'true')
            return true;
        if ($value === 'false')
            return false;
    }

    if (gettype($value) === 'integer') {
        if ($value === 1)
            return true;
        if ($value === 0)
            return false;
    }

    if (gettype($value) !== 'boolean')
        bad_request('Invalid boolean');

    return $value;
}

#endregion

