<div x-data="chatbot()" class="fixed bottom-4 right-4 z-50">
    <button @click="open = ! open"
            class="bg-brand-700 hover:bg-brand-600 text-white rounded-full px-5 py-3 shadow-lg text-sm font-semibold transition">
        <span x-text="open ? 'Close' : 'Ask SafeBot'"></span>
    </button>

    <div x-show="open" x-cloak
         class="absolute bottom-14 right-0 w-80 bg-white border border-brand-100 rounded-2xl shadow-xl flex flex-col overflow-hidden">
        <div class="px-4 py-3 bg-brand-700 text-white font-semibold text-sm">
            SafeBot <span class="text-xs font-normal text-brand-200">(automated helper)</span>
        </div>

        <div class="p-3 space-y-2 overflow-y-auto text-sm" style="max-height: 18rem;" x-ref="log">
            <div class="bg-brand-50 text-ink rounded-lg px-3 py-2">Hi! Ask me how to report, what happens next, or who can see your report.</div>
            <template x-for="m in messages" :key="m.id">
                <div>
                    <div x-show="m.from === 'me'" class="flex justify-end">
                        <div class="bg-brand-700 text-white rounded-lg px-3 py-2 max-w-[85%]" x-text="m.text"></div>
                    </div>
                    <div x-show="m.from === 'bot'" class="bg-brand-50 text-ink rounded-lg px-3 py-2"
                         :class="m.crisis ? 'border border-red-400 !bg-red-50' : ''">
                        <p x-text="m.text"></p>
                        <template x-if="m.hotlines && m.hotlines.length">
                            <ul class="mt-2 text-xs">
                                <template x-for="h in m.hotlines">
                                    <li><strong x-text="h.name"></strong>: <span x-text="h.contact"></span></li>
                                </template>
                            </ul>
                        </template>
                    </div>
                </div>
            </template>
        </div>

        <form @submit.prevent="send()" class="border-t border-brand-100 p-2 flex gap-2">
            <input x-model="input" type="text" maxlength="500" placeholder="Type a question"
                   class="flex-1 border-gray-300 focus:border-brand-500 focus:ring-brand-500 rounded-[11px] text-sm">
            <button class="bg-brand-700 hover:bg-brand-600 text-white rounded-[11px] px-3 text-sm font-semibold">Send</button>
        </form>
        <p class="px-3 pb-2 text-[10px] text-gray-400">Not a person. Nothing you type here is saved.</p>
    </div>
</div>

<script>
function chatbot() {
    return {
        open: false, input: '', messages: [], n: 0,
        async send() {
            const text = this.input.trim();
            if (!text) return;
            this.messages.push({ id: ++this.n, from: 'me', text });
            this.input = '';
            try {
                const r = await fetch("{{ route('student.chatbot') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                    },
                    body: JSON.stringify({ message: text })
                });
                const d = await r.json();
                this.messages.push({ id: ++this.n, from: 'bot', text: d.answer, hotlines: d.hotlines, crisis: d.crisis });
            } catch (e) {
                this.messages.push({ id: ++this.n, from: 'bot', text: 'Sorry, something went wrong. Please try again.' });
            }
            this.$nextTick(() => { this.$refs.log.scrollTop = this.$refs.log.scrollHeight; });
        }
    }
}
</script>