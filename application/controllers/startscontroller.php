<?php

class startsController extends Controller
{
    function show()
    {
        if (!defined('DISABLE_HTTPS') || !DISABLE_HTTPS) {
            redirectToHTTPS();
        } else {
            redirectToHTTP();
        }
    }

    function bladwywolania()
    {
        if (!defined('DISABLE_HTTPS') || !DISABLE_HTTPS) {
            redirectToHTTPS();
        } else {
            redirectToHTTP();
        }
    }
}
