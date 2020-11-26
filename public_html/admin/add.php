<?php
require '../../bootloader.php';

if (!is_logged_in()) {
    header("Location: /login.php");
    exit();
}

$nav = nav();

$form = [
    'attr' => [
        'method' => 'POST'
    ],
    'fields' => [
        'name' => [
            'label' => 'Product name',
            'type' => 'text',
            'value' => '',
            'validators' => [
                'validate_field_not_empty'
            ],
            'extra' => [
                'attr' => [
                    'placeholder' => 'Sock',
                    'class' => 'input-field'
                ]
            ]
        ],
        'price' => [
            'label' => 'Price',
            'type' => 'number',
            'value' => '',
            'validators' => [
                'validate_field_not_empty',
                'validate_is_numeric'
            ],
            'extra' => [
                'attr' => [
                    'placeholder' => '99',
                    'class' => 'input-field'
                ]
            ]
        ],
        'img' => [
            'label' => 'Product image',
            'type' => 'text',
            'value' => '',
            'validators' => [
                'validate_field_not_empty',
            ],
            'extra' => [
                'attr' => [
                    'placeholder' => 'Http://url',
                    'class' => 'input-field'
                ]
            ]
        ],
        'descrip' => [
            'label' => 'Product Description',
            'type' => 'textarea',
            'validators' => [
                'validate_field_not_empty'
            ],
        ],
        'contact' => [
            'label' => 'Contacts',
            'type' => 'text',
            'value' => '',
            'validators' => [
                'validate_field_not_empty',
            ],
            'extra' => [
                'attr' => [
                    'placeholder' => 'Contact (phone/email/skype)',
                    'class' => 'input-field'
                ]
            ]
        ],
    ],
    'buttons' => [
        'submit' => [
            'title' => 'Prideti',
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
    ]
];
$clean_inputs = get_clean_input($form);

if ($clean_inputs) {
    $success = validate_form($form, $clean_inputs);

    if ($success) {
        $user_key = is_logged_user();
        $rows = file_to_array(DB_FILE);

        $rows['items'][] = $clean_inputs + ['email' => $_SESSION['email'] , 'id' => uniqid()];
        $rows['users'][$user_key]['items'] += 1;

        array_to_file($rows, DB_FILE);
        $p = 'Sveikinu pridejus preke';
    } else {
        $p = 'Uzpildyki visus laukus';
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
    <link rel="stylesheet" href="../style.css">
    <title>Add</title>
</head>
<body>
<main>
    <?php require ROOT . '/app/templates/nav.tpl.php'; ?>
    <article class="wrapper">
        <h1 class="header header--main">Prideki preke</h1>
        <?php require ROOT . '/core/templates/form.tpl.php'; ?>
        <?php if (isset ($p)): ?>
            <p><?php print $p; ?></p>
        <?php endif; ?>
    </article>
</main>
</body>
</html>

