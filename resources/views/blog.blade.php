<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Blog') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">

                <div class="w-full  shadow p-5 rounded-lg bg-white">

                    <div class="relative">
                        <div class="absolute flex items-center ml-2 h-full">

                            <svg class="w-4 h-4 fill-current text-primary-gray-dark" viewBox="0 0 16 16" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M15.8898 15.0493L11.8588 11.0182C11.7869 10.9463 11.6932 10.9088 11.5932 10.9088H11.2713C12.3431 9.74952 12.9994 8.20272 12.9994 6.49968C12.9994 2.90923 10.0901 0 6.49968 0C2.90923 0 0 2.90923 0 6.49968C0 10.0901 2.90923 12.9994 6.49968 12.9994C8.20272 12.9994 9.74952 12.3431 10.9088 11.2744V11.5932C10.9088 11.6932 10.9495 11.7869 11.0182 11.8588L15.0493 15.8898C15.1961 16.0367 15.4336 16.0367 15.5805 15.8898L15.8898 15.5805C16.0367 15.4336 16.0367 15.1961 15.8898 15.0493ZM6.49968 11.9994C3.45921 11.9994 0.999951 9.54016 0.999951 6.49968C0.999951 3.45921 3.45921 0.999951 6.49968 0.999951C9.54016 0.999951 11.9994 3.45921 11.9994 6.49968C11.9994 9.54016 9.54016 11.9994 6.49968 11.9994Z">
                                </path>
                            </svg>
                        </div>

                        <input type="text" name="purchased_search" placeholder="Search For Pages."
                            class="px-8 py-3 w-[80%] rounded-md bg-gray-100 border-transparent focus:border-gray-500 focus:bg-white focus:ring-0 text-sm">

                        <button id="purchased_SearchButton"
                        class="px-4 py-3 bg-gray-100 hover:bg-gray-200 text-gray-800 text-sm font-medium rounded-md">
                            Search and Apply Filter
                        </button>
                    </div>

                </div>


                <section class="text-gray-600 body-font overflow-hidden">
                    <div class="container px-5 py-24 mx-auto">
                      <div class="-my-8 divide-y-2 divide-gray-100">

                        @if (count($posts)<1)
                            <h2 class="text-2xl font-medium text-gray-900 title-font mb-2 text-center">Sorry :( No Post Found</h2>
                        @endif

                        @foreach ($posts as $post)

                        <div class="py-8 flex flex-wrap md:flex-nowrap">
                          <div class="md:w-64 md:mb-0 mb-6 flex-shrink-0 flex flex-col">
                            <span class="font-semibold title-font text-gray-700">{{$post->category->name}}</span>
                            <span class="text-sm text-gray-500">{{ date('j F, Y', strtotime($post->created_at)) }}</span>
                          </div>
                          <div class="md:flex-grow">
                            <h2 class="text-2xl font-medium text-gray-900 title-font mb-2">{{$post->title}}</h2>
                            <p class="leading-relaxed">{{$post->summary}}</p>
                            <a class="text-indigo-500 inline-flex items-center mt-4" href="{{url('/blog/'.$post->slug)}}">Learn More
                              <svg class="w-4 h-4 ml-2" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M5 12h14"></path>
                                <path d="M12 5l7 7-7 7"></path>
                              </svg>
                            </a>
                          </div>
                        </div>

                        @endforeach


                      </div>
                    </div>
                  </section>

            </div>
        </div>
    </div>
</x-app-layout>
