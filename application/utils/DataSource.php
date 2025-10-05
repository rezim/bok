<?php

class DataSource
{
    const MAIL     = 'mail';
    const PRINCITY = 'princity';
    const LEXMARK  = 'lexmark';
    const CSV      = 'csv';
    const UNKNOWN  = null;

    const ALL = [
        self::MAIL,
        self::PRINCITY,
        self::LEXMARK,
        self::CSV
    ];
}