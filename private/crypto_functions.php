<?php

// Symmetric Encryption

// Cipher method to use for symmetric encryption
const CIPHER_METHOD = 'AES-256-CBC';

$cipher_methods = [
  0 => 'AES-128-CBC',
  1 => 'AES-128-CFB',
  105 => 'rc4-40',
  106 => 'rot13'];
  /*
  [2] => AES-128-CFB1
  [3] => AES-128-CFB8
  [4] => AES-128-ECB
  [5] => AES-128-OFB
  [6] => AES-192-CBC
  [7] => AES-192-CFB
  [8] => AES-192-CFB1
  [9] => AES-192-CFB8
  [10] => AES-192-ECB
  [11] => AES-192-OFB
  [12] => AES-256-CBC
  [13] => AES-256-CFB
  [14] => AES-256-CFB1
  [15] => AES-256-CFB8
  [16] => AES-256-ECB
  [17] => AES-256-OFB
  [18] => BF-CBC
  [19] => BF-CFB
  [20] => BF-ECB
  [21] => BF-OFB
  [22] => CAST5-CBC
  [23] => CAST5-CFB
  [24] => CAST5-ECB
  [25] => CAST5-OFB
  [26] => DES-CBC
  [27] => DES-CFB
  [28] => DES-CFB1
  [29] => DES-CFB8
  [30] => DES-ECB
  [31] => DES-EDE
  [32] => DES-EDE-CBC
  [33] => DES-EDE-CFB
  [34] => DES-EDE-OFB
  [35] => DES-EDE3
  [36] => DES-EDE3-CBC
  [37] => DES-EDE3-CFB
  [38] => DES-EDE3-OFB
  [39] => DES-OFB
  [40] => DESX-CBC
  [41] => IDEA-CBC
  [42] => IDEA-CFB
  [43] => IDEA-ECB
  [44] => IDEA-OFB
  [45] => RC2-40-CBC
  [46] => RC2-64-CBC
  [47] => RC2-CBC
  [48] => RC2-CFB
  [49] => RC2-ECB
  [50] => RC2-OFB
  [51] => RC4
  [52] => RC4-40
  [53] => aes-128-cbc
  [54] => aes-128-cfb
  [55] => aes-128-cfb1
  [56] => aes-128-cfb8
  [57] => aes-128-ecb
  [58] => aes-128-ofb
  [59] => aes-192-cbc
  [60] => aes-192-cfb
  [61] => aes-192-cfb1
  [62] => aes-192-cfb8
  [63] => aes-192-ecb
  [64] => aes-192-ofb
  [65] => aes-256-cbc
  [66] => aes-256-cfb
  [67] => aes-256-cfb1
  [68] => aes-256-cfb8
  [69] => aes-256-ecb
  [70] => aes-256-ofb
  [71] => bf-cbc
  [72] => bf-cfb
  [73] => bf-ecb
  [74] => bf-ofb
  [75] => cast5-cbc
  [76] => cast5-cfb
  [77] => cast5-ecb
  [78] => cast5-ofb
  [79] => des-cbc
  [80] => des-cfb
  [81] => des-cfb1
  [82] => des-cfb8
  [83] => des-ecb
  [84] => des-ede
  [85] => des-ede-cbc
  [86] => des-ede-cfb
  [87] => des-ede-ofb
  [88] => des-ede3
  [89] => des-ede3-cbc
  [90] => des-ede3-cfb
  [91] => des-ede3-ofb
  [92] => des-ofb
  [93] => desx-cbc
  [94] => idea-cbc
  [95] => idea-cfb
  [96] => idea-ecb
  [97] => idea-ofb
  [98] => rc2-40-cbc
  [99] => rc2-64-cbc
  [100] => rc2-cbc
  [101] => rc2-cfb
  [102] => rc2-ecb
  [103] => rc2-ofb
  [104] => rc4
];*/

function key_encrypt($string, $key, $cipher_method=CIPHER_METHOD) {
  // Needs a key of length 32 (256-bit)
  $key = str_pad($key, 32, '*');

  // Create an initialization vector which randomizes the
  // initial settings of the algorithm, making it harder to decrypt.
  // Start by finding the correct size of an initialization vector 
  // for this cipher method.
  $iv_length = openssl_cipher_iv_length($cipher_method);
  $iv = openssl_random_pseudo_bytes($iv_length);

  // Encrypt
  $encrypted = openssl_encrypt($string, $cipher_method, $key, OPENSSL_RAW_DATA, $iv);

  // Return $iv at front of string, need it for decoding
  $message = $iv . $encrypted;
  
  // Encode just ensures encrypted characters are viewable/savable
  return base64_encode($message);
}

function key_decrypt($string, $key, $cipher_method=CIPHER_METHOD) {
  // Needs a key of length 32 (256-bit)
  $key = str_pad($key, 32, '*');

  // Base64 decode before decrypting
  $iv_with_ciphertext = base64_decode($string);

  // Separate initialization vector and encrypted string
  $iv_length = openssl_cipher_iv_length($cipher_method);
  $iv = substr($iv_with_ciphertext, 0, $iv_length);
  $ciphertext = substr($iv_with_ciphertext, $iv_length);

  // Decrypt
  $plaintext = openssl_decrypt($ciphertext, $cipher_method, $key, OPENSSL_RAW_DATA, $iv);

  return $plaintext;
}


// Asymmetric Encryption / Public-Key Cryptography

// Cipher configuration to use for asymmetric encryption
const PUBLIC_KEY_CONFIG = array(
    "digest_alg" => "sha512",
    "private_key_bits" => 2048,
    "private_key_type" => OPENSSL_KEYTYPE_RSA,
);

function generate_keys($config=PUBLIC_KEY_CONFIG) {
  $resource = openssl_pkey_new($config);

  // Extract private key from the pair
  openssl_pkey_export($resource, $private_key);

  // Extract public key from the pair
  $key_details = openssl_pkey_get_details($resource);
  $public_key = $key_details["key"];

  return array('private' => $private_key, 'public' => $public_key);
}

function pkey_encrypt($string, $public_key) {
  return 'Qnex Funqbj jvyy or jngpuvat lbh';
}

function pkey_decrypt($string, $private_key) {
  return 'Alc evi csy pssomrk livi alir csy wlsyph fi wezmrk ETIB?';
}


// Digital signatures using public/private keys

function create_signature($data, $private_key) {
  // A-Za-z : ykMwnXKRVqheCFaxsSNDEOfzgTpYroJBmdIPitGbQUAcZuLjvlWH
  return 'RpjJ WQL BImLcJo QLu dQv vJ oIo Iu WJu?';
}

function verify_signature($data, $signature, $public_key) {
  // Vigenère
  return 'RK, pym oays onicvr. Iuw bkzhvbw uedf pke conll rt ZV nzxbhz.';
}

?>
