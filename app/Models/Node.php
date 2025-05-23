<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;

use Spatie\Ssh\Ssh;
use Exception;

use App\Traits\NodeInfo;
use App\Traits\NodeNetwork;
use App\Traits\NodeUser;
use App\Traits\NodeWebapp;
use App\Traits\NodeWebserver;

// Node as like a server node
class Node extends Model {

    use NodeInfo;
    use NodeNetwork;
    use NodeUser;
    use NodeWebapp;
    use NodeWebserver;
    use HasFactory;

    protected $fillable = [
        'ipv4',
        'fqdn',
        'name',
        'endpoint',
        'key',
        'datalix_id',
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
        curl_setopt($ch, CURLOPT_TIMEOUT, 5); // 5 seconds timeout
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3); // 3 sec to connect

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
            $error = curl_error($ch);
            curl_close($ch);
            Log::error("API call failed to $url: $error");
            return ['error' => $error];
        }

        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode >= 400) {
            Log::warning("API call to $url returned HTTP $httpCode");
            return ['error' => "HTTP $httpCode"];
        }

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
