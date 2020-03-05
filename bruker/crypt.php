<?php

function crypt_pw($string){
    $options = [
        'memory_cost' => PASSWORD_ARGON2_DEFAULT_MEMORY_COST,
        'time_cost'   => PASSWORD_ARGON2_DEFAULT_TIME_COST,
        'threads'     => PASSWORD_ARGON2_DEFAULT_THREADS,
    ];
    return password_hash($string, PASSWORD_ARGON2I, $options);
}
