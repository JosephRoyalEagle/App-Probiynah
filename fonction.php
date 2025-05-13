<?php
function get_user_ip()
{
    $ip = '...';
    $client  = @$_SERVER['HTTP_CLIENT_IP'];
    $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
    $remote  = $_SERVER['REMOTE_ADDR'];

    if(filter_var($client, FILTER_VALIDATE_IP)) {
        $ip = $client;
    } else if(filter_var($forward, FILTER_VALIDATE_IP)) {
        $ip = $forward;
    } else {
        $ip = $remote;
    }

    return $ip;
}

function get_user_os() { 
    $user_agent = $_SERVER['HTTP_USER_AGENT'];
    $os_platform    =   "Système Inconnu";
    $os_array       =   array(
        '/windows nt 10/i'     =>  'Windows 10',
        '/windows nt 6.3/i'     =>  'Windows 8.1',
        '/windows nt 6.2/i'     =>  'Windows 8',
        '/windows nt 6.1/i'     =>  'Windows 7',
        '/windows nt 6.0/i'     =>  'Windows Vista',
        '/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
        '/windows nt 5.1/i'     =>  'Windows XP',
        '/windows xp/i'         =>  'Windows XP',
        '/windows nt 5.0/i'     =>  'Windows 2000',
        '/windows me/i'         =>  'Windows ME',
        '/win98/i'              =>  'Windows 98',
        '/win95/i'              =>  'Windows 95',
        '/win16/i'              =>  'Windows 3.11',
        '/macintosh|mac os x/i' =>  'Mac OS X',
        '/mac_powerpc/i'        =>  'Mac OS 9',
        '/linux/i'              =>  'Linux',
        '/ubuntu/i'             =>  'Ubuntu',
        '/iphone/i'             =>  'iPhone',
        '/ipod/i'               =>  'iPod',
        '/ipad/i'               =>  'iPad',
        '/android/i'            =>  'Android',
        '/blackberry/i'         =>  'BlackBerry',
        '/webos/i'              =>  'Mobile'
    );
    foreach ($os_array as $regex => $value) { 
        if (preg_match($regex, $user_agent)) {
            $os_platform    =   $value;
        }
    }   
    return $os_platform;
}

function get_user_browser() {
    $user_agent     = $_SERVER['HTTP_USER_AGENT'];
    $browser        =   "Navigateur Inconnu";
    $browser_array  =   array(
        '/msie/i'       =>  'Internet Explorer',
        '/firefox/i'    =>  'Firefox',
        '/safari/i'     =>  'Safari',
        '/chrome/i'     =>  'Chrome',
        '/opera/i'      =>  'Opera',
        '/netscape/i'   =>  'Netscape',
        '/maxthon/i'    =>  'Maxthon',
        '/konqueror/i'  =>  'Konqueror',
        '/mobile/i'     =>  'Handheld Browser'
    );
    foreach ($browser_array as $regex => $value) { 
        if (preg_match($regex, $user_agent)) {
            $browser    =   $value;
        }
    }
    return $browser;
}

// Fonction de chifremment de donnée
function encryptData($data) {
    $key = hash('sha256', "TheBossSecretKeyForWebApp", true);
    $iv = openssl_random_pseudo_bytes(16);
    $encryptedText = openssl_encrypt($data, 'aes-256-cbc', $key, 0, $iv);
    return base64_encode(base64_encode($encryptedText) . '::' . base64_encode($iv));
}

// Fonction de déchifremment de donnée
function decryptData($encryptedData) {
    $key = hash('sha256', "TheBossSecretKeyForWebApp", true);
    $decoded = base64_decode($encryptedData);
    $parts = explode('::', $decoded);
    if (count($parts) !== 2) return false;
    $encryptedText = base64_decode($parts[0]);
    $iv = base64_decode($parts[1]);
    return openssl_decrypt($encryptedText, 'aes-256-cbc', $key, 0, $iv);
}    

// Fonction de masquage de caractères
function maskEmail($email) {
    // Diviser l'email en deux parties : avant et après le @
    list($name, $domain) = explode('@', $email);
    // Masquer une partie du nom avant @
    $nameMasked = substr($name, 0, 4) . str_repeat('*', strlen($name) - 4);
    return $nameMasked . '@' . $domain;
}

function maskPhone($phone) {
    // Conserver les 6 premiers chiffres, remplacer les 7e à 10e par des étoiles, et ajouter le reste
    $maskedPhone = substr($phone, 0, 8) . str_repeat('*', 4) . substr($phone, 12);
    return $maskedPhone;
    // Retourner le numéro tel quel si sa longueur n'est pas de 13 caractères
    return $phone;
}

function ccleaner($data){
    $ds = strip_tags(stripcslashes(stripslashes($data)));
    #####################################################
    $utf8 = array(
        '/[áàâãªä]/u'   =>   'a',
        '/[ÁÀÂÃÄ]/u'    =>   'A',
        '/[ÍÌÎÏ]/u'     =>   'I',
        '/[íìîï]/u'     =>   'i',
        '/[éèêë]/u'     =>   'e',
        '/[ÉÈÊË]/u'     =>   'E',
        '/[óòôõºö]/u'   =>   'o',
        '/[ÓÒÔÕÖ]/u'    =>   'O',
        '/[úùûü]/u'     =>   'u',
        '/[ÚÙÛÜ]/u'     =>   'U',
        '/ç/'           =>   'c',
        '/Ç/'           =>   'C',
        '/ñ/'           =>   'n',
        '/Ñ/'           =>   'N',
        '/–/'           =>   ' ',
        '/-/'           =>   ' ',
        '/~/'           =>   ' ',
        '/\^/'           =>   '',
        '/§/'           =>   '',
        '/µ/'           =>   '',
        '/\^/'           =>   '',
        '/[’‘‹›‚]/u'    =>   ' ',
        '/[“”«»„]/u'    =>   ' ',
        "/'/"           =>   ' ',
        '/"/'           =>   ' ',
    );
    return preg_replace(array_keys($utf8), array_values($utf8), $ds);
}
?>