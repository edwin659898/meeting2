<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> BGF Minutes </title>
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <style>
        ul {
            list-style-type: disc;
        }

        ol {
            list-style-type: lower-alpha;
        }

        @page {
            margin-top: 0px;
            margin-left: 0px;
            size: a3;
            background-image: url('storage/images/logo.png');
        }

        @media print {

            pre,
            blockquote {
                page-break-inside: avoid;
            }
        }
    </style>
</head>

<body>
    <div class="flex justify-end bg-gray-100 px-3 py-2">
        <button id="download-button" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded inline-flex items-center">
            <svg class="fill-current w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                <path d="M13 8V2H7v6H2l8 8 8-8h-5zM0 18h20v2H0v-2z" />
            </svg>
        </button>
    </div>
    <div id="minutes" class="flex items-center justify-center min-h-screen bg-gray-100 font-serif">
        <div id="removeClass" class="w-3/5 bg-white px-6 py-5">
            <div class="flex p-4">
                <div class="p-2">
                    <ul class="flex">
                        <li class="flex flex-col items-center p-2 border-l-2 border-green-200">
                            <img src="{{ asset('storage/images/logo.png') }}" width="100" height="100" alt="company logo" />
                            <span class="text-sm">
                                communications@betterglobeforestry.com
                            </span>
                        </li>
                        <li class="flex justify-center p-2 border-l-2 border-green-200">
                            <span class="text-xl font-bold mt-12">
                                Published Minutes
                            </span>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="w-full h-0.5 bg-green-500"></div>
            <div class="flex justify-between px-4 py-3">
                <div>
                    <h6 class="font-bold">Meeting Name</h6>
                    <address> {{$data['meeting']['name']}} </address>
                </div>
                <div>
                    <h6 class="font-bold">Meeting Date</h6>
                    <address> {{date('d-m-Y', strtotime($data['created_at']))}} </address>
                </div>
                <div>
                    <h6 class="font-bold">Meeting Type</h6>
                    <address> {{$data['meeting_type']}} </address>
                </div>
            </div>
            <div class="flex justify-between px-4 py-3">
                <div>
                    <h6 class="font-bold">Members Present</h6>
                    <ol class="text-sm list-disc list-inside pt-2 px-5">
                        @foreach($data['attendies'] as $attendie)
                        @if($attendie['attended'] == 'yes')
                        <li>{{$attendie['user']['name']}} - {{ App\Models\MeetingUser::where('user_id','=',$attendie['user_id'])->where('meeting_id','=',$data['meeting']['id'])->first()?->member_role}}.</li>
                        @endif
                        @endforeach
                    </ol>
                </div>
            </div>
            <div class="w-full h-0.5 bg-green-500"></div>

            @if($attendees_with_apology > 0)
            <div class="flex justify-between px-4 py-3">
                <div>
                    <h6 class="font-bold">Members Absent with Apology</h6>
                    <ol class="text-sm list-disc list-inside pt-2 px-5">
                        @foreach($data['attendies'] as $attendie)
                        @if($attendie['attended'] == 'no' && $attendie['gave_apology'] == 'Yes' || $attendie['attended'] == 'no' && $attendie['gave_apology'] == 'yes')
                        <li>{{$attendie['user']['name']}} - {{ App\Models\MeetingUser::where('user_id','=',$attendie['user_id'])->where('meeting_id','=',$data['meeting']['id'])->first()?->member_role}}.</li>
                        @endif
                        @endforeach
                    </ol>
                </div>
            </div>
            <div class="w-full h-0.5 bg-green-500"></div>
            @endif

            @if($attendees_without_apology > 0)
            <div class="flex justify-between px-4 py-3">
                <div>
                    <h6 class="font-bold">Members Absent without Apology</h6>
                    <ol class="text-sm list-disc list-inside pt-2 px-5">
                        @foreach($data['attendies'] as $attendie)
                        @if($attendie['attended'] == 'no' && $attendie['gave_apology'] == '')
                        <li>{{$attendie['user']['name']}} - {{ App\Models\MeetingUser::where('user_id','=',$attendie['user_id'])->where('meeting_id','=',$data['meeting']['id'])?->first()->member_role}}.</li>
                        @endif
                        @endforeach
                    </ol>
                </div>
            </div>
            <div class="w-full h-0.5 bg-green-500"></div>
            @endif

            @if ($invited > 0)
            <div class="flex justify-between px-4 py-3">
                <div>
                    <h6 class="font-bold">Invites</h6>
                    <ol class="text-sm list-disc list-inside pt-2 px-5">
                        @foreach($data['invites'] as $attendie)
                        <li>{{$attendie['user']['name']}}.</li>
                        @endforeach
                    </ol>
                </div>
            </div>
            <div class="w-full h-0.5 bg-green-500"></div>
            @endif

            <div class="flex justify-between px-4 py-3">
                <div>
                    <h6 class="font-bold">Meeting Started at</h6>
                    <address class="px-5"> {{date('d-m-Y H:i:s', strtotime($data['created_at']))}} </address>
                </div>
            </div>
            <div class="w-full h-0.5 bg-green-500"></div>

            <div class="flex justify-between px-4 py-5">
                <div>
                    <h6 class="font-bold">Observation from previous meeting</h6>
                    <span class="text-sm">
                        {!!$data['previous_observation']!!}
                    </span>
                </div>
            </div>
            <div class="w-full h-0.5 bg-green-500"></div>

            @foreach($data['discussions'] as $discussion)
            <div class="flex justify-between px-4 py-5">
                <div>
                    <h6 class="font-bold">{{ $discussion['department'] }}</h6>
                    <h6 class="font-bold pt-3">Items discussed</h6>
                    <div class="text-sm pt-2 px-8">
                        {!!$discussion['discussion']!!}
                    </div>
                    <h6 class="font-bold pt-3">AOB</h6>
                    <div class="text-sm pt-2 px-8">
                        {!!$discussion['AOB']!!}
                    </div>
                </div>
            </div>
            @endforeach
            <div class="w-full h-0.5 bg-green-500"></div>

            <div class="flex justify-between px-4 py-5">
                <div>
                    <h6 class="font-bold">Meeting Ended at</h6>
                    <address class="px-5"> {{$data['end_time']}} </address>
                </div>
            </div>
            <div class="w-full h-0.5 bg-green-500"></div>

            <div class="flex justify-between px-4 py-5">
                <div>
                    <h3 class="font-bold">Chairman Signature</h3>
                    <div class="text-xl italic text-indigo-500">{{$data['chairperson']['name']}}</div>
                </div>
                <div>
                    <h6 class="font-bold">Date Date</h6>
                    <div class="text-xl italic text-indigo-500">{{App\Models\MeetingUser::where('user_id',$data['chairperson'])->where('meeting_id',$data['meeting']['id'])->first()->member_role}}</div>
                </div>
            </div>
        </div>
    </div>
    <script>
        const button = document.getElementById('download-button');
        var opt = {
            margin: 0.1,
            autoPaging: 'text',
            filename: 'myfile.pdf',
            image: {
                type: 'jpeg',
                quality: 0.98
            },
            html2canvas: {
                scale: 2
            },
            jsPDF: {
                unit: 'in',
                format: 'letter',
                orientation: 'portrait'
            }
        };
        var br = {
            pagebreak: {
                mode: ['avoid-all', 'css', 'legacy'],
                before: '#page2el'
            }
        };

        function generatePDF() {
            document.getElementById("removeClass").classList.add('w-full');
            document.getElementById("removeClass").classList.remove('w-3/5');
            const element = document.getElementById('minutes');
            html2pdf().set(opt).set(br).from(element).save('Minutes.pdf');
        }
        button.addEventListener('click', generatePDF);
    </script>
</body>

</html>