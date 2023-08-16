<?php

return [
    'hosts' => env('LDAP_HOSTS'),
    'port' => env('LDAP_PORT'),
    'base_dn' => env('LDAP_BASE_DN'),
    'username' => env('LDAP_USERNAME'),
    'password' => env('LDAP_PASSWORD'),
];
