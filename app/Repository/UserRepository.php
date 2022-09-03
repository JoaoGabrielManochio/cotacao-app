<?php

namespace App\Repository;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserRepository {

    public function list()
    {
        return User::paginate(30);
    }

    public function show($id)
    {
        $user = User::find($id);

        if (!$user) {
            return false;
        }

        return $user;
    }

    public function store()
    {
        return User::create($this->fields());
    }

    public function update($id)
    {
        $user = $this->show($id);

        if (!$user) {
            return false;
        }

        $user->fill($this->fields());
        $user->save();

        return $user;
    }

    public function destroy($id)
    {
        $user = $this->show($id);

        if (!$user) {
            return false;
        }

        return $user->delete();
    }

    private function fields()
    {
        $fields = [
            'name'  => request('name'),
            'email' => request('email')
        ];

        if (request('password')) {
            $fields['password'] = Hash::make(request('password'));
        }

        return $fields;
    }
}
