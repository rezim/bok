<?php

class DataSource
{
    const MAIL     = 'mail';
    const PRINCITY = 'princity';
    const LEXMARK  = 'lexmark';
    const CSV      = 'csv'; // zmien na CANON
    const UNKNOWN  = null;

    const ALL = [
        self::MAIL,
        self::PRINCITY,
        self::LEXMARK,
        self::CSV
    ];
}