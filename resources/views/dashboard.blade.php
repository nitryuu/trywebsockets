<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="text-right mb-4">
                <select name="receiver" id="receiverSelect">
                    <option value="" disabled selected>Pilih User</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="bg-white overflow-hidden shadow-sm">
                <div class="h-[calc(100vh-300px)] px-4 py-2 bg-white border-b border-gray-200 relative">
                    <div class="chatbox max-h-[calc(100%-32px)] overflow-x-hidden" />
                    <div class="absolute bottom-0 left-0 w-full h-8">
                        <div class="inline-flex items-center w-full h-full">
                            <input type="text" name="message" class="w-full h-full">
                            <button class="bg-green-400 hover:bg-green-500 px-6 h-full" id="sendBtn">
                                Send
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('script')
        <script>
            let senderId = '{{ auth()->user()->id }}'
            let receiverId = senderId == '1' ? '2' : '1'

            $(document).ready(() => {
                $('#receiverSelect').on('change', function() {
                    let id = $(this).val()
                    axios.get(`/message/${id}`)
                        .then((res) => {
                            let data = res.data.data
                            data.forEach(list => {
                                let classes = list.sender_id == '{{ auth()->user()->id }}' ?
                                    'chatbox-user' :
                                    'chatbox-not-user'
                                $('.chatbox').append(
                                    `<div class=${classes}><div><span>${list.message}</span></div></div>`
                                )
                            });
                        })
                })

                $('#sendBtn').click(() => {
                    let message = $('input[name="message"]').val()

                    axios.post('/send-message', {
                            sender_id: senderId,
                            receiver_id: receiverId,
                            message: message
                        })
                        .then(() => {
                            let message = $('input[name="message"]')
                            message.val('')
                        })
                })

                window.Echo.private(`chat.${senderId}${receiverId}`)
                    .listen('.messageSent', (e) => {
                        console.log(e)
                        let classes = e.sender_id == '{{ auth()->user()->id }}' ? 'chatbox-user' :
                            'chatbox-not-user'
                        $('.chatbox').append(`<div class=${classes}><div><span>${e.message}</span></div></div>`)
                    })
            })
        </script>
    @endpush
</x-app-layout>
