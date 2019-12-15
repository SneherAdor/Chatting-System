<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function index($user_id)
    {
    	$chats = Chat::where('user_id',$user_id)->orderBy('created_at','asc')->get();
    	$chatHistory = '';
    	foreach ($chats as $chat) {


    		$chatHistory .='<div id="cm-msg-'.$chat->id.'" class="chat-msg '.$chat->type.'"><span class="msg-avatar"><img src="https://image.crisp.chat/avatar/operator/7a702e9c-85b7-4ded-aa9a-ec2edda6f43b/240/?1575851691353"></span><div class="cm-msg-text"> '.$chat->message.'</div></div>';
    	}

    	return $chatHistory;
	
		// return json_encode($chats);
    }

    public function agent()
    {
    	$chats = Chat::orderBy('created_at','asc')->get();

		return view('admin.chats.agent')->with('chats', $chats);
    }

    public function chatBox()
    {
        $chatUsers = Chat::orderBy('created_at','asc')->get();

        //Seprate user_id from all data and put in users[]
        $users = array();
        foreach($chatUsers as $chatUser) {
         $users[] = $chatUser->user_id;
        }

        //Remove duplicate user_id
        $users = array_unique($users);

        $chats = Chat::orderBy('created_at','desc')->paginate(10);

        return view('admin.chats.chatbox', compact('chats', 'users'));
    }

    public function send(Request $request)
    {

            $chat = new Chat();

            $chat->user_id = $request->user_id;
            $chat->agent_id = $request->agent_id;
            $chat->type = $request->type;
            $chat->message = $request->message;
            $chat->save();

    }
}
