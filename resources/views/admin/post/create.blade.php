@extends('layouts.app')

@section('content')
    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-lg overflow-hidden w-full">
                <div class="p-6">

                    <h2 class="text-2xl font-semibold text-gray-800 mb-6">📝 Create New Post</h2>

                    {{-- Validation Errors --}}
                    @if ($errors->any())
                        <div class="mb-4 bg-red-100 text-red-700 p-3 rounded">
                            <ul class="list-disc ml-5">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- Create Form --}}
                    <form action="{{ route('admin.post.store') }}" method="POST" enctype="multipart/form-data"
                        class="space-y-6">
                        @csrf

                        <!-- Title -->
                        <div>
                            <label class="block font-medium text-gray-700">Title</label>
                            <input type="text" name="title" value="{{ old('title') }}"
                                class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                required>
                        </div>

                        <!-- Description -->
                        <div>
                            <label class="block font-medium text-gray-700">Description</label>
                            <textarea name="description" rows="4"
                                class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>{{ old('description') }}</textarea>
                        </div>

                        <!-- Image Upload -->
                        <div>
                            <label class="block font-medium text-gray-700">Image</label>
                            <input type="file" name="image" id="imageInput" accept="image/*"
                                class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">

                            <!-- Image Preview -->
                            <div class="mt-4">
                                <img id="imagePreview" src="#" alt="Preview"
                                    class="hidden w-48 h-32 object-cover border rounded-md shadow-sm">
                            </div>
                        </div>

                        <!-- Buttons -->
                        <div class="flex justify-between pt-4">
                            <a href="{{ route('admin.post.index') }}"
                                class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md transition">
                                ← Back
                            </a>

                            <button type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md transition">
                                Create Post
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    {{-- Image Preview Script --}}
    <script>
        document.getElementById('imageInput').addEventListener('change', function(event) {
            const preview = document.getElementById('imagePreview');
            const file = event.target.files[0];

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                }
                reader.readAsDataURL(file);
            } else {
                preview.src = "#";
                preview.classList.add('hidden');
            }
        });
    </script>
@endsection
