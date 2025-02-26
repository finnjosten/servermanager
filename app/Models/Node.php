<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

use Spatie\Ssh\Ssh;
use Exception;

require_once 'Node/NodeInfo.php';
require_once 'Node/NodeNetwork.php';
require_once 'Node/NodeUser.php';
require_once 'Node/NodeWebapp.php';

// Node as like a server node
class Node extends Model {
    use NodeInfo;
    use NodeNetwork;
    use NodeUser;
    use NodeWebapp;
    use HasFactory;

    protected $fillable = [
        'ipv4',
        'fqdn',
        'name',
        'endpoint',
        'key',
        'user_id',
    ];


    /**
     * function to call api endpoints
     * @param string $api_endpoint
     * @param string $method (default: 'GET', allowed: 'GET', 'POST', 'PUT', 'DELETE')
     * @param array $content (default: [])
     */
    public function api_call($api_endpoint, $method = 'GET', $content = []) {

        if (isset($this->key)) {
            if (vlxIsEncrypted($this->key)) {
                $decryptedToken = Crypt::decrypt($this->key);
            } else {
                $decryptedToken = $this->key;
            }
        }


        $api_address = rtrim($this->endpoint, '/');
        $endpoint = ltrim($api_endpoint, '/');
        $url = $api_address . '/' . $endpoint;

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // Bearer token auth
        if (isset($decryptedToken)) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Authorization: Bearer ' . $decryptedToken,
                'Accept: application/json',
                'Content-Type: application/json', // Indicate request content type
            ]);
        }

        if ($method == 'POST' || $method == 'PUT' || $method == 'DELETE') {
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($content));
        }

        $output = curl_exec($ch);

        if (curl_errno($ch)) {
            return [ 'error' => curl_error($ch) ];
        }

        curl_close($ch);

        return vlx_cast_to_object(json_decode($output, true));
    }



    /**
     * function to call api endpoints
     */
    public function get_all() {
        $response = $this->api_call('/node/all');

        if (isset($response->error) || !isset($response->data)) {
            return null;
        }

        return $response->data;
    }


    /**
     * function to get usage
     */
    public function get_usage() {
        $response = $this->api_call('/usage');

        if (isset($response->error) || !isset($response->data)) {
            return null;
        }

        return $response->data;
    }

}
