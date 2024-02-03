<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Search Results') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 text-gray-900 dark:text-gray-100">

                    <ul class="bg-white shadow overflow-hidden sm:rounded-md mt-8 grid md:grid-cols-1 grid-cols-1">

                        @if (count($results) == 0)
                            <div class="px-4 py-5 sm:px-6">
                                <div class="flex items-center justify-between">
                                    <h3 class="text-lg leading-6 font-medium text-gray-900">oops! No Results Available</h3>
                                </div>
                            </div>
                        @endif

                        @foreach ($results as $result)

                        <li class="shadow" style="margin: 1rem">
                            <div class="flex items-center justify-between px-4 sm:px-6" style="padding-top: 0.5rem;padding-bottom: 0.5rem;">
                                <h3 class="text-lg leading-6 font-medium text-gray-900">{{$result->user_name}}</h3>

                                <a href="{{url('/profile/'.$result->user_name)}}"
                                    class="bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-1 px-2 border border-blue-500 hover:border-transparent rounded">View</a>
                            </div>
                        </li>
                        <li class="shadow" style="margin: 1rem">
                            <div class="flex items-center justify-between px-4 sm:px-6" style="padding-top: 0.5rem;padding-bottom: 0.5rem;">
                                <h3 class="text-lg leading-6 font-medium text-gray-900">{{$result->user_name}}</h3>

                                <a href="{{url('/profile/'.$result->user_name)}}"
                                    class="bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-1 px-2 border border-blue-500 hover:border-transparent rounded">View</a>
                            </div>
                        </li>
                        <li class="shadow" style="margin: 1rem">
                            <div class="flex items-center justify-between px-4 sm:px-6" style="padding-top: 0.5rem;padding-bottom: 0.5rem;">
                                <h3 class="text-lg leading-6 font-medium text-gray-900">{{$result->user_name}}</h3>

                                <a href="{{url('/profile/'.$result->user_name)}}"
                                    class="bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-1 px-2 border border-blue-500 hover:border-transparent rounded">View</a>
                            </div>
                        </li>
                        <li class="shadow" style="margin: 1rem">
                            <div class="flex items-center justify-between px-4 sm:px-6" style="padding-top: 0.5rem;padding-bottom: 0.5rem;">
                                <h3 class="text-lg leading-6 font-medium text-gray-900">{{$result->user_name}}</h3>

                                <a href="{{url('/profile/'.$result->user_name)}}"
                                    class="bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-1 px-2 border border-blue-500 hover:border-transparent rounded">View</a>
                            </div>
                        </li>

                        @endforeach

                    </ul>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
