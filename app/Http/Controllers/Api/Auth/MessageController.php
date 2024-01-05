<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class MessageController extends Controller
{
    public $successStatus = 200;
    public function sendMessage(Request $request, $id)
    {
        $user = User::find($id);
        if($user) {
            $validator = Validator::make($request->all(), [
                'reciever_id' => 'required|exists:users,id',
                'program_id'=>'required'
            ]);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 401);
            }
          
            $input = $request->all();
            if($request->message) {
               
                $input['message'] = $request->message;
            }
             if($request->audio) {
                   $uploadedImage = rand(10000000, 999999990). '.' . $request->audio->extension();
                    $path = $request->audio->storeAs('image', $uploadedImage, 'public');
                      $url =  $path;
                $input['audio'] =  $url;
            }
            
            if ($request->media) {
                $uploadedFiles = [];

                foreach ($request->file('media') as $file) {
                    $uploadedFile = new \stdClass(); // Use \stdClass directly without the namespace

                    $extension = $file->extension(); // Get the file extension

                    // Determine the type of the file based on its extension
                    if (in_array($extension, ['png', 'jpg', 'jpeg', 'gif','webp'])) {
                        $uploadedFile->type = 'image';
                    } elseif (in_array($extension, ['mp4', 'avi', 'mov', 'bin'])) {
                        $uploadedFile->type = 'video';
                    }
                    $uploadedImage = rand(10000000, 999999990). '.' . $file->extension();
                    $path = $file->storeAs('image', $uploadedImage, 'public');
                    $uploadedFile->url =  $path;
                    // $uploadedFile->url = $file->storeAs('sos_images', rand(1000, 9999) . '.' . $extension, ['disk' => 's3']);
                    $uploadedFiles[] = $uploadedFile;
                }

                $input['media'] = json_encode($uploadedFiles);
            }
            
           
            $input['sender_id'] = $user->id;
             $message = Message::create($input);
              
$reciever=User::find($input['reciever_id']);

$playerIds=[];
    $playerIds[] = $reciever->device_token;
               
        
                // Create a new notification record
    
    $subject =$user->firstname.' '.$user->lastname. 'send you a Message Request' ; ;
    $content = [
        'en' => $subject,
    ];
    
    $fields = [
        'app_id' => '2d8d2864-4b0d-4454-b8aa-5674f2b209b2',
        'include_player_ids' => $playerIds,
         'data' => array("foo" => "NewMassage","type" => 'NewMassage'),
        'contents' => $content,
    ];
    
    $fields = json_encode($fields);
    

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://onesignal.com/api/v1/notifications');
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json; charset=utf-8',
        'Authorization: Basic ODU5ZDhiZjAtOWRkZS00NDIyLWI0ZWItOTYxMDc5YzQzMGIz',
    ]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    $response = curl_exec($ch);
    curl_close($ch);
    
            // Create a new message
           
            $success['data'] =  $message;
            $success['message'] = 'Successfully found';
            $success['status'] = 200;

            return response()->json(['success' => $success], $this->successStatus);
        } else {
            $success['status'] = 400;
            $success['message'] = 'Sender not Exist';
            return response()->json(['error' => $success]);
        }

    }
    public function getMessages(Request $request, $receiverId, $senderId)
    {
        // Retrieve messages between the authenticated user and the specified receiver
        $programid = $request->program_id;
        $id = $senderId;
        
        $messages = Message::where(function ($query) use ($receiverId, $id, $programid) {
                $query->where('sender_id', $id)
                    ->where('reciever_id', $receiverId)
                    ->where('program_id', $programid);
            })
            ->orWhere(function ($query) use ($receiverId, $id, $programid) {
                $query->where('sender_id', $receiverId)
                    ->where('reciever_id', $id)
                    ->where('program_id', $programid);
            })
            ->orderBy('created_at', 'asc')
            ->get();
      $data=[];  
foreach($messages as $m){
    $sender=User::find($m->sender_id);
    

     $receiver=User::find($m->reciever_id);

    
    if($request->status){
      
         $m->status='Read';
          
         $m->save();
         
             $m['sender_online']=$sender->online_status;
                 $m['reciever_online']=$receiver->online_status;
    }
    if($m->media != null){
       
        $media =json_decode($m->media);
        foreach($media as $mm){
            if($mm->type){
                $m['message_type']=$mm->type;
            }
        }
        $m->media=$media;
    }
    if($m->message != null){
         $m['message_type']='text';
    }
     if($m->audio!= null){
         $m['message_type']='audio';
    }
     
    $data[]=$m;
    
   
   
}
        $success['data'] =   $data;
            $success['message'] = 'Successfully found';
            $success['status'] = 200;

            return response()->json(['success' => $success], $this->successStatus);;
    }
    
    
    
