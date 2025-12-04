<?php

namespace App\Services;

use App\Models\Member;

class MemberService
{
    public function create(array $data): Member
    {
        return Member::create($data);
    }

    public function delete(Member $member): void
    {
        $member->delete();
    }

    public function findOrFail(int $id): Member
    {
        return Member::findOrFail($id);
    }
}
