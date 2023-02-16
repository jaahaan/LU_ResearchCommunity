<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Connection;
use App\Models\User;
use Auth;
use App\Notifications\ConnectionNotification;
use App\Models\Notification;

class ConnectionController extends Controller
{
    public function addConnection(Request $request){
        $connection = Connection::create([
            'from_id' => Auth::user()->id,
            'to_id' => $request->id,
        ]);
        $authUser = Auth::user();
        $to_id = User::where('id', $request->id)->first();
        $connection_id = $connection->id;
        $msg = "requested to connect you";
        $to_id->notify(new ConnectionNotification($authUser, $connection_id, $msg));
        
        return response()->json([
            'success' => true,
            'data' => $connection
        ], 201);
    }

    public function getUserConnection(Request $request){
        $user = User::where('slug', $request->slug)->first();
        $query = Connection::with('user1', 'user2')->where('connected', 1);
        $data = $query->where('from_id', $user->id)->orWhere('to_id', $user->id)->get();
        return response()->json([
            'success' => true,
            'data' => $data
        ],200);
    }

    public function getAuthUserConnection(Request $request){
        $limit = $request->limit? $request->limit : 4;
        $query = Connection::with('user1', 'user2')->where('connected', 1);
        $data = $query->where('from_id', Auth::user()->id)->orWhere('to_id', Auth::user()->id)->limit($limit)->get();
        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }
    public function getConnectionRequest(Request $request){
        $data = Connection::with('user1', 'user2')
                        ->where('to_id', Auth::user()->id)
                        ->where('connected', 0)->get();
        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }
    public function connectionStatus(Request $request){

        $user = User::where('slug', $request->slug)->first();
        $sendRequest = Connection::with('user1', 'user2')
                        ->where('from_id', Auth::user()->id)
                        ->where('to_id', $user->id)
                        ->where('connected', 0)->first();
        $receivedRequest = Connection::with('user1', 'user2')
                        ->where('from_id', $user->id)
                        ->where('to_id', Auth::user()->id)
                        ->where('connected', 0)->first();
        $connected1 = Connection::with('user1', 'user2')
                        ->where('from_id', Auth::user()->id)
                        ->where('to_id', $user->id)
                        ->where('connected', 1)->first();
        $connected2 = Connection::with('user1', 'user2')
                        ->where('from_id', $user->id)
                        ->where('to_id', Auth::user()->id)
                        ->where('connected', 1)->first();

        if($sendRequest){
            return response()->json([
                'success' => true,
                'data' => $sendRequest
            ],203);
        } else if($receivedRequest){
            return response()->json([
                'success' => true,
                'data' => $receivedRequest
            ],202);
        } else if($connected1){
            return response()->json([
                'success' => true,
                'data' => $connected1, $connected2
            ],201);
        } else if( $connected2){
            return response()->json([
                'success' => true,
                'data' => $connected2
            ],201);
        }
        
    }

    public function acceptConnection(Request $request){        
        $connection = Connection::where('id', $request->id)->update([            
            'connected' => 1,
        ]);

        $authUser = Auth::user();
        $to_id = User::where('id', $request->user_id)->first();
        $msg = "accepted your request";
        $connection_id = $request->id;
        $to_id->notify(new ConnectionNotification($authUser, $connection_id, $msg));
        Notification::where(['notifiable_id'=>Auth::user()->id,'data->connection_id'=>$request->id])->delete();
        
        return response()->json([
            'success' => true,
            'data' => $connection
        ], 201);
    }

    public function ignoreConnection(Request $request){
        $connection = Connection::where('id', $request->id)->delete();
        Notification::where(['notifiable_id'=>Auth::user()->id,'data->connection_id'=>$request->id])->delete();
        Notification::where(['notifiable_id'=>$request->user_id,'data->connection_id'=>$request->id])->delete();
        return response()->json([
            'success' => true,
            'data' => $connection
        ], 201);
    }
}