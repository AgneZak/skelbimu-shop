<?php
require '../bootloader.php';

if (is_logged_in()) {
    header("Location: login.php");
    exit();
}

$nav = nav();
$form = [
    'attr' => [
        'method' => 'POST'
    ],
    'fields' => [
        'name' => [
            'label' => 'Name',
            'type' => 'text',
            'validators' => [
                'validate_field_not_empty',
                'validate_no_numbers'
            ],
            'extra' => [
                'attr' => [
                    'placeholder' => 'Name',
                    'class' => 'input-field'
                ]
            ]
        ],
        'surname' => [
            'label' => 'Surname',
            'type' => 'text',
            'validators' => [
                'validate_field_not_empty',
                'validate_no_numbers'
            ],
            'extra' => [
                'attr' => [
                    'placeholder' => 'Surname',
                    'class' => 'input-field'
                ]
            ]
        ],
        'address' => [
            'label' => 'Address',
            'type' => 'text',
            'validators' => [
                'validate_field_not_empty',
                'validate_no_numbers'
            ],
            'extra' => [
                'attr' => [
                    'placeholder' => 'Address',
                    'class' => 'input-field'
                ]
            ]
        ],
        'email' => [
            'label' => 'Email',
            'type' => 'email',
            'validators' => [
                'validate_field_not_empty',
                'validate_user_unique',
                'validate_email'
            ],
            'extra' => [
                'attr' => [
                    'placeholder' => 'email@mail',
                    'class' => 'input-field'
                ]
            ]
        ],
        'password' => [
            'label' => 'Password',
            'type' => 'password',
            'validators' => [
                'validate_field_not_empty',
                'validate_is_number',
                'validate_number_of_symbols'
            ],
            'extra' => [
                'attr' => [
                    'placeholder' => 'Password',
                    'class' => 'input-field'
                ]
            ]
        ],
        'password_repeat' => [
            'label' => 'Password repeat',
            'type' => 'password',
            'validators' => [
                'validate_field_not_empty',
            ],
            'extra' => [
                'attr' => [
                    'placeholder' => 'Repeat password',
                    'class' => 'input-field'
                ]
            ]
        ],
    ],
    'buttons' => [
        'submit' => [
            'title' => 'Registruokis',
            'type' => 'submit',
            'extra' => [
                'attr' => [
                    'class' => 'btn'
                ]
            ]
        ],
        'clear' => [
            'title' => 'Clear',
            'type' => 'reset',
            'extra' => [
                'attr' => [
                    'class' => 'btn'
                ]
            ]
        ]
    ],
    'validators' => [
        'validate_field_match' => [
            'password',
            'password_repeat'
        ],
    ]
];

$clean_inputs = get_clean_input($form);

if ($clean_inputs) {
    $success = validate_form($form, $clean_inputs);

    if ($success) {
        unset($clean_inputs['password_repeat']);

        $rows = file_to_array(ROOT . '/app/data/db.json');
        $rows['users'][] = $clean_inputs + ['items' => 0];

        array_to_file($rows, ROOT . '/app/data/db.json');

        $p = 'Sveikinu uzsireginus';

        header("Location: login.php");
    } else {
        $p = 'Eik nx';
    }
}


?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style.css">
    <title>Register</title>
</head>
<body>
<main>
    <?php require ROOT . '/app/templates/nav.tpl.php'; ?>
    <article class="wrapper">
        <h1 class="header header--main">Reginkis</h1>
        <?php require ROOT . '/core/templates/form.tpl.php'; ?>
        <?php if (isset ($p)): ?>
            <p><?php print $p; ?></p>
        <?php endif; ?>
    </article>
</main>
</body>
</html>