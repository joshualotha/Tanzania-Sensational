<?php
/**
 * One-time helper to seed Oxygen global colors.
 * Run via: wp eval-file wp-content/plugins/tanzania-sensational-design/set-oxygen-colors.php
 */

$colors = [
    'colorsIncrement' => 7,
    'setsIncrement'   => 1,
    'colors' => [
        [ 'id' => 0, 'name' => 'Primary',     'value' => '#5B7B7A',  'set' => 0 ],
        [ 'id' => 1, 'name' => 'Secondary',   'value' => '#8C6D52',  'set' => 0 ],
        [ 'id' => 2, 'name' => 'Neutral',     'value' => '#F7F4EF',  'set' => 0 ],
        [ 'id' => 3, 'name' => 'Dark',        'value' => '#1F2926',  'set' => 0 ],
        [ 'id' => 4, 'name' => 'Accent',      'value' => '#C9B99A',  'set' => 0 ],
        [ 'id' => 5, 'name' => 'Gold',        'value' => '#C9A84C',  'set' => 0 ],
        [ 'id' => 6, 'name' => 'Text Muted',  'value' => '#535C58',  'set' => 0 ],
    ],
    'sets' => [
        [ 'id' => 0, 'name' => 'Tanzania Sensational' ],
    ],
];

update_option( 'oxygen_vsb_global_colors', $colors );

echo "Oxygen global colors updated.\n";
