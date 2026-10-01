<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Faculty Members') }}
        </h2>
    </x-slot>

    <div style="padding: 32px;">
        <div style="max-width: 1280px; margin: 0 auto;">

            @if(session('success'))
                <div
                    style="background: #d1fae5; color: #065f46; padding: 12px 16px; border-radius: 6px; margin-bottom: 16px;">
                    {{ session('success') }}
                </div>
            @endif

            <div style="margin-bottom: 16px; display: flex; justify-content: flex-end;">
                <a href="{{ route('faculties.create') }}"
                    style="display: inline-block; padding: 10px 20px; background-color: #4F46E5 !important; color: white !important; border-radius: 6px; text-decoration: none; font-weight: 600; font-size: 14px;">
                    + Add Faculty
                </a>
            </div>

            <div
                style="background: white; border-radius: 8px; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                <table style="width: 100%; border-collapse: collapse;">
                    <thead style="background: #f9fafb;">
                        <tr style="text-align: left; font-size: 12px; color: #6b7280; text-transform: uppercase;">
                            <th style="padding: 12px 16px;">Name</th>
                            <th style="padding: 12px 16px;">Email</th>
                            <th style="padding: 12px 16px;">Department</th>
                            <th style="padding: 12px 16px;">Schedules</th>
                            <th style="padding: 12px 16px;">Attendances</th>
                            <th style="padding: 12px 16px; text-align: right;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($faculties as $f)
                            <tr style="border-top: 1px solid #e5e7eb; font-size: 14px;">
                                <td style="padding: 12px 16px; font-weight: 500;">{{ $f->name }}</td>
                                <td style="padding: 12px 16px; color: #6b7280;">{{ $f->email }}</td>
                                <td style="padding: 12px 16px;">
                                    <span
                                        style="padding: 4px 10px; background: #e0e7ff; color: #3730a3; border-radius: 4px; font-size: 12px; font-weight: 600;">
                                        {{ $f->department }}
                                    </span>
                                </td>
                                <td style="padding: 12px 16px;">{{ $f->schedules_count }}</td>
                                <td style="padding: 12px 16px;">{{ $f->attendances_count }}</td>
                                <td style="padding: 12px 16px; text-align: right;">
                                    <a href="{{ route('faculties.edit', $f) }}"
                                        style="color: #4F46E5; text-decoration: none; margin-right: 12px; font-weight: 500;">Edit</a>
                                    <form action="{{ route('faculties.destroy', $f) }}" method="POST"
                                        style="display: inline;" onsubmit="return confirm('Delete this faculty?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            style="background: none; border: none; color: #dc2626; cursor: pointer; font-weight: 500; padding: 0;">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" style="padding: 32px; text-align: center; color: #6b7280;">
                                    No faculty members found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div style="margin-top: 16px;">
                {{ $faculties->links() }}
            </div>

        </div>
    </div>
</x-app-layout>
