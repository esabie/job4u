@extends('layouts.admin')

@section('title', 'Users')

@section('content')

<div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-10 py-8 md:py-10">

    <div class="mb-8">
        <h1 class="text-3xl font-extrabold text-[#1E3A6D]">Users</h1>
        <p class="text-slate-600 mt-2">Look up accounts and suspend abusive employers or candidates.</p>
    </div>

    @if (session('success'))
        <div class="mb-6 rounded-xl bg-green-50 border border-green-200 px-4 py-3 text-sm text-green-700">
            {{ session('success') }}
        </div>
    @endif

    <form method="GET" action="{{ route('admin.users.index') }}"
          class="bg-white rounded-2xl border p-4 sm:p-5 mb-6 grid grid-cols-1 sm:grid-cols-4 gap-3">
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Search name or email"
               class="sm:col-span-2 rounded-xl border-gray-300 px-4 py-2.5 text-sm">
        <select name="role" class="rounded-xl border-gray-300 px-4 py-2.5 text-sm">
            <option value="">All roles</option>
            <option value="employer" @selected(request('role') === 'employer')>Employers</option>
            <option value="candidate" @selected(request('role') === 'candidate')>Candidates</option>
            <option value="admin" @selected(request('role') === 'admin')>Admins</option>
        </select>
        <select name="status" class="rounded-xl border-gray-300 px-4 py-2.5 text-sm">
            <option value="">Any status</option>
            <option value="suspended" @selected(request('status') === 'suspended')>Suspended</option>
        </select>
        <button type="submit"
                class="sm:col-span-4 sm:w-auto sm:justify-self-start rounded-xl bg-[#1E3A6D] text-white font-semibold px-6 py-2.5 text-sm hover:bg-blue-700 transition">
            Filter
        </button>
    </form>

    <div class="bg-white rounded-2xl border overflow-hidden">
        @if ($users->isEmpty())
            <div class="p-10 text-center text-slate-500">No users match these filters.</div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-sm min-w-[720px]">
                    <thead class="bg-slate-50 text-left text-slate-600">
                        <tr>
                            <th class="px-6 py-3 font-semibold">User</th>
                            <th class="px-6 py-3 font-semibold">Role</th>
                            <th class="px-6 py-3 font-semibold">Status</th>
                            <th class="px-6 py-3 font-semibold">Joined</th>
                            <th class="px-6 py-3 font-semibold"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @foreach ($users as $user)
                            <tr>
                                <td class="px-6 py-4">
                                    <p class="font-semibold text-slate-900">{{ $user->name }}</p>
                                    <p class="text-slate-500">{{ $user->email }}</p>
                                </td>
                                <td class="px-6 py-4 capitalize text-slate-700">{{ $user->role }}</td>
                                <td class="px-6 py-4">
                                    @if ($user->is_suspended)
                                        <span class="text-xs font-semibold text-red-700 bg-red-100 px-2.5 py-1 rounded-full">Suspended</span>
                                    @else
                                        <span class="text-xs font-semibold text-green-700 bg-green-100 px-2.5 py-1 rounded-full">Active</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-slate-500">
                                    {{ $user->created_at->diffForHumans() }}
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <a href="{{ route('admin.users.show', $user) }}"
                                       class="font-semibold text-[#1E3A6D] hover:underline">
                                        View
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    <div class="mt-6">
        {{ $users->links() }}
    </div>

</div>

@endsection
