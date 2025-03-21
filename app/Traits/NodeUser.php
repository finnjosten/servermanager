<?php

namespace App\Traits;

use App\Models\Node;
use Illuminate\Database\Eloquent\Model;

use Spatie\Ssh\Ssh;
use Exception;

// Node as like a server node
trait NodeUser {

    /**
     * Retrieve all users from the server
     * @param bool $filtered, filter out the default users that are setup with ubuntu
     * @return array
     */
    public function get_users($filtered = true) {
        return null;
    }

    /**
     * Retrieve all ssh keys for a certain user on the server
     * @param string $username
     * @return array
     */
    public function get_ssh_key($username) {
        return null;
    }

}
