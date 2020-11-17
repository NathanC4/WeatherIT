<?php

function messageSuccess($string): string
{
    return '<p class="message-good">' . $string . ' was successful</p>';
}

function messageFailure($string): string
{
    return '<p class="message-bad">' . $string . ' failed; please try again later</p>';
}
