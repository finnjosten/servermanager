<?php

namespace App\Models;

use App\Models\Node;
use Illuminate\Database\Eloquent\Model;

use Spatie\Ssh\Ssh;
use Exception;

trait NodeInfo {

    /**
     * Get the operating system of the server
     * @return string
     */
    public function get_os() {

        $response = $this->api_call("/node/os");

        if ((isset($response->status) && $response->status == "error") || !isset($response->data)) {
            return "ubuntu";
        }

        return $response->data;
    }

    /**
     * Get the uptime of the server in a human readable format
     * @return string, Xd Xh Xm
     */
    public function get_ip() {

        $response = $this->api_call("/node/ip");

        if ((isset($response->status) && $response->status == "error") || !isset($response->data)) {
            return "0.0.0.0";
        }

        return $response->data;
    }

    /**
     * Get the uptime of the server in a human readable format
     * @return string, Xd Xh Xm
     */
    public function get_uptime() {

        $response = $this->api_call("/node/uptime");

        if ((isset($response->status) && $response->status == "error") || !isset($response->data)) {
            return "0d 0h 0m";
        }

        return $response->data;
    }



    /**
     * Get cpu information
     */
    public function get_cpu() {

        $response = $this->api_call("/node/hardware/cpu");

        if ((isset($response->status) && $response->status == "error") || !isset($response->data)) {
            return null;
        }

        return (object) $response->data;
    }

    /**
     * Get memory information
     */
    public function get_memory() {

        $response = $this->api_call("/node/hardware/memory");

        if ((isset($response->status) && $response->status == "error") || !isset($response->data)) {
            return null;
        }

        return (object) $response->data;
    }

    /**
     * Get disk information
     */
    public function get_disk() {

        $response = $this->api_call("/node/hardware/disk");

        if ((isset($response->status) && $response->status == "error") || !isset($response->data)) {
            return null;
        }

        return (object) $response->data;
    }

}
