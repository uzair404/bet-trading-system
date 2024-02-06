<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manage Posts') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <a href="{{route('admin.posts.create')}}"
            class="flex ml-auto items-center max-w-32 px-4 py-2 my-2 mr-4 text-sm text-gray-100 bg-blue-500 rounded-md  hover:bg-blue-600 dark:text-gray-100 dark:hover:bg-blue-500 dark:bg-blue-400">
            Add New Post
        </a>
        <section class="flex items-center bg-white lg:py-20 font-poppins dark:bg-gray-800 max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="justify-center flex-1 px-4 py-4 text-left lg:py-10 ">
                @foreach ($posts as $post)
                    <div class="p-4 mb-6 rounded-md bg-gray-200 dark:bg-gray-900">
                        <div class="flex items-center justify-between">
                            <h2 class="mb-4 text-xl font-semibold text-gray-600 dark:text-gray-300">
                                {{$post->title}}</h2>
                                <span class="mb-2 text-xs text-gray-500 dark:text-gray-400">{{ date('j F, Y', strtotime($post->created_at)) }}</span>

                            <div>
                                <p>Views: {{$post->view_count}}</p>
                                <a href="{{route('admin.posts.edit', ['id'=>$post->id])}}"
                                    class="flex items-center px-4 py-2 my-2 mr-4 text-sm text-gray-100 bg-blue-500 rounded-md  hover:bg-blue-600 dark:text-gray-100 dark:hover:bg-blue-500 dark:bg-blue-400">
                                    Edit
                                </a>
                                <a href="{{route('admin.posts.delete', ['id'=>$post->id])}}"
                                    class="flex items-center px-4 py-2 mb-2 mr-4 text-sm text-gray-100 bg-red-500 rounded-md  hover:bg-red-600 dark:text-gray-100 dark:hover:bg-red-500 dark:bg-red-400">
                                    Delete
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    </div>
</x-app-layout>
