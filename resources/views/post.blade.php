<x-app-layout>
    @section('head')
        <style>
            h1,
            h2,
            h3,
            h4,
            h5,
            h6 {
                font-size: revert;
                font-weight: revert;
            }

            .IconBox>span {
                font-size: 1rem;
                font-weight: 700;
                margin-left: -.5rem;
            }

            .IconBox>img {
                width: 75px;
                transition: .2s ease;
                display: inline;
            }

            .IconBox>img:hover {
                transform: scale(1.25);
                cursor: pointer;
            }
        </style>
    @endsection

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Blog') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg !px-4">

                <!-- Blog Post Content -->
                <div style="margin-top:1rem;" class="md:mb-0 w-full mx-auto relative">
                    <div class="px-4 lg:px-0">
                        <h2 style="font-size: 2rem;" class="font-semibold text-gray-800 leading-tight">
                            {{ $post->title }}
                        </h2>
                        <a href="#" class="py-2 text-green-700 inline-flex items-center justify-center mb-2">
                            {{ $post->category->name }}
                        </a>
                    </div>

                    <img src="{{asset('uploads/thumbnails/'.$post->image)}}"
                        class="w-full object-cover lg:rounded" style="height: 28em;" />
                </div>

                <div class="m-4">

                    {!! $post->content !!}

                </div>

                <div class="m-2 flex items-center flex-col">
                    <h2 class="2xl text-center">Whats Your Reaction?</h2>
                    <div class="reaction-icons">
                        <div class="inline IconBox">
                            <img clas="reactIcon" src="https://dropbox.com/s/rgfnea7od54xj4m/like.gif?raw=1"
                                alt="Like emoji" />
                            <span>0</span>
                        </div>
                        <div class="inline IconBox">
                            <img clas="reactIcon" src="https://dropbox.com/s/sykc43x39wqxlkz/love.gif?raw=1"
                                alt="Love emoji" />
                            <span>0</span>

                        </div>
                        <div class="inline IconBox">
                            <img clas="reactIcon" src="https://dropbox.com/s/vdg0a8i0kyd16zk/haha.gif?raw=1"
                                alt="Haha emoji" />
                            <span>0</span>

                        </div>
                        <div class="inline IconBox">
                            <img clas="reactIcon" src="https://dropbox.com/s/ydl0fm5kayxz0e5/wow.gif?raw=1"
                                alt="Wow emoji" />
                            <span>0</span>

                        </div>
                        <div class="inline IconBox">
                            <img clas="reactIcon" src="https://dropbox.com/s/52n5woibt3vrs76/sad.gif?raw=1"
                                alt="Sad emoji" />
                            <span>0</span>

                        </div>
                        <div class="inline IconBox">
                            <img clas="reactIcon" src="https://dropbox.com/s/kail2xnglbutusv/angry.gif?raw=1"
                                alt="Angry emoji" />
                            <span>0</span>

                        </div>
                    </div>
                </div>

                <div class="container mx-auto mt-8 p-4">

                    <h1 class="text-2xl font-bold mb-4">Comments</h1>

                    <!-- Comment Form -->
                    <div class="mb-8">
                        <form action="{{ route('comments.store') }}" method="post">
                            @csrf

                            <label for="comment" class="block text-gray-700 text-sm font-bold mb-2">Add a
                                Comment:</label>
                            <input type="hidden" name="post_id" value="{{ $post->id }}" />
                            <textarea name="body" id="comment" rows="3"
                                class="w-full px-3 py-2 border rounded-md focus:outline-none focus:border-blue-500"></textarea>

                            <button type="submit"
                                class="mt-4 px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:bg-blue-600">Post
                                Comment</button>
                        </form>
                    </div>

                    <!-- Existing Comments -->
                    <div>
                        @foreach ($post->comments as $comment)
                            <div class="bg-white p-4 mb-4 shadow-md rounded-md">
                                <p class="text-gray-700">{{ $comment->body }}</p>
                                <span class="text-sm text-gray-500">{{ $comment->user->name }} -
                                    {{ $comment->created_at->diffForHumans() }}</span>

                                <!-- Delete Button -->
                                <form action="{{ route('comments.destroy', $comment->id) }}" method="post" class="mt-2">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-sm text-red-500 hover:text-red-700 focus:outline-none">Delete</button>
                                </form>
                            </div>
                        @endforeach
                    </div>

                </div>

            </div>
        </div>
    </div>
</x-app-layout>