public function count_getchat($id){
     $latestMessages = [];
        
        $message = Message::where('sender_id', $id)
            ->orWhere('reciever_id', $id)
            ->orderBy('created_at', 'desc')
            ->get();
        
        if ($message->count() > 0) {
            
            $seenConversations = [];
        
            foreach ($message as $m) {
                // Determine the IDs of the other user involved in the conversation
                $otherUserId = $m->sender_id === $id ? $m->reciever_id : $m->sender_id;
        
                // Create a unique identifier for the conversation using both user IDs
                $conversationIdentifier = implode('_', [$id, $otherUserId]);
        
                // Check if this conversation has been seen before
                if (!isset($seenConversations[$conversationIdentifier])) {
                    // Store this conversation as seen
                    $seenConversations[$conversationIdentifier] = true;
        
                    // Add the message to the list of latest messages
                    $latestMessages[] = $m;
                }
            }
        } 
      
$data=[];
$count=0;
        foreach($latestMessages as $a){
          
          
            if($a->sender_id == $id){
             
                $user=User::find($a->reciever_id);
                if($user){
                    if($a['status'] == 'UnRead'){
                        $count++;
                    }
                     if($a['message'] != null){
                         $a['type']='text';
                     }
                      if($a['audio'] != null){
                         $a['type']='audio';
                     }
                 if($a['media'] != null){
                     $data_med='';
                $a['media']=json_decode($a['media']);
                
                 foreach($a['media'] as $mm){
                   $data_med=$mm->type;
                 }
                 $a['type']= $data_med;
                
                 }
                  $a['online_status']=$user->online_status;
                    $a['name']=$user->firstname.' '.$user->lastname;
                    $a['profile_image']=$user->profile_image;
                    $a['name_user_id']=$user->id;
                   
                    
          
                }
               
                
            }else if($a->reciever_id ===$id){
              
                $user=User::find($a->sender_id);
                if($user){
                     if($a['status'] == 'UnRead'){
                        $count++;
                    }
                   if($a['message'] != null){
                         $a['type']='text';
                     }
                      if($a['audio'] != null){
                         $a['type']='audio';
                     }
                   if($a['media'] != null){
                     $data_med='';
                $a['media']=json_decode($a['media']);
                
                 foreach($a['media'] as $mm){
                   $data_med=$mm->type;
                 }
                 $a['type']= $data_med;
                
                 }
                  $a['online_status']=$user->online_status;
                    $a['name']=$user->firstname.' '.$user->lastname;
                    $a['profile_image']=$user->profile_image;
                    $a['name_user_id']=$user->id;
                
               
                }
              
            }
                  $data[]=$a;
        }
         $message['lastmessage']=$latestMessages;
        
            $success['message'] = 'Successfully found';
            $success['status'] = 200;
 $success['data'] =$count;
            return response()->json(['success' => $success], $this->successStatus);
}
public function getChats($id,$programid)
{
    $latestMessages = Message::whereIn('id', function ($query) use ($id, $programid) {
        $query->select(DB::raw('MAX(id)'))
            ->from('message') // Updated from 'message' to 'messages'
            ->where(function ($query) use ($id, $programid) {
                $query->where('sender_id', $id)
                      ->orWhere('reciever_id', $id)
                      ->where('program_id', $programid);
            })
            ->groupBy(DB::raw('CASE WHEN sender_id = ' . $id . ' THEN reciever_id ELSE sender_id END'));
    })
    ->orderBy('created_at', 'desc')
    ->get();

    $data = [];
    $count = 0;

    foreach ($latestMessages as $message) {
        $otherUserId = ($message->sender_id == $id) ? $message->reciever_id: $message->sender_id;
        $user = User::find($otherUserId);

        if ($user) {
            // Your logic for determining message type, online status, name, profile image, etc.
            $messageData = [
                'type' => $this->getMessageType($message),
                'online_status' => $user->online_status,
                'name' => $user->name ,
                'profile_image' => $user->profile_image,
                'name_user_id' => $user->id,
            ];

            // Count unread messages
            if ($message->status == 'UnRead') {
                $count++;
            }

            // Add additional message data to the array
            $data[] = array_merge($message->toArray(), $messageData);
        }
    }

    // Prepare the response
    $response = [
        'lastMessages' => $data,
        'unreadCount' => $count,
    ];

    // Return the response as JSON
    return response()->json(['success' => $response], $this->successStatus);
}

private function getMessageType($message)
{
    if ($message->message != null) {
        return 'text';
    } elseif ($message->audio != null) {
        return 'audio';
    } elseif ($message->media != null) {
        $media = json_decode($message->media);
        return isset($media[0]->type) ? $media[0]->type : 'unknown';
    }

    return 'unknown';
}

}
