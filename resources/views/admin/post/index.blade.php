@extends('layouts.app')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Card -->
            <div class="bg-white shadow-md rounded-lg overflow-hidden w-full">

                {{-- Success Message --}}
                @if (session('success'))
                    <div id="alert-success" class="mb-4 bg-green-100 text-green-800 p-3 rounded text-center">
                        {{ session('success') }}
                    </div>
                    <script>
                        setTimeout(() => {
                            const alertBox = document.getElementById('alert-success');
                            if (alertBox) alertBox.style.display = 'none';
                        }, 3000);
                    </script>
                @endif

                <div class="p-6">
                    <!-- Header -->
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-semibold text-gray-800">📋 Posts List</h2>
                        <a href="{{ route('admin.post.create') }}"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-4 py-2 rounded-md transition duration-200">
                            + Create New Post
                        </a>
                    </div>

                    <!-- Table -->
                    <div class="overflow-x-auto">
                        <table class="w-full border border-gray-200 rounded-lg">
                            <thead class="bg-gray-100 text-gray-700 uppercase text-sm">
                                <tr>
                                    <th class="py-3 px-4 border-b w-16">#</th>
                                    <th class="py-3 px-4 border-b w-1/5">Title</th>
                                    <th class="py-3 px-4 border-b w-2/5">Description</th>
                                    <th class="py-3 px-4 border-b w-1/5 text-center">Image</th>
                                    <th class="py-3 px-4 border-b w-1/5 text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($posts as $post)
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="py-3 px-4 border-b text-gray-600">{{ $loop->iteration }}</td>
                                        <td class="py-3 px-4 border-b font-medium text-gray-800">{{ $post->title }}</td>
                                        <td class="py-3 px-4 border-b text-gray-600">
                                            {{ Str::limit($post->description, 60) }}
                                        </td>
                                        <td class="py-3 px-4 border-b text-center">
                                            @if ($post->image)
                                                <img src="{{ asset('storage/' . $post->image) }}" alt="Post Image"
                                                    class="w-20 h-20 object-cover rounded-md mx-auto border">
                                            @else
                                                <span class="text-gray-400 italic">No Image</span>
                                            @endif
                                        </td>
                                        <td class="py-3 px-4 border-b text-center">
                                            <a href="{{ route('admin.post.edit', $post->id) }}"
                                                class="bg-yellow-600 hover:bg-yellow-700 text-white px-3 py-1 rounded text-sm font-medium mr-2 transition">
                                                ✏️ Edit
                                            </a>
                                            <form action="{{ route('admin.post.destroy', $post->id) }}" method="POST"
                                                class="inline"
                                                onsubmit="return confirm('Are you sure you want to delete this post?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-sm font-medium transition">
                                                    🗑️ Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="py-6 text-center text-gray-500 italic">
                                            No posts available yet.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- End Card -->

        </div>
    </div>
@endsection
