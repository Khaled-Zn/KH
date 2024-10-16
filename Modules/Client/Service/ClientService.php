<?php


namespace Modules\Client\Service;
use Exception;
use Modules\Client\Models\Client;

class ClientService
{
    public function GetClient($request)
    {
        $request->validate([
            'client_id' => 'required|integer'
        ]);
        $client_id = $request->client_id;
        $admin = auth()->user();
        $client = Client::find($client_id);
        if (!$client){
            throw new Exception('Client is not found', 404);
        }
        if ($client->work_space_id != $admin->work_space_id){
            throw new Exception('Client is not from this work space', 403);
        }
        return [$client->clientable->load(['residence','talents','study']),200];
    }
}
