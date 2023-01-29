<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Validation\CreditCardRules;
use CodeIgniter\Validation\FileRules;
use CodeIgniter\Validation\FormatRules;
use CodeIgniter\Validation\Rules;

class Validation extends BaseConfig
{
    // --------------------------------------------------------------------
    // Setup
    // --------------------------------------------------------------------

    /**
     * Stores the classes that contain the
     * rules that are available.
     *
     * @var string[]
     */
    public $ruleSets = [
        Rules::class,
        FormatRules::class,
        FileRules::class,
        CreditCardRules::class,
    ];

    /**
     * Specifies the views that are used to display the
     * errors.
     *
     * @var array<string, string>
     */
    public $templates = [
        'list'   => 'CodeIgniter\Validation\Views\list',
        'single' => 'CodeIgniter\Validation\Views\single',
    ];

    // --------------------------------------------------------------------
    // Rules
    // --------------------------------------------------------------------

    public $login = [
        'username' => 'required',
        'passwort' => 'required|min_length[8]',
        'agb' => 'required'
        ];

    public $login_errors = [
        'username' => [
            'required' => 'Bitte trage einen Username ein.'
        ],
        'passwort' => [
            'required' => 'Bitte trage ein Passwort ein.',
            'min_length' => 'Das Passwort muss mindestens 8 Stellen besitzen.'
        ],
        'agb' => [
            'required' => 'Bitte stimme den AGBs zu.'
        ],
    ];
}
