<?php

function messageSuccess($string)
{
    return '<p class="message-good">' . $string . ' was successful</p>';
}

function messageFailure($string)
{
    return '<p class="message-bad">' . $string . ' failed; please try again later</p>';
}
