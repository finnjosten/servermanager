<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Artisan;
use Exception;
use Illuminate\Http\Response;
use App\Models\Game; // Add this line to import the 'Game' class

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

        $pingresult = exec("ping -c 1 " . escapeshellarg($address), $output, $status);

        if ($status == 0) {
            return response()->json(['success' => 'Node is reachable'], 200);
        } else {
            return response()->json(['error' => 'Node is not reachable'], 503);
        }

    }
}
