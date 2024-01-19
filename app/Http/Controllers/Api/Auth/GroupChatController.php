<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Group;
use App\Models\Group_Chat;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class GroupChatController extends Controller
{
    public function create_group(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'group_name' => 'required',
            'member.*' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }
        $input = $request->all();
        if ($request->hasFile('group_profile')) {
            $image = 'group' . rand(00000000, 35544354) . '.' . $request->file('group_profile')->extension();
            $path = $request->file('group_profile')->storeAs('image', $image, 'public');
            $url = $path;
            $input['group_profile'] = $url;
        } else {
            $input['group_profile'] = null;
        };
        $member = json_decode($request->member);
        $metadata = [];
        foreach ($member as $m) {
            $user = User::find($m);
            if ($user) {
                $data['user_id'] = $user->id;
                $data['user_name'] = $user->first_name . ' ' . $user->last_name;
                $data['user_profile'] = $user->profile_image;
            }
            $metadata[] = $data;
        }


        $input['group_member'] = $metadata;
        $groupMember = json_encode($input['group_member']);
        $input['group_created_by'] = $id;
        $group = Group::create([
            'group_name' => $input['group_name'],
            'group_profile' => $input['group_profile'],
            'group_member' => $groupMember,
            'group_created_by' => $input['group_created_by'],
        ]);
        if ($group) {
            return response()->json([
                'status' => 200,
                'message' => 'Group added successfully!',
                'data' => $group
            ], 200);
        } else {
            return response()->json([
                'status' => 500,
                'message' => 'Opps something went wrong!',
            ], 500);
        }
    }

    public function send_group_chat(Request $request, $id, $group_id)
    {
        $user = User::find($id);

        if ($request->text) {

            $input['text'] = $request->text;
            $input['message_type'] = 'text';
        } else if ($request->media) {

            $uploadedFiles = [];

            foreach ($request->file('media') as $file) {

                $uploadedFile = new \stdClass(); // Use \stdClass directly without the namespace

                $extension = $file->extension(); // Get the file extension

                // Determine the type of the file based on its extension
                if (in_array($extension, ['png', 'jpg', 'jpeg', 'gif'])) {
                    $uploadedFile->type = 'image';
                } elseif (in_array($extension, ['mp4', 'avi', 'mov', 'bin'])) {
                    $uploadedFile->type = 'video';
                } elseif (in_array($extension, ['mp3', 'ogg'])) {
                    $uploadedFile->type = 'audio';
                } else {
                    // You can handle other file types if needed
                    $uploadedFile->type = 'unknown';
                }
                $uploadedImage = rand(10000000, 999999990) . '.' . $file->extension();
                $path = $file->storeAs('image', $uploadedImage, 'public');
                $uploadedFile->url = $path;
                // $uploadedFile->url = $file->storeAs('sos_images', rand(1000, 9999) . '.' . $extension, ['disk' => 's3']);
                $uploadedFiles[] = $uploadedFile;

                $input['message_type'] = $uploadedFile->type;
            }
            $input['media'] = $uploadedFiles;
        }
        if ($request->audio) {
            $uploadedImage = rand(10000000, 999999990) . '.' . $request->audio->extension();
            $path = $request->audio->storeAs('image', $uploadedImage, 'public');
            $url =  $path;
            $input['audio'] = $url;
            $input['message_type'] = 'audio';
        }

        $input['user_id'] = $user->id;
        $input['user_name'] = $user->firstname . ' ' . $user->lastname;
        $input['user_profile'] = $user->profile_image;
        $input['time'] = Carbon::now();
        $message = json_encode($input);

        $check_chats = Group_Chat::where('group_id', '=', $group_id)->first();

        if ($check_chats) {
            $messages = json_decode($check_chats->message, true); // Decode the JSON message to an array
            $messages[] = $message; // Add the new message to the array
            $check_chats->message = json_encode($messages); // Encode the updated array back to JSON
            $check_chats->save();
            $group = Group::find($group_id);
            $js_group = json_decode($group->group_member);
            foreach ($js_group as $gm) {
                $user1 = User::find($gm->user_id);



                $playerIds = [];
                $playerIds[] = $user1->device_token;


                // Create a new notification record

                $subject = $user->firstname . ' ' . $user->lastname . 'send you a Message in ' . $group->group_name;
                $content = [
                    'en' => $subject,
                ];

                $fields = [
                    'app_id' => '2d8d2864-4b0d-4454-b8aa-5674f2b209b2',
                    'include_player_ids' => $playerIds,
                    'data' => array("foo" => "NewMassage", "type" => 'NewMassage'),
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
            }
            if ($check_chats) {
                return response()->json([
                    'status' => 200,
                    'message' => 'Message send successfully!',
                    'data' => $check_chats
                ], 200);
            } else {
                return response()->json([
                    'status' => 500,
                    'message' => 'Opps something went wrong!',
                ], 500);
            }
        } else {
            $create_chats = Group_Chat::create([
                'group_id' => $group_id,
                'message' => json_encode([$message]), // Create an array with the new message and encode it to JSON
            ]);
            $group = Group::find($group_id);
            $js_group = json_decode($group->group_member);
            foreach ($js_group as $gm) {
                $user1 = User::find($gm->user_id);



                $playerIds = [];
                $playerIds[] = $user1->device_token;


                // Create a new notification record

                $subject = $user->firstname . ' ' . $user->lastname . 'send you a Message in ' . $group->group_name;
                $content = [
                    'en' => $subject,
                ];

                $fields = [
                    'app_id' => '2d8d2864-4b0d-4454-b8aa-5674f2b209b2',
                    'include_player_ids' => $playerIds,
                    'data' => array("foo" => "NewMassage", "type" => 'NewMassage'),
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
            }

            if ($create_chats) {
                return response()->json([
                    'status' => 200,
                    'message' => 'Message send successfully!',
                    'data' => $create_chats
                ], 200);
            } else {
                return response()->json([
                    'status' => 500,
                    'message' => 'Opps something went wrong!',
                ], 500);
            }
        }
    }

    public function get_all_coach_groups($id)
    {

        $group = Group::where('group_created_by', '=', $id)->get();
        $data = [];
        if ($group->count() > 0) {
            foreach ($group as $g) {
                $g->group_member = json_decode($g->group_member);
                $group_chat = Group_Chat::where('group_id', '=', $g->id)->first();
                if ($group_chat) {
                    $message = json_decode($group_chat->message);
                    foreach ($message as $m) {
                        $g->lastmessage = json_decode($m);
                    }
                }
            }
            return response()->json([
                'status' => 200,
                'message' => 'Message send successfully!',
                'data' => $group
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Not found!',
            ], 404);
        }
    }


    public function get_all_user_groups($id)
    {
        $userGroups = Group::getUserGroups($id); // Replace 3 with the desired user ID

        $data = [];
        foreach ($userGroups as $group) {
            $group->group_member = json_decode($group->group_member);
            $data[] = $group;
        }
        $chat = [];
        foreach ($data as $d) {
            $group_chat = Group_Chat::where('group_id', '=', $d->id)->first();
            if ($group_chat) {
                $message = json_decode($group_chat->message);
                foreach ($message as $m) {
                    $d->lastmessage = json_decode($m);
                }
                $d['group_id'] = $group_chat->group_id;
                $d['message'] = json_decode($group_chat->message);
            }
            $chat[] = $d;
        }
        return response()->json([
            'status' => 200,
            'message' => 'Message send successfully!',
            'data' => $chat
        ], 200);
    }



    public function group_chat_by_id($id, $group_id)
    {
        $group = Group::find($group_id);
        if ($group) {
            $chat = Group_Chat::where('group_id', '=', $group->id)->first();
            if ($chat) {
                $json = json_decode($chat->message);
                $group_member = json_decode($group->group_member);
                $members = [];
                foreach ($group_member as $gm) {
                    $user = User::find($gm->user_id);
                    $gm->user_about = $user->about;
                    $member[] = $gm;
                }
                $group['group_member'] = $member;
                $data = [];
                foreach ($json as $c) {
                    $chating = json_decode($c);

                    if ($chating->user_id === (int)$id) {
                        $chating->type = 'sender';
                    } else {
                        $chating->type = 'receiver';
                    }
                    $data[] = $chating;
                }
                $group['message'] = $data;
                $group['group_id'] = $chat->group_id;
            }
            return response()->json([
                'status' => 200,
                'message' => 'Message send successfully!',
                'data' => $group
            ], 200);
        }
    }


    public function edit_group(Request $request, $group_id)
    {
        $group = Group::find($group_id);
        if ($group) {
            if ($request->group_name) {
                $group->group_name = $request->group_name;
            }
            if ($request->group_profile) {

                $image = rand(00000, 35354) . '.' . $request->group_profile->extension();
                $path = $request->group_profile->storeAs('image', $image, 'public');
                $url = $path;
                $group->group_profile = $url;
            } elseif ($request->filled('group_profile')) {
                $group->group_profile == $request->group_profile;
            }

            if ($request->group_member) {
                $group->group_member = $request->group_member;
            }
            $group->save();
            return response()->json([
                'status' => 200,
                'message' => 'Group Edit successfully!',
                'data' => $group
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Not found!',
            ], 404);
        }
    }


    public function delete_group($group_id)
    {
        $group = Group::find($group_id);
        if ($group) {

            $group->delete();
            return response()->json([
                'status' => 200,
                'message' => 'Group delete successfully!',
                'data' => $group
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Not found!',
            ], 404);
        }
    }
}
