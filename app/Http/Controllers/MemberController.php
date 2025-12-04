<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMemberRequest;
use App\Models\Member;
use App\Services\MemberService;

class MemberController extends Controller
{
    private MemberService $service;
    public function __construct(MemberService $service)
    {
        $this->service = $service;
        $this->middleware('auth');
    }

    public function index()
    {
        $members = Member::latest()->paginate(15);
        return view('members.index', compact('members'));
    }

    public function store(StoreMemberRequest $request)
    {
        $member = $this->service->create($request->validated());
        return redirect()->route('members.index')->with('success', 'Member created.');
    }

    public function destroy(Member $member)
    {
        try {
            $this->service->delete($member);
            return redirect()->route('members.index')->with('success', 'Member deleted.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
