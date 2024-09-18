<div>
    <!--  
        https://www.youtube.com/watch?v=ivKl89Pzq98&t=39s
        --->
    <div class="bg-gray-100 dark:bg-gray-800">
        <div class="flex flex-1 overflow-hidden h-screen max-screen-2xl m-auto">
            <div class="p-12 lg:p-20 w-full">
                <div class="max-h-full h-full flex flex-row">
                    <!-- Left side bar start -->
                    <aside class="w-full lg:w-2/6 bg-white dark:bg-gray-900 rounded-lg mr-5">
                        <div class="max-w-full h-full w-full flex flex-col">
                            <div class="flex p-10 justify-between ">
                                <div class="text-4xl font-semibold dark:text-white text-gray-900">Chat</div>
                                <!-- switcher start -->
                                <div>
                                    <button
                                        id="theme-toggle"
                                        type="button"
                                        class="text-gray-500 text-sm p-2.5">
                                        <svg 
                                            class="theme-toggle-dark-icon"
                                            fill="currentColor"
                                            viewBox="0 0 24 24" 
                                             xmlns="http://www.w3.org/2000/svg"  stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386-1.591 1.591M21 12h-2.25m-.386 6.364-1.591-1.591M12 18.75V21m-4.773-4.227-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z" />
                                        </svg>
                                        
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.72 9.72 0 0 1 18 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 0 0 3 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 0 0 9.002-5.998Z" />
                                          </svg>

                                        
                                          
                                          
                                    </button>
                                </div>
                                <!-- switcher end -->
                            </div>
                            
                        </div>
                    </aside>
                    <!-- Left side bar end -->
                </div>

            </div>

        </div>
        <h1>Inbox</h1>
        <ul>
            @foreach ($messages as $message)
                <li>{{ $message['body'] }} ({{ $message['created_at']->diffForHumans() }})</li>
            @endforeach
        </ul>
    </div>
</div>
