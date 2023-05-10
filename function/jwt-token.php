<?php

function Sign($payload){
    $key = '!@ASD*&^';
    // Header
    $headers = ['algo'=>'HS256', 'type'=>'JWT'];
    $headers_encoded = base64_encode(json_encode($headers));

    // Payload
    $payload_encoded = base64_encode(json_encode($payload));

    // Signature
    $signature = hash_hmac('SHA256',$headers_encoded.$payload_encoded,$key);
    $signature_encoded = base64_encode($signature);

    // Token
    $token = $headers_encoded . '.' . $payload_encoded .'.'. $signature_encoded;

    return $token;
}

function Verify($token){
    $key = '!@ASD*&^';
    // Break token parts
    $token_parts = explode('.', $token);

    // Verigy Signature
    $signature = base64_encode(hash_hmac('SHA256',$token_parts[0].$token_parts[1],$key));
    if($signature != $token_parts[2]){
        return false;
    }

    // Decode headers & payload
    $headers = json_decode(base64_decode($token_parts[0]), true);
    $payload = json_decode(base64_decode($token_parts[1]), true);

    // If token successfully verified
    return $payload;
}