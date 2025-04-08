<?php

namespace App\Traits;

use App\Models\Node;
use Illuminate\Database\Eloquent\Model;

use Spatie\Ssh\Ssh;
use Exception;

trait NodeWebserver {

    public function get_webserver_configs() {
        $response = $this->api_call("/webserver/");

        if ((isset($response->status) && $response->status == "error") || !isset($response->data)) {
            return vlx_cast_to_object(['status' => 'error', 'message' => $response->message]);
        }

        return vlx_cast_to_object(['status' => 'success', 'data' => $response->data]);
    }

    public function get_webserver_config($id) {
        $response = $this->api_call("/webserver/$id");

        if ((isset($response->status) && $response->status == "error") || !isset($response->data)) {
            return ['status' => 'error', 'message' => $response->message];
        }

        return ['status' => 'success', 'data' => $response->data];
    }


    public function save_webserver_config($id, $data) {
        $response = $this->api_call("/webserver/$id/update", 'POST', $data);

        if ((isset($response->status) && $response->status == "error")) {
            return ['status' => 'error', 'message' => $response->message];
        }

        if ((isset($response->status) && $response->status == "warning")) {
            return [ 'status' => 'warning', 'message' => $response->message, 'warning' => $response->warning ?? null, ];
        }

        return ['status' => 'success'];
    }

    public function remove_webserver_config($id) {
        $response = $this->api_call("/webserver/$id/destroy", 'POST');

        if ((isset($response->status) && $response->status == "error")) {
            return ['status' => 'error', 'message' => $response->message];
        }

        if ((isset($response->status) && $response->status == "warning")) {
            return [ 'status' => 'warning', 'message' => $response->message, 'warning' => $response->warning ?? null, ];
        }

        return ['status' => 'success'];
    }

    public function certbot_webserver_config($id) {
        $response = $this->api_call("/webserver/$id/certbot", 'POST');

        if ((isset($response->status) && $response->status == "error")) {
            return ['status' => 'error', 'message' => $response->message];
        }

        if ((isset($response->status) && $response->status == "warning")) {
            return [ 'status' => 'warning', 'message' => $response->message, 'warning' => $response->warning ?? null, ];
        }

        return ['status' => 'success'];
    }

    public function enable_webserver_config($id) {
        $response = $this->api_call("/webserver/$id/enable", 'POST');

        if ((isset($response->status) && $response->status == "error")) {
            return ['status' => 'error', 'message' => $response->message];
        }

        if ((isset($response->status) && $response->status == "warning")) {
            return [ 'status' => 'warning', 'message' => $response->message, 'warning' => $response->warning ?? null, ];
        }

        return ['status' => 'success'];
    }

    public function disable_webserver_config($id) {
        $response = $this->api_call("/webserver/$id/disable", 'POST');

        if ((isset($response->status) && $response->status == "error")) {
            return [
                'status' => 'error',
                'message' => $response->message,
                'error' => $response->error ?? null,
            ];
        }

        if ((isset($response->status) && $response->status == "warning")) {
            return [ 'status' => 'warning', 'message' => $response->message, 'warning' => $response->warning ?? null, ];
        }

        return ['status' => 'success'];
    }

    public function add_webserver_config($data) {
        $response = $this->api_call("/webserver/store", 'POST', $data);

        if ((isset($response->status) && $response->status == "error")) {
            return [
                'status' => 'error',
                'message' => $response->message,
                'error' => $response->error ?? null,
            ];
        }

        if ((isset($response->status) && $response->status == "warning")) {
            return [ 'status' => 'warning', 'message' => $response->message, 'warning' => $response->warning ?? null, ];
        }

        return ['status' => 'success'];
    }

}
