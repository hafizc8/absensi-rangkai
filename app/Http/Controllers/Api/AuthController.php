<?php

namespace App\Http\Controllers\Api;
use App\Models\User;
use App\Models\Jabatan;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;

class AuthController {
    /**
     * Endpoint login
     * @param String $email
     * @param String $password
     */
    public function authenticate(Request $request) {
        $credentials = $request->only('email', 'password');

        //valid credential
        $validator = Validator::make($credentials, [
            'email' => 'required',
            'password' => 'required|string|min:6|max:50',
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }

        // check if user login on right app
        $user = User::where('email', '=', $request->email)->first();

        if ($user == null) {
            return response()->json([
                'message' => 'USER_NOT_FOUND',
            ], 200);
        }

        if (!Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'WRONG_PASSWORD',
            ], 200);
        }

        // get jabatan
        if ($user->id_jabatan == 0) {
            $user->jabatan = "Human Resource Development";
        } else {
            $jabatan = Jabatan::where('id', $user->id_jabatan)->first();
    
            if ($jabatan != null) {
                $user->jabatan = $jabatan->nama_jabatan;
            }
        }

        return response()->json([
            'message' => 'SUCCESS',
            'data' => $user
        ], 200);
    }

    /**
     * Endpoint change display picture
     * @param file $foto
     * @param String $email
     */
    public function changeDisplayPicture(Request $request) {
        // upload foto
        $uploadFolder           = 'display_pic';

        $image                  = $request->file('foto');
        $image_uploaded_path    = $image->store($uploadFolder, ['disk' => 'public_uploads']);
        $image_url              = url('/')."/public/uploads/".$image_uploaded_path;
        $uploadedImageResponse  = [
            "image_name"    => basename($image_uploaded_path),
            "image_url"     => $image_url,
            "mime"          => $image->getClientMimeType()
        ];

        // update user value
        $update = User::where('email', '=', $request->email)
            ->update(['display_pic' => $image_url]);

        return response()->json([
            'message' => 'SUCCESS',
            'data' => $uploadedImageResponse
        ]);
    }

    /**
     * Endpoint change password
     * @param String $email
     * @param String $password
     * @param String $new_password
     */
    public function changePassword(Request $request) {
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required',
            'new_password' => 'required'
        ]);

        // check old password
        $user = User::where('email', '=', $request->email)->first();
        $match = Hash::check($request->password, $user->password);
        if (!$match) {
            return response()->json([
                'message' => 'OLD_PASSWORD_NOT_MATCH',
            ]);
        }
        
        // update new password
        $hashedPassword = Hash::make($request->new_password);
        $update = User::where('email', '=', $request->email)
            ->update(['password' => $hashedPassword]);
        
        return response()->json([
            'message' => 'SUCCESS'
        ]);
    }
}