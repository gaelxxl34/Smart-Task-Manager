    <nav class="fixed top-0 z-50 w-full border-b border-gray-200 bg-black border-gray-700"
        style="background-color: #7a0000;">
        <div class="px-3 py-4 lg:px-5 lg:pl-3"> <!-- Increased padding here -->
                <div class="flex items-center justify-between">
                    <div class="flex items-center justify-start rtl:justify-end">
                        <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar" aria-controls="logo-sidebar"
                            type="button"
                            class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 text-gray-400 hover:bg-gray-700 focus:ring-gray-600">
                            <span class="sr-only">Open sidebar</span>
                            <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path clip-rule="evenodd" fill-rule="evenodd"
                                    d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z">
                                </path>
                            </svg>
                        </button>
                        <a href="" class="flex ms-2 md:me-24">
                            <img src="https://online.iuea.ac.ug/pluginfile.php/1/theme_remui/logo/1709968828/IUEA%20Logo%20-%20Moodle%201280x525.png"
                                class="h-12 me-3" alt="FlowBite Logo" /> <!-- Increased logo height here -->
                        </a>
                    </div>
                    <div class="flex items-center">
                        <div class="flex items-center ms-3">
                            <div>
                            <button type="button"
                                    class="flex items-center justify-center text-sm bg-gray-800 rounded-full focus:ring-4 focus:ring-gray-300 focus:ring-gray-600"
                                    aria-expanded="false" data-dropdown-toggle="dropdown-user">
                                <span class="sr-only">Open user menu</span>
                                <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M10 4a4 4 0 100 8 4 4 0 000-8zM5 18a6.978 6.978 0 015-2c1.67 0 3.26.65 4.47 1.72A7.963 7.963 0 0010 20a7.963 7.963 0 00-4.47-1.28C6.74 17.65 8.33 18 10 18z" clip-rule="evenodd"></path>
                                </svg>
                            </button>

                            </div>

                            <div class="z-50 hidden my-4 text-base list-none divide-y divide-gray-100 rounded shadow bg-gray-800 divide-gray-600" id="dropdown-user">
                                @if(session('firebase_token'))
                                    <div class="px-4 py-3" role="none">
                                        <p class="text-sm font-medium text-gray-300 truncate" role="none">
                                            {{ session('user_email') ?? 'Unknown Email' }}
                                        </p>
                                    </div>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <ul class="py-1" role="none">
                                            <li>
                                                <button type="submit"
                                                        class="block w-full text-left px-4 py-2 text-sm hover:bg-gray-100 text-gray-300 hover:bg-gray-600 hover:text-white"
                                                        role="menuitem">
                                                    Sign out
                                                </button>
                                            </li>
                                        </ul>
                                    </form>
                                @else
                                    <p class="px-4 py-3 text-sm text-gray-300">No user logged in.</p>
                                @endif
                            </div>


                        </div>
                    </div>

                </div>
            </div>
    </nav>

    <aside id="logo-sidebar"
        class="fixed top-5 left-0 z-40 w-64 h-screen pt-20 transition-transform -translate-x-full border-r border-black sm:translate-x-0 bg-black border-black"
        aria-label="Sidebar">
        <div class="h-full px-3 pb-4 overflow-y-auto bg-black">
            <ul class="space-y-2 font-medium">

                <li>
                    <a href="{{ session('department') ? '/department/dashboard' : '/Dashboard' }}"
                        class="flex items-center p-2 text-gray-900 rounded-lg text-white hover:bg-gray-100 hover:bg-gray-700 group hover:text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed">
                            <path d="M520-600v-240h320v240H520ZM120-440v-400h320v400H120Zm400 320v-400h320v400H520Zm-400 0v-240h320v240H120Zm80-400h160v-240H200v240Zm400 320h160v-240H600v240Zm0-480h160v-80H600v80ZM200-200h160v-80H200v80Zm160-320Zm240-160Zm0 240ZM360-280Z"/>
                        </svg>
                        <span class="ms-3">Dashboard</span>
                    </a>
                </li>


                <li>
                    <a href="/task"
                        class="flex items-center p-2 text-gray-900 rounded-lg text-white hover:bg-gray-100 hover:bg-gray-700 group hover:text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M480-80q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q65 0 123 19t107 53l-58 59q-38-24-81-37.5T480-800q-133 0-226.5 93.5T160-480q0 133 93.5 226.5T480-160q32 0 62-6t58-17l60 61q-41 20-86 31t-94 11Zm280-80v-120H640v-80h120v-120h80v120h120v80H840v120h-80ZM424-296 254-466l56-56 114 114 400-401 56 56-456 457Z"/></svg>
                        <span class="ms-3 ">Task</span>
                    </a>
                </li>

                @if (!session('department'))
                <li>
                    <a href="/users"
                        class="flex items-center p-2 text-gray-900 rounded-lg text-white hover:bg-gray-100 hover:bg-gray-700 group hover:text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed">
                            <path d="M500-482q29-32 44.5-73t15.5-85q0-44-15.5-85T500-798q60 8 100 53t40 105q0 60-40 105t-100 53Zm220 322v-120q0-36-16-68.5T662-406q51 18 94.5 46.5T800-280v120h-80Zm80-280v-80h-80v-80h80v-80h80v80h80v80h-80v80h-80Zm-480-40q-66 0-113-47t-47-113q0-66 47-113t113-47q66 0 113 47t47 113q0 66-47 113t-113 47ZM0-160v-112q0-34 17.5-62.5T64-378q62-31 126-46.5T320-440q66 0 130 15.5T576-378q29 15 46.5 43.5T640-272v112H0Zm320-400q33 0 56.5-23.5T400-640q0-33-23.5-56.5T320-720q-33 0-56.5 23.5T240-640q0 33 23.5 56.5T320-560ZM80-240h480v-32q0-11-5.5-20T540-306q-54-27-109-40.5T320-360q-56 0-111 13.5T100-306q-9 5-14.5 14T80-272v32Zm240-400Zm0 400Z"/>
                        </svg>
                        <span class="ms-3">Users</span>
                    </a>
                </li>
                @endif


                <li>
                    <a href="/reports"
                        class="flex items-center p-2 text-gray-900 rounded-lg text-white hover:bg-gray-100 hover:bg-gray-700 group hover:text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M320-480v-80h320v80H320Zm0-160v-80h320v80H320Zm-80 240h300q29 0 54 12.5t42 35.5l84 110v-558H240v400Zm0 240h442L573-303q-6-8-14.5-12.5T540-320H240v160Zm480 80H240q-33 0-56.5-23.5T160-160v-640q0-33 23.5-56.5T240-880h480q33 0 56.5 23.5T800-800v640q0 33-23.5 56.5T720-80Zm-480-80v-640 640Zm0-160v-80 80Z"/></svg>
                        <span class="ms-3 ">Reports</span>
                    </a>
                </li>

                <li>
                    <a href=""
                        class="flex items-center p-2 text-gray-900 rounded-lg text-white hover:bg-gray-100 hover:bg-gray-700 group hover:text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M440-120v-240h80v80h320v80H520v80h-80Zm-320-80v-80h240v80H120Zm160-160v-80H120v-80h160v-80h80v240h-80Zm160-80v-80h400v80H440Zm160-160v-240h80v80h160v80H680v80h-80Zm-480-80v-80h400v80H120Z"/></svg>
                        <span class="ms-3 ">Settings</span>
                    </a>
                </li>
                
            </ul>
        </div>
    </aside>