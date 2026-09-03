<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SignupController extends Controller
{
    public function index()
    {
        return view('signup');
    }

    public function store(\Illuminate\Http\Request $request)
    {
        $validated = $request->validate([
            'fullname' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,name',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ], [
            'username.unique' => 'Username sudah digunakan.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.min' => 'Password minimal 6 karakter.'
        ]);

        try {
            $factory = (new \Kreait\Firebase\Factory)->withServiceAccount(base_path(env('FIREBASE_CREDENTIALS')));
            $auth = $factory->createAuth();

            $userProperties = [
                'email' => $validated['email'],
                'password' => $validated['password'],
                'displayName' => $validated['fullname'],
            ];

            $createdUser = $auth->createUser($userProperties);

            // Menyimpan data profil tambahan ke Firestore (seperti yang dilakukan JS sebelumnya)
            try {
                putenv('GOOGLE_APPLICATION_CREDENTIALS=' . base_path(env('FIREBASE_CREDENTIALS')));

                $firestore = $factory->createFirestore();
                $database = $firestore->database();
                $database->collection('user')->document($createdUser->uid)->set([
                    'fullname' => $validated['fullname'],
                    'username' => $validated['username'],
                    'email'    => $validated['email'],
                    'phone'    => '',
                    'role'     => 'user',
                    'createdAt' => new \DateTime(),
                ]);
            } catch (\Exception $firestoreEx) {
                \Illuminate\Support\Facades\Log::error('Firestore Sync Error: ' . $firestoreEx->getMessage());
            }

            \App\Models\User::create([
                'name'     => $validated['username'],
                'email'    => $validated['email'],
                'password' => bcrypt($validated['password']),
                'firebase_uid' => $createdUser->uid,
            ]);

            return redirect()->route('login')->with('success', 'Pendaftaran Berhasil! Silakan masuk.');
        } catch (\Kreait\Firebase\Exception\Auth\EmailExists $e) {
            return back()->withErrors(['email' => 'Email sudah terdaftar di Firebase.'])->withInput();
        } catch (\Exception $e) {
            return back()->withErrors(['email' => 'Terjadi kesalahan saat menghubungi Firebase: ' . $e->getMessage()])->withInput();
        }
    }
}
