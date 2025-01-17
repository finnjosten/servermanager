<?php

namespace App\Models;

use App\Models\Node;
use Illuminate\Database\Eloquent\Model;

use Spatie\Ssh\Ssh;
use Exception;

trait NodeNetwork {

    /**
     * Get the operating system of the server
     * @return string
     */
    public function get_ports() {

        $response = $this->api_call('/network');

        if (isset($response->error) || !isset($response->data)) {
            return [];
        }

        $data = vlx_cast_to_array($response->data);

        $ints = array_filter($data, function($item) {
            return is_numeric($item['port']);
        });

        $strings = array_filter($data, function($item) {
            return !is_numeric($item['port']);
        });

        usort($ints, function($a, $b) {
            return intval($a['port']) <=> intval($b['port']);
        });

        usort($strings, function($a, $b) {
            return strcmp($a['port'], $b['port']);
        });

        $data = array_merge($ints, $strings);

        return vlx_cast_to_object($data);

        //return $response->data;
    }


    public function add_port($port, $action, $from) {

        $response = $this->api_call('/network/store', 'POST', [
            'port' => $port,
            'action' => $action,
            'from' => $from
        ]);

        if ($response->status == "error") {
            return ['status' => 'error', 'message' => $response->message];
        }

        return ['status' => 'success', 'message' => 'Port has been added'];
    }

    public function get_locked_ports() {

        $response = $this->api_call('/network/locked');

        if (isset($response->error) || !isset($response->data)) {
            return [];
        }

        return vlx_cast_to_array($response->data);
    }

    public function delete_port($port) {

        if (str_contains($port, '/')) {
            $port = explode('/', $port)[0];
        }

        $response = $this->api_call('/network/' . $port . '/destory', 'POST');

        if ($response->status == "error") {
            return ['status' => 'error', 'message' => $response->message];
        }

        return ['status' => 'success', 'message' => 'Port has been deleted'];
    }

}
