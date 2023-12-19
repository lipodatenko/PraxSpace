<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function saveUser(Request $request)
    {
        $newUser = new User();
        $newUser->email = $request->input('email', "nic");
        $newUser->first_name = $request->input('first_name', "nic");
        $newUser->last_name = $request->input('last_name', "nic");
        $newUser->age = $request->input('age', 0);

        $newUser->save();

        return response()->json([
            "user_id" => $newUser->id
        ]);
    }

    public function getUser(int $id)
    {
        $user = User::find($id);
        if($user) {
            return response()->json($user);
        } else {
            return response()->json("Unable to find user", 404);
        }
    }

    public function getUserByEmail(string $email)
    {
        $user = User::where('email', '=', $email)->first();

        if($user) {
            return response()->json($user);
        } else {
            return response()->json("Unable to find user", 404);
        }
    }

    public function deleteUser(int $id)
    {
        $user = User::find($id);

        if($user) {
            $user->delete();
            return response()->json("User deleted");
        } else {
            return response()->json("Unable to find user", 404);
        }
    }

    public function getAllUsers()
    {
        $users = User::all();
        return response()->json($users);
    }

    public function updateUser(Request $request)
    {
        $id = $request->input('id', 0);

        $user = User::findOrFail($id);

        $user->email = $request->input('email');
        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');
        $user->age = $request->input('age');

        $user->update();

        return response()->json($user);
    }

    public function getAllUserContacts(int $id)
    {
        DB::connection()->enableQueryLog();
        $user = User::query()->find($id);
        if($user) {
            /** @var Collection $contacts */
            $contacts = $user->contacts;
            $queries = DB::getQueryLog();
            return response()->json($contacts);
        } else {
            return response()->json('User not found', 404);
        }
    }
}
