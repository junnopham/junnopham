<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\Self_;

class AuthController extends Controller
{
    private const GRAPH_URL = 'https://graph.facebook.com/';
    private $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    /**
     * @param Request $request
     * @return JsonResponse|object
     */
    public function login(Request $request)
    {
        try {
            $token = $request->json()->get('token');
            $info = $this->getInfo($token);
            return $this->checkUser($info);
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ])->setStatusCode(400);
        }
    }

    /**
     * @param string $token
     * @return array
     */
    public function getInfo(string $token)
    {
        $user = [];
        try {
            $request = $this->client->get(self::GRAPH_URL . 'me?access_token=' . $token);
            $response = $request->getBody();
            $data = json_decode($response);
            $user = [
                'id' => $data->id,
                'name' => $data->name,
            ];
        } catch (GuzzleException $e) {
        }

        return $user;
    }

    public function getAvatar($token) {
        try {
            $request = $this->client->get(self::GRAPH_URL . 'me/picture?type=large&access_token=' / $token);
            $response = $request->getBody();
            $data = json_decode($response);
            return $data->data->url ? $data->data->url : null;
        } catch (GuzzleException $e) {
            return null;
        }
    }

    /**
     * @param $data
     * @return JsonResponse
     */
    public function checkUser($data)
    {
        $user = User::where('facebook_id', $data['id'])->first();
        if (!$user) {
            $user = User::create([
                'facebook_id' => $data['id'],
                'name' => $data['name']
            ]);
        }

        auth()->login($user);

        $tokenResult = $user->createToken('Personal Access Client');
        $token = $tokenResult->token;
        $token->expires_at = Carbon::now()->addWeek();
        $token->save();

        return response()->json([
            'user' => $user,
            'token' => $tokenResult->accessToken,
        ]);
    }

    /**
     * @return JsonResponse
     */
    public function user()
    {
        return response()->json(auth()->user());
    }

    /**
     * @return JsonResponse
     */
    public function logout() {
        auth()->user()->token()->revoke();
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }
}
