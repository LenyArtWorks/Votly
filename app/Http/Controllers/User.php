<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Exception;
use Log;
use Illuminate\Support\Facades\Hash;
use App\Models\User as UserModel;


class User extends Controller
{
    public function getUser() {
        $user = auth()->user();

        return Inertia::render('Profile', [
            'user' => $user
        ]);
    }

    public function updateLogin(Request $request) {
            $request->validate([
                'login' => 'required|unique:users'
            ]);

            $newLogin = $request->login;

            $currentUser = UserModel::find(auth()->user()['id']);
            $currentUser->login = $newLogin;
            $currentUser->save();
    }

    public function updateEmail(Request $request) {
            $request->validate([
                'email' => 'required|email|unique:users'
            ]);

            $newEmail = $request->email;

            $currentUser = UserModel::find(auth()->user()['id']);
            $currentUser->email = $newEmail;
            $currentUser->save();
    }

    public function updateBirthDate(Request $request) {
        try {
            $request->validate([
                'birthdate' => 'required|after_or_equal:1940-01-01|before_or_equal:2010-12-31'
            ]);

            $newBirthDate = $request->birthdate;

            $currentUser = UserModel::find(auth()->user()['id']);
            $currentUser->birthdate = $newBirthDate;
            $currentUser->save();
        }
        catch (Exception $e) {
            Log::alert('error', [
                'details' => $e->getMessage()
            ]);
        }
    }

    public function updateGender(Request $request) {
            $request->validate([
                'gender' => 'required'
            ]);

            $newGender = $request->gender;

            $currentUser = UserModel::find(auth()->user()['id']);
            $currentUser->gender = $newGender;
            $currentUser->save();
    }

    public function checkPassword(Request $request) {
        try {
            $request->validate([
                'password' => 'required'
            ]);

            $currentUser = UserModel::find(auth()->user()['id']);
            $password = $request->password;

            if (!Hash::check($password, $currentUser->password)) {
                return response()->json(['message' => 'Неверный пароль']);
            }
        }
        catch (Exception $e) {
            return response()->json(['message' => 'Поле не должно быть пустым']);
        }
    }

    public function updatePassword(Request $request) {
        try {
            $request->validate([
                'password' => 'required'
            ]);

            $currentUser = UserModel::find(auth()->user()['id']);
            $newPassword = $request->password;

            if (Hash::check($newPassword, $currentUser->password)) {
                return response()->json(['message' => 'Нельзя использовать свой старый пароль']);
            }
            else {
                $currentUser->password = Hash::make($newPassword);
                $currentUser->save();
            }
        }
        catch (Exception $e) {
            return response()->json(['message' => 'Поле не должно быть пустым']);
        }
    }
}
