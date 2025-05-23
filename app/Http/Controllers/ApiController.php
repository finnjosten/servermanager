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
        if (empty($address)) {
            return response()->json(['error' => 'Invalid URL.'], 400);
        }

        $isIp = filter_var($address, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 | FILTER_FLAG_IPV6);
        $isDomain = filter_var($address, FILTER_VALIDATE_DOMAIN, FILTER_FLAG_HOSTNAME);

        if (!$isIp && !$isDomain) {
            return response()->json(['error' => 'Invalid address.'], 400);
        }

        $cmd = 'ping -c 1 -W 2 ' . escapeshellarg($address); // 2s timeout
        exec($cmd, $output, $status);

        return $status === 0
            ? response()->json(['success' => 'Node is reachable'], 200)
            : response()->json(['error' => 'Node is not reachable'], 503);
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

        if ((isset($response->status) && $response->status == "error")) {
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

        if ((isset($response->status) && $response->status == "error")) {
            return response()->json(["status" => "error", 'message' => $response->message], 400);
        }

        return response()->json(["status" => "success", 'message' => 'Port has been added'], 200);
    }




    public function getWebapp(Node $node, $id) {

        $response = vlx_cast_to_object($node->get_webapp($id));

        if ((isset($response->status) && $response->status == "error")) {
            return response()->json(["status" => "error", 'message' => $response->message], 400);
        }

        return response()->json(["status" => "success", 'data' => $response->data], 200);
    }


    public function saveWebapp(Node $node, Request $request, $id) {

        $response = vlx_cast_to_object($node->save_webapp($id, request()->all()));

        if ((isset($response->status) && $response->status == "error")) {
            return response()->json(["status" => "error", 'message' => $response->message], 400);
        }

        return response()->json(["status" => "success", 'message' => 'Webapp has been saved'], 200);
    }

    public function addWebapp(Node $node, Request $request) {

        $response = vlx_cast_to_object($node->add_webapp(request()->all()));

        if ((isset($response->status) && $response->status == "error")) {
            return response()->json(["status" => "error", 'message' => $response->message], 400);
        }

        return response()->json(["status" => "success", 'message' => 'Webapp has been added'], 200);

    }




    public function getWebserver(Node $node, $id) {

        $response = vlx_cast_to_object($node->get_webserver_config($id));

        if ((isset($response->status) && $response->status == "error")) {
            return response()->json(["status" => "error", 'message' => $response->message], 400);
        }

        return response()->json(["status" => "success", 'data' => $response->data], 200);
    }


    public function saveWebserver(Node $node, Request $request, $id) {

        $response = vlx_cast_to_object($node->save_webserver_config($id, request()->all()));

        if ((isset($response->status) && $response->status == "error")) {
            return response()->json(["status" => "error", 'message' => $response->message], 400);
        }

        if ((isset($response->status) && $response->status == "warning")) {
            return [ 'status' => 'warning', 'message' => $response->message, 'warning' => $response->warning ?? null, ];
        }

        return response()->json(["status" => "success", 'message' => 'Webserver has been saved'], 200);
    }

    public function removeWebserver(Node $node, $id) {

        $response = vlx_cast_to_object($node->remove_webserver_config($id));

        if ((isset($response->status) && $response->status == "error")) {
            return response()->json(["status" => "error", 'message' => $response->message], 400);
        }

        if ((isset($response->status) && $response->status == "warning")) {
            return [ 'status' => 'warning', 'message' => $response->message, 'warning' => $response->warning ?? null, ];
        }

        return response()->json(["status" => "success", 'message' => 'Webserver has been removed'], 200);
    }

    public function certbotWebserver(Node $node, $id) {

        $response = vlx_cast_to_object($node->certbot_webserver_config($id));

        if ((isset($response->status) && $response->status == "error")) {
            return response()->json([
                "status" => "error",
                'message' => $response->message,
                'error' => $response->error ?? null,
            ], 400);
        }

        if ((isset($response->status) && $response->status == "warning")) {
            return [ 'status' => 'warning', 'message' => $response->message, 'warning' => $response->warning ?? null, ];
        }

        return response()->json(["status" => "success", 'message' => 'Webserver has been updated'], 200);
    }

    public function enableWebserver(Node $node, $id) {

        $response = vlx_cast_to_object($node->enable_webserver_config($id));

        if ((isset($response->status) && $response->status == "error")) {
            return response()->json(["status" => "error", 'message' => $response->message], 400);
        }

        if ((isset($response->status) && $response->status == "warning")) {
            return [ 'status' => 'warning', 'message' => $response->message, 'warning' => $response->warning ?? null, ];
        }

        return response()->json(["status" => "success", 'message' => 'Webserver has been enabled'], 200);
    }

    public function disableWebserver(Node $node, $id) {

        $response = vlx_cast_to_object($node->disable_webserver_config($id));

        if ((isset($response->status) && $response->status == "error")) {
            return response()->json(["status" => "error", 'message' => $response->message], 400);
        }

        if ((isset($response->status) && $response->status == "warning")) {
            return [ 'status' => 'warning', 'message' => $response->message, 'warning' => $response->warning ?? null, ];
        }

        return response()->json(["status" => "success", 'message' => 'Webserver has been disabled'], 200);
    }

    public function addWebserver(Node $node, Request $request) {

        $response = vlx_cast_to_object($node->add_webserver_config(request()->all()));

        if ((isset($response->status) && $response->status == "error")) {
            return response()->json([
                "status" => "error",
                'message' => $response->message,
                'error' => $response->error ?? null,
            ], 400);
        }

        if ((isset($response->status) && $response->status == "warning")) {
            return [ 'status' => 'warning', 'message' => $response->message, 'warning' => $response->warning ?? null, ];
        }

        return response()->json(["status" => "success", 'message' => 'Webserver has been added'], 200);

    }
}
