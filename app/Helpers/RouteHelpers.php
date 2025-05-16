<?php

if (!function_exists('encrypt_id')) {
    function encrypt_id($id) {
        return \Illuminate\Support\Facades\Crypt::encrypt($id);
    }
}

if (!function_exists('decrypt_id')) {
    function decrypt_id($encryptedId) {
        try {
            return \Illuminate\Support\Facades\Crypt::decrypt($encryptedId);
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            abort(404, 'Invalid resource identifier');
        }
    }
}