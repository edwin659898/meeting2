<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BGF-Minutes </title>
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

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
        <div id="removeClass" class="w-3/5 bg-white">
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
                    <address> Communication Meeting</address>
                </div>
                <div>
                    <h6 class="font-bold">Meeting Date</h6>
                    <address> 23/7/2039</address>
                </div>
                <div>
                    <h6 class="font-bold">Meeting Type</h6>
                    <address> Virtual</address>
                </div>
            </div>
            <div class="flex justify-between px-4 py-3">
                <div>
                    <h6 class="font-bold">Members Present</h6>
                    <ol class="text-sm list-disc list-inside pt-2 px-5">
                        <li>Michael Njogu.</li>
                        <li>Liazurah Ishugah.</li>
                        <li>Jean-paul Deprins.</li>
                    </ol>
                </div>
            </div>
            <div class="w-full h-0.5 bg-green-500"></div>

            <div class="flex justify-between px-4 py-3">
                <div>
                    <h6 class="font-bold">Members Absent with Apology</h6>
                    <ol class="text-sm list-disc list-inside pt-2 px-5">
                        <li>Michael Njogu.</li>
                        <li>Liazurah Ishugah.</li>
                        <li>Jean-paul Deprins.</li>
                    </ol>
                </div>
            </div>
            <div class="w-full h-0.5 bg-green-500"></div>

            <div class="flex justify-between px-4 py-3">
                <div>
                    <h6 class="font-bold">Members Absent without Apology</h6>
                    <ol class="text-sm list-disc list-inside pt-2 px-5">
                        <li>Michael Njogu.</li>
                        <li>Liazurah Ishugah.</li>
                        <li>Jean-paul Deprins.</li>
                    </ol>
                </div>
            </div>
            <div class="w-full h-0.5 bg-green-500"></div>

            <div class="flex justify-between px-4 py-3">
                <div>
                    <h6 class="font-bold">Invites</h6>
                    <ol class="text-sm list-disc list-inside pt-2 px-5">
                        <li>Michael Njogu.</li>
                        <li>Liazurah Ishugah.</li>
                        <li>Jean-paul Deprins.</li>
                    </ol>
                </div>
            </div>
            <div class="w-full h-0.5 bg-green-500"></div>

            <div class="flex justify-between px-4 py-3">
                <div>
                    <h6 class="font-bold">Meeting Started at</h6>
                    <address class="px-5"> 23/7/2039</address>
                </div>
            </div>
            <div class="w-full h-0.5 bg-green-500"></div>

            <div class="flex justify-between px-4 py-3">
                <div>
                    <h6 class="font-bold">Observation from previous meeting</h6>
                    <span class="text-sm">
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Assumenda in labore at iste possimus adipisci similique distinctio natus vitae velit a vero voluptates ullam ab, quo enim ea rerum earum.
                    </span>
                </div>
            </div>
            <div class="w-full h-0.5 bg-green-500"></div>

            <div class="flex justify-between px-4 py-3">
                <div>
                    <h6 class="font-bold">Forestry</h6>
                    <h6 class="font-bold pt-3">Items discussed</h6>
                    <span class="text-sm">
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Assumenda in labore at iste possimus adipisci similique distinctio natus vitae velit a vero voluptates ullam ab, quo enim ea rerum earum.
                    </span>
                    <h6 class="font-bold pt-3">AOB</h6>
                    <span class="text-sm">
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Assumenda in labore at iste possimus adipisci similique distinctio natus vitae velit a vero voluptates ullam ab, quo enim ea rerum earum.
                    </span>
                </div>
            </div>
            <div class="w-full h-0.5 bg-green-500"></div>

            <div class="flex justify-between px-4 py-3">
                <div>
                    <h6 class="font-bold">Meeting Ended at :</h6>
                    <address class="px-5"> 23/7/2039</address>
                </div>
            </div>
            <div class="w-full h-0.5 bg-green-500"></div>

            <div class="flex justify-between px-4 py-3">
                <div>
                    <h3 class="font-bold">Chairman Signature :</h3>
                    <div class="text-xl italic text-indigo-500">Michael Njogu</div>
                </div>
                <div>
                    <h6 class="font-bold">Date :</h6>
                    <div class="text-xl italic text-indigo-500">27/8/2098</div>
                </div>
            </div>
        </div>
    </div>
    <script>
        const button = document.getElementById('download-button');
        function generatePDF() {
            document.getElementById("removeClass").classList.add('w-full');
            document.getElementById("removeClass").classList.remove('w-3/5');
            const element = document.getElementById('minutes');
            html2pdf().from(element).save('Minutes.pdf');
        }
        button.addEventListener('click', generatePDF);
    </script>
</body>

</html>