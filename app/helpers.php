<?php
/**
 * Created by PhpStorm.
 * User: Lorenzo
 * Date: 10/05/16
 * Time: 14:38
 */

/**
 * @param $file
 * @return mixed
 */
function auto_version($file)
{
    if (strpos($file, '/') !== 0 || !file_exists($_SERVER['DOCUMENT_ROOT'] . $file))
        return $file;

    $mtime = filemtime($_SERVER['DOCUMENT_ROOT'] . $file);
    return preg_replace('{\\.([^./]+)$}', ".\$1?ver=$mtime", $file);
}

function gitVersion()
{
    return 1;
   /* exec('git describe --always', $version_mini_hash);
    exec('git rev-list HEAD | wc -l', $version_number);
    exec('git log -1', $line);
    if (isset($line[0]))
        return str_replace('commit ', '', $line[0]);
    else
        return "ko";*/
}

function randomPasswordLegacy()
{
    $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < 8; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass); //turn the array into a string
}

function make_get($apiRoute)
{
    $client = app()->make('client.api');
    $response = $client->request('GET', $apiRoute);
    return json_decode($response->getBody()->getContents(), true);

}

