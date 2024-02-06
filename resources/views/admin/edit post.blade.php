<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Post') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <section class="bg-stone-100 font-poppins dark:bg-gray-800">
                <div
                    class="max-w-4xl px-4 py-4 mx-auto bg-white border shadow-sm dark:border-gray-900 dark:bg-gray-900 lg:py-4 md:px-6">
                    <div class="mb-10 ">
                        <h2 class="pb-2 mb-2 text-xl font-bold text-gray-800 md:text-3xl dark:text-gray-300">
                            Post Details
                        </h2>
                    </div>
                    <form action="{{ route('admin.posts.update', ['id'=>$post->id   ]) }}" method="post" enctype="multipart/form-data" class="" novalidate>@csrf
                        <div class="mb-5 text-center">
                            <label class="font-bold mb-1 text-gray-700 block">
                                Thumbnail (Pro Tip: You Can Use Gif)
                            </label>
                            <div class="mx-auto border relative bg-gray-100 mb-4 shadow-inset flex justify-center">
                                <img id="image" class="object-cover w-[600px] h-[300px]"
                                    src='{{asset('uploads/thumbnails/'.$post->image)}}' />
                            </div>

                            <label for="imageUpload" type="button"
                                class="cursor-pointer inine-flex justify-between items-center focus:outline-none border py-2 px-4 rounded-lg shadow-sm text-left text-gray-600 bg-white hover:bg-gray-100 font-medium">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="inline-flex flex-shrink-0 w-6 h-6 -mt-1 mr-1" viewBox="0 0 24 24"
                                    stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <rect x="0" y="0" width="24" height="24" stroke="none"></rect>
                                    <path
                                        d="M5 7h1a2 2 0 0 0 2 -2a1 1 0 0 1 1 -1h6a1 1 0 0 1 1 1a2 2 0 0 0 2 2h1a2 2 0 0 1 2 2v9a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-9a2 2 0 0 1 2 -2" />
                                    <circle cx="12" cy="13" r="3" />
                                </svg>
                                Browse Photo
                            </label>

                            <div class="mx-auto w-48 text-gray-500 text-xs text-center mt-1">
                                Click to add Thumbnail Image</div>

                            <input name="thumbnail" id="imageUpload" accept="image/*" class="hidden" type="file">
                        </div>
                        <div class="mb-6">
                            <label for=""
                                class="block mb-2 text-sm font-medium dark:text-gray-400">Title</label>
                            <input type="text"
                                class="block w-full px-4 py-3 mb-2 text-sm bg-gray-100 border rounded dark:placeholder-gray-400 dark:text-gray-400 dark:border-gray-800 dark:bg-gray-800"
                                name="title" value="{{$post->title}}" placeholder="Title...." required>
                        </div>
                        <div class="mb-6">
                            <label for=""
                                class="block mb-2 text-sm font-medium dark:text-gray-400">Summary</label>
                            <textarea type="text" name="summary" placeholder="Short Summary To Show On Post Card.." required
                                class="block w-full px-4 py-6 leading-tight placeholder-gray-400 bg-gray-100 border rounded dark:placeholder-gray-400 dark:text-gray-400 dark:border-gray-800 dark:bg-gray-800 ">{{$post->summary}}</textarea>
                        </div>
                        <div class="mb-6">
                            <label for=""
                                class="block mb-2 text-sm font-medium dark:text-gray-400">Content</label>
                            <textarea type="text" name="post-content" id="content" placeholder="Post Content.." required
                                class="block w-full px-4 py-6 leading-tight placeholder-gray-400 bg-gray-100 border rounded dark:placeholder-gray-400 dark:text-gray-400 dark:border-gray-800 dark:bg-gray-800 ">{{$post->content}}</textarea>
                        </div>
                        <div class="mb-6 ">
                            <label for=""
                                class="block mb-2 text-sm font-medium dark:text-gray-400">Category</label>
                            <div class="relative">
                                <select name="category"
                                    class="block w-full px-4 py-3 mb-2 text-sm text-gray-500 placeholder-gray-400 bg-gray-100 border rounded appearance-none dark:text-gray-400 dark:bg-gray-800 dark:border-gray-800 ">
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" {{$post->category_id==$category->id?'selected':''}}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center px-2 text-gray-600 ">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        fill="currentColor" class="bi bi-chevron-down" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd"
                                            d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <button
                            class="px-4 py-2 text-base text-gray-100 bg-blue-600 rounded hover:bg-blue-500">Send</button>
                    </form>
                </div>
        </div>
        </section>
    </div>
    </div>

    @section('scripts')
        <script src="https://cdn.tiny.cloud/1/k5sc85zjrd8oslr0012o0pb44lzxuk3utvhw4kxsz20a9u1e/tinymce/6/tinymce.min.js"
            referrerpolicy="origin"></script>
        <script>
            function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $('#image').attr('src', e.target.result);
                        $('#image').hide();
                        $('#image').fadeIn(650);
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            }
            $("#imageUpload").change(function() {
                readURL(this);
            });

            tinymce.init({
                selector: '#content',
                plugins: 'code anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
                toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat | code',

            });
        </script>
    @endsection
</x-app-layout>
