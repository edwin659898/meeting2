<x-filament::page>
    <div class="border px-6 py-6 border-gray-300 shadow-sm bg-white rounded-xl filament-tables-container">
        <div class="flex justify-center font-bold mb-5">
            <img src="{{ asset('storage/images/logo.png') }}" alt="Header" class="w-16">
        </div>
        <div class="py-4">
            Meeting Date: {{ date('Y-m-d') }}
        </div>

        @if ($minute_progress == 0)
        <div class="py-4">
            <div>
                <label for="meetings" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-400">Select an option</label>
                <select id="meetings" wire:model="meeting_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option selected value="">Select the Meeting</option>
                    @foreach ($meetings as $key => $value)
                    <option value="{{$key}}">{{$value}}</option>
                    @endforeach
                </select>
                @error('meeting_id') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
            </div>
            <div class="w-full p-6 mt-6 flex justify-between min-w-sm bg-white rounded-lg border border-gray-200 shadow-md hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                <div>
                    <h5 class="mb-1 text-xl font-medium text-gray-900 dark:text-white">Teams Link</h5>
                    <span class="text-xs text-gray-500 dark:text-gray-400 text-wrap">{{$zoom_link}}</span>
                </div>
                <div>
                    <h5 class="mb-1 text-xl font-medium text-gray-900 dark:text-white">Meeting ID</h5>
                    <span class="text-xs text-gray-500 dark:text-gray-400">{{$Meeting_code}}</span>
                </div>
                <div>
                    <h5 class="mb-1 text-xl font-medium text-gray-900 dark:text-white">PassCode</h5>
                    <span class="text-xs text-gray-500 dark:text-gray-400">{{ $passcode }}</span>
                </div>
            </div>


            <div class="w-full p-6 mt-6 min-w-sm bg-white rounded-lg border border-gray-200 shadow-md hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                <h3 class="mb-5 text-lg font-medium text-gray-900 dark:text-white">Meeting type?</h3>
                <div class="flex">
                    <div class="flex items-center mr-4">
                        <input wire:model="meeting_type" id="inline-radio" type="radio" value="virtual" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-0 dark:focus:ring-blue-600 dark:ring-offset-gray-800  dark:bg-gray-700 dark:border-gray-600">
                        <label for="inline-radio" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Virtual</label>
                    </div>
                    <div class="flex items-center mr-4">
                        <input wire:model="meeting_type" id="inline-2-radio" type="radio" value="in person" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-0 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:bg-gray-700 dark:border-gray-600">
                        <label for="inline-2-radio" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">In Person</label>
                    </div>
                </div>
                @error('meeting_type') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
            </div>

            <div class="w-full p-6 mt-6 min-w-sm bg-white rounded-lg border border-gray-200 shadow-md hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                <h3 class="mb-5 text-lg font-medium text-gray-900 dark:text-white">Members</h3>
                @error('members_present') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="py-3 px-6">
                                Member Name
                            </th>
                            <th scope="col" class="py-3 px-6">
                                Title
                            </th>
                            <th scope="col" class="py-3 px-6">
                                Present
                            </th>
                            <th scope="col" class="py-3 px-6">
                                Absent with Apology
                            </th>
                            <th scope="col" class="py-3 px-6">
                                Absent without Apology
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($team_members as $member)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <th scope="row" class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $member->name }}
                            </th>
                            <td class="py-4 px-6">
                                {{ $member->meetings()->where('user_id', $member->id)->first()->pivot->member_role }}
                            </td>
                            <td class="py-4 px-6 text-center">
                                <input wire:model="members_present.{{ $member->id }}" id="horizontal-list-radio-license" type="radio" value="attended" name="{{$member->id}}" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300  dark:focus:ring-0 dark:ring-offset-gray-700 focus:ring-0 dark:bg-gray-600 dark:border-gray-500">
                            </td>
                            <td class="py-4 px-6 text-center">
                                <input wire:model="members_present.{{ $member->id }}" id="horizontal-list-radio-license" type="radio" value="not_attended_apologetic" name="{{$member->id}}" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 dark:focus:ring-0 dark:ring-offset-gray-700 focus:ring-0 dark:bg-gray-600 dark:border-gray-500">
                            </td>
                            <td class="py-4 px-6 text-center">
                                <input wire:model="members_present.{{ $member->id }}" id="horizontal-list-radio-license" type="radio" value="not_attended_non_apologetic" name="{{$member->id}}" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 dark:focus:ring-0 dark:ring-offset-gray-700 focus:ring-0 dark:bg-gray-600 dark:border-gray-500">
                            </td>
                        </tr>
                        @endforeach

                    </tbody>
                </table>

            </div>

            <div class="w-full p-6 mt-6 min-w-sm bg-white rounded-lg border border-gray-200 shadow-md hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                <h3 class="mb-5 text-lg font-medium text-gray-900 dark:text-white">Invited if Any?</h3>
                <div>
                    <label for="countries" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-400">Select a guest</label>
                    <select wire:model="invited" id="countries" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option selected value="">Select a guest</option>
                        @foreach ($users as $user)
                        <option value="{{$user}}">{{$user->name}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="py-4">
                    @foreach ($invites as $index => $value)
                    <table class="w-full text-xs text-gray-500 dark:text-gray-400">
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <td scope="row" class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $value[1] }}
                            </td>
                            <td class="py-4 px-6">
                                <span wire:click.prevent="unsetting({{$index}})" class=" text-red-600 hover:text-red-800 cursor-pointer">Remove</span>
                            </td>
                        </tr>
                    </table>
                    @endforeach
                </div>

            </div>

            <div class="flex justify-end py-4">
                <div wire:loading class="text-blue-500 text-sm font-serif">
                    Processing...
                </div>
                <x-filament::button wire:click.prevent="saveSectionOne()" wire:loading.class="hidden">Save</x-filament::button>
            </div>
        </div>
        @elseif($minute_progress == 1)
        <div class="py-4">
            <div class="w-full p-6 mt-6 min-w-sm bg-white rounded-lg border border-gray-200 shadow-md hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">Meeting Started At: {{$ongoing_meeting->created_at}}</h3>
            </div>
            <div class="w-full p-6 mt-6 min-w-sm bg-white rounded-lg border border-gray-200 shadow-md hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                <h3 class="mb-5 text-lg font-medium text-gray-900 dark:text-white">Observations Previous Meetings</h3>
                <div wire:ignore>
                    <trix-editor wire:ignore wire:model.debounce.500ms="value"></trix-editor>
                </div>
                @error('value') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="flex justify-end py-4">
            <div wire:loading wire:target="saveSectionTwo" class="text-blue-500 text-sm font-serif">
                Processing...
            </div>
            <x-filament::button wire:click.prevent="saveSectionTwo()" wire:loading.class="hidden">save observation</x-filament::button>
        </div>
        <div class="py-4">

            @if ($ongoing_meeting->discussions->count() > 0)
            <div wire:poll.2s class="w-full p-6 mt-6 min-w-sm bg-white rounded-lg border border-gray-200 shadow-md hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                <h3 class="mb-5 text-lg font-medium text-gray-900 dark:text-white">Saved discussions</h3>
                <div>
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="py-3 px-6">
                                    Department
                                </th>
                                <th scope="col" class="py-3 px-6">
                                    Discussion
                                </th>
                                <th scope="col" class="py-3 px-6">
                                    AOB
                                </th>
                                <th scope="col" class="py-3 px-6">
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($ongoing_meeting->discussions as $discussion)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <th scope="row" class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $discussion->department }}
                                </th>
                                <td class="py-4 px-6">
                                    {!! $discussion->discussion !!}
                                </td>
                                <td class="py-4 px-6">
                                    {!! $discussion->AOB !!}
                                </td>
                                <td class="py-4 px-6">
                                    <span wire:click="destroyDiscussion({{$discussion->id}})" class="cursor-pointer text-red-500 hover:text-red-800">Delete</span>
                                </td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
            @endif

            <div class="w-full p-6 mt-6 min-w-sm bg-white rounded-lg border border-gray-200 shadow-md hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                <h3 class="mb-5 text-lg font-medium text-gray-900 dark:text-white">Discussion</h3>
                <div class="py-4">
                    <label for="meetings" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-400">Select an option</label>
                    <select id="meetings" wire:model="department" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option selected value="">Select the department</option>
                        <option value="Forestry">Forestry</option>
                        <option value="Operations">Operations</option>
                        <option value="IT">IT</option>
                        <option value="HR">HR</option>
                        <option value="Monitoring & Evaluation">Monitoring & Evaluation</option>
                        <option value="Communications">Communications</option>
                        <option value="Finance & Accounts">Finance & Accounts</option>
                        <option value="Miti Magazine">Miti Magazine</option>
                        <option value="Top Management">Top Management</option>
                        <option value="sales & Marketing">Sales & Marketing</option>
                    </select>
                    @error('department') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                </div>
                <div wire:ignore class="py-4">
                    <trix-editor wire:ignore wire:model.debounce.500ms="discussion"></trix-editor>
                    @error('discussion') <span class="text-xs text-red-500">{{ $message }}</span> @enderror

                </div>
                <div wire:ignore class="py-4">
                    <trix-editor wire:ignore wire:model.debounce.500ms="AOB"></trix-editor>
                    @error('AOB') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                </div>

                <div class="flex justify-end py-4">
                    <div wire:loading wire:target="saveSectionThree" class="text-blue-500 text-sm font-serif">
                        Processing...
                    </div>
                    <x-filament::button wire:click.prevent="saveSectionThree" wire:loading.class="hidden">save discussion</x-filament::button>
                </div>
            </div>

        </div>

        <div wire:poll.5s class="w-full flex justify-between p-6 mt-6 min-w-sm bg-white rounded-lg border border-gray-200 shadow-md hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white">Meeting Ended At: {{Carbon\Carbon::now()}}</h3>
            <x-filament::button wire:click.prevent="complete" wire:loading.class="disabled">End Meeting</x-filament::button>
        </div>

        @endif

    </div>
</x-filament::page>
