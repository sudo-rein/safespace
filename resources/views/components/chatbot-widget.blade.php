<div x-data="chatbot(@js(config('chatbot.suggestions')))" class="fixed bottom-4 right-4 z-50">
    <button @click="open = ! open"
            class="bg-brand-700 hover:bg-brand-600 text-white rounded-full px-5 py-3 shadow-lg text-sm font-semibold transition">
        <span x-text="open ? 'Close' : 'Ask SafeBot'"></span>
    </button>

    <div x-show="open" x-cloak
         class="absolute bottom-14 right-0 w-80 sm:w-96 bg-white border border-brand-100 rounded-2xl shadow-xl flex flex-col overflow-hidden">
        <div class="px-4 py-3 bg-brand-700 text-white font-semibold text-sm">
            SafeBot <span class="text-xs font-normal text-brand-200">(automated helper)</span>
        </div>

        <div class="p-3 space-y-2 overflow-y-auto text-sm" style="height: 20rem; overflow-anchor: none;" x-ref="log">
            <div class="bg-brand-50 text-ink rounded-lg px-3 py-2">Hi! I can help you report, check your reports, and answer questions. Tap a question or type your own.</div>
            <div class="flex flex-wrap gap-2" x-show="messages.length === 0">
                <template x-for="s in suggestions" :key="s">
                    <button type="button" @click="send(s)"
                            class="px-3 py-1.5 rounded-full border border-brand-200 text-brand-700 text-xs hover:bg-brand-50" x-text="s"></button>
                </template>
            </div>

            <template x-for="m in messages" :key="m.id">
                <div>
                    <div x-show="m.from === 'me'" class="flex justify-end">
                        <div class="bg-brand-700 text-white rounded-lg px-3 py-2 max-w-[85%]" x-text="m.text"></div>
                    </div>
                    <div x-show="m.from === 'bot'" class="bg-brand-50 text-ink rounded-lg px-3 py-2"
                         :class="m.crisis ? 'border border-red-400 !bg-red-50' : ''">
                        <p x-text="m.text"></p>

                        <template x-if="m.hotlines && m.hotlines.length">
                            <ul class="mt-2 text-xs space-y-0.5">
                                <template x-for="h in m.hotlines">
                                    <li><strong x-text="h.name"></strong>: <span x-text="h.contact"></span></li>
                                </template>
                            </ul>
                        </template>

                        <div class="mt-2 flex flex-wrap gap-2" x-show="m.links && m.links.length">
                            <template x-for="l in (m.links || [])">
                                <a :href="l.url" class="px-3 py-1.5 rounded-full bg-brand-700 text-white text-xs font-semibold hover:bg-brand-600" x-text="l.label"></a>
                            </template>
                        </div>

                        <div class="mt-2 flex flex-wrap gap-2" x-show="m.suggestions && m.suggestions.length">
                            <template x-for="s in (m.suggestions || [])">
                                <button type="button" @click="send(s)"
                                        class="px-3 py-1.5 rounded-full border border-brand-200 text-brand-700 text-xs hover:bg-white" x-text="s"></button>
                            </template>
                        </div>
                    </div>
                </div>
            </template>

            <div x-show="typing" class="bg-brand-50 text-gray-500 rounded-lg px-3 py-2 text-xs">SafeBot is typing…</div>
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
function chatbot(suggestions) {
    return {
        open: false, input: '', messages: [], n: 0, typing: false, suggestions,
        async send(preset = null) {
            const text = (preset ?? this.input).trim();
            if (!text || this.typing) return;
            this.messages.push({ id: ++this.n, from: 'me', text });
            this.input = '';
            this.typing = true;
            this.$nextTick(() => this.down());
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
                this.messages.push({ id: ++this.n, from: 'bot', text: d.answer, hotlines: d.hotlines,
                                     links: d.links, suggestions: d.suggestions, crisis: d.crisis });
            } catch (e) {
                this.messages.push({ id: ++this.n, from: 'bot', text: 'Sorry, something went wrong. Please try again.' });
            }
            this.typing = false;
            this.$nextTick(() => this.down());
        },
        down() { this.$refs.log.scrollTop = this.$refs.log.scrollHeight; }
    }
}
</script>