<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function list()
    {

        $users = User::when(request()->has("keyword"), function ($query) {
            $query->where(function (Builder $builder) {
                $keyword = request()->keyword;

                $builder->where("name", "LIKE", "%" . $keyword . "%");
            });
        })
        ->when(request()->has("id"), function ($query) {
            $sortType = request()->id ?? "asc";
            $query->orderBy("id", $sortType);
        })
        ->where("ban_status", "false")
        ->latest("id")
        ->paginate(4)
        ->withQueryString();

        if ($users->isEmpty()) {
            return response()->json([
                "message" => "There is no user records yet."
            ]);
        }

        return response()->json([
            "users" => $users,
        ]);

    }

    public function create(Request $request){

        $request->validate([
            "name" => ["required", "min:3"],
            "email" => ["required", "email", "unique:users"],
            "position" => ["required", "in:admin,staff"],
            "password" => ["required", "min:8", "confirmed"],

        ]);


        User::create([
            "name" => $request->name,
            "email" => $request->email,
            "position" => $request->position,
            "password" => Hash::make($request->password),
        ]);

        return response()->json([
            "message" => "User register successful",
        ]);

    }

    public function updatePosition(Request $request, $id)
    {

        $user = User::findOrFail($id);

        $request->validate([
            "position" => ["required", "in:admin,staff"],
        ]);


        if ($request->has("position")) {
            // return $request;
            $user->position = $request->position;
        }

        $user->update();

        return response()->json(
            [
                "message" => "A staff has been promoted",
                "user" => $user,
            ]
        );
    }

    public function ban($id)
    {
        $user = User::findOrFail($id);
        $user->ban_status = "true";
        $user->update();
        return response()->json(
            [
                "message" => "You are banned"
            ]
        );

    }

    public function unban($id)
    {
        $user = User::findOrFail($id);

        if ($user->ban_status === "false") {
            return response()->json([
                "message" => "This user is not banned."
            ]);
        }


        $user->ban_status = "false";
        $user->update();
        return response()->json(
            [
                "message" => "You have been unbanned"
            ]
        );

    }

    public function bannedUsers()
    {
        $bannedUsers = User::where("ban_status", "true")->get();
        return response()->json([
            "bannedUsers"=>$bannedUsers
        ]);
    }

}
