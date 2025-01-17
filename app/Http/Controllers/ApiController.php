<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Artisan;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Models\Node;

class ApiController extends Controller
{


    public function getCookie($cookie_name) {
        $cookie = json_decode(request()->cookie($cookie_name));

        if ($cookie) {
            return response()->json($cookie);
        } else {
            return response()->json(null);
        }
    }

    public function setCookie($cookie_name, $data) {
        $data = urldecode($data);

        if (!empty($data) && is_array($data)) {
            $data = json_encode($data);
        }

        $now = time();
        $midnight = strtotime('tomorrow');
        $mins = ($midnight - $now) / 60;

        $response = response()->json([
            "message" => "Cookie has been set"

        ]);

        $response->withCookie(cookie($cookie_name, $data, $mins));

        return $response;
    }




    public function checkNodeStatus($address) {

        if (empty($address)) return response()->json(['error' => 'Invalid URL.'], 400);

        if (!filter_var($address, FILTER_VALIDATE_DOMAIN, FILTER_FLAG_HOSTNAME)) {
            if (!filter_var($address, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6) && !filter_var($address, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
                return response()->json(['error' => 'Invalid IP address.'], 400);
            }
            return response()->json(['error' => 'Invalid domain name.'], 400);
        }

        $pingresult = exec("ping -c 1 " . escapeshellarg($address), $output, $status);

        if ($status == 0) {
            return response()->json(['success' => 'Node is reachable'], 200);
        } else {
            return response()->json(['error' => 'Node is not reachable'], 503);
        }

    }




    public function nodeUsage(Node $node) {

        if (!$node->id) {
            return response()->json(['error' => 'Node not found.'], 404);
        }

        $data = $node->get_usage();

        return response()->json($data);

    }


    public function deleteNodePort(Node $node, $port) {
        $response = vlx_cast_to_object($node->delete_port($port));

        if ($response->status == "error") {
            return response()->json(["status" => "error", 'message' => $response->message], 400);
        }

        return response()->json(["status" => "success", 'message' => 'Port has been deleted'], 200);
    }


    public function addNodePort(Node $node, $port) {

        $action = strtolower(request()->input('action')) ?? "allow";
        $from = request()->input('from') ?? "anywhere";

        if (!in_array($action, ['allow', 'deny'])) {
            return response()->json(["status" => "error", 'message' => 'Invalid action'], 400);
        }

        $response = vlx_cast_to_object($node->add_port($port, $action, $from));

        if ($response->status == "error") {
            return response()->json(["status" => "error", 'message' => $response->message], 400);
        }

        return response()->json(["status" => "success", 'message' => 'Port has been added'], 200);
    }
}
