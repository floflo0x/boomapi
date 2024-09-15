<?php
header("Access-Control-Allow-Origin: *");
// Set the timezone to USA (example: New York)
date_default_timezone_set('America/New_York');

// Define the given date and time
$date2_str = $_POST['date'];

// Create DateTime objects
$date1 = new DateTime(); // Current date and time
$date2 = new DateTime($date2_str);

// Calculate the difference
$interval = $date1->diff($date2);

// Convert the difference to a human-readable format
function time_ago($interval) {
    if ($interval->y > 0) {
        return $interval->y . ' year' . ($interval->y > 1 ? 's' : '') . ' ago';
    } elseif ($interval->m > 0) {
        return $interval->m . ' month' . ($interval->m > 1 ? 's' : '') . ' ago';
    } elseif ($interval->d > 0) {
        return $interval->d . ' day' . ($interval->d > 1 ? 's' : '') . ' ago';
    } elseif ($interval->h > 0) {
        return $interval->h . ' hour' . ($interval->h > 1 ? 's' : '') . ' ago';
    } elseif ($interval->i > 0) {
        return $interval->i . ' minute' . ($interval->i > 1 ? 's' : '') . ' ago';
    } else {
        return $interval->s . ' second' . ($interval->s > 1 ? 's' : '') . ' ago';
    }
}

// Display the result
echo time_ago($interval);
?>
