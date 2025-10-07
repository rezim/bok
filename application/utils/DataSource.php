<?php

class DataSource
{
    const MAIL     = 'mail';
    const PRINCITY = 'princity';
    const LEXMARK  = 'lexmark';
    const CANON      = 'canon'; // zmien na CANON
    const UNKNOWN  = null;

    const ALL = [
        self::MAIL,
        self::PRINCITY,
        self::LEXMARK,
        self::CANON
    ];
}