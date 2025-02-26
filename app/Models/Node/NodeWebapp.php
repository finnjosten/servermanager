<?php

namespace App\Models;

use App\Models\Node;
use Illuminate\Database\Eloquent\Model;

use Spatie\Ssh\Ssh;
use Exception;

trait NodeWebapp {

    public function get_webapp($id) {
        $response = $this->api_call("/webapp/$id");

        if ((isset($response->status) && $response->status == "error") || !isset($response->data)) {
            return ['status' => 'error', 'message' => $response->message];
        }

        return ['status' => 'success', 'data' => $response->data];
    }


    public function save_webapp($id, $data) {
        $response = $this->api_call("/webapp/$id/update", 'POST', $data);

        if ((isset($response->status) && $response->status == "error")) {
            return ['status' => 'error', 'message' => $response->message];
        }

        return ['status' => 'success', 'message' => $response->message];
    }


    public function add_webapp($data) {
        $response = $this->api_call("/webapp/store", 'POST', $data);

        if ((isset($response->status) && $response->status == "error")) {
            return ['status' => 'error', 'message' => $response->message];
        }

        return ['status' => 'success', 'message' => $response->message];
    }

}
