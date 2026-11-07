@props(['pollUrl', 'sendUrl', 'other', 'messages'])

<div x-data="chat(@js($pollUrl), @js($sendUrl), @js($other), @js($messages))">
    <div x-ref="box" class="h-72 overflow-y-auto space-y-2 p-3 rounded-xl bg-brand-50/50 border border-brand-100 mb-3"
         style="overflow-anchor: none">
        <p x-show="messages.length === 0" class="text-sm text-gray-500">No messages yet.</p>
        <template x-for="m in messages" :key="m.id">
            <div class="flex" :class="m.mine ? 'justify-end' : 'justify-start'">
                <div class="max-w-[80%] rounded-lg px-3 py-2 text-sm"
                     :class="m.mine ? 'bg-brand-700 text-white' : 'bg-white border border-brand-100 text-gray-800'">
                    <p class="whitespace-pre-line break-words" x-text="m.body"></p>
                    <p class="text-xs opacity-70 mt-1" x-text="(m.mine ? 'You' : other) + ' · ' + m.time"></p>
                </div>
            </div>
        </template>
    </div>

    <form @submit.prevent="send()" class="space-y-2">
        <textarea x-model="body" rows="2" maxlength="2000" placeholder="Write a message (Enter to send, Shift+Enter for a new line)"
                  @keydown.enter="if (!$event.shiftKey) { $event.preventDefault(); send(); }"
                  class="block w-full border-gray-300 focus:border-brand-500 focus:ring-brand-500 rounded-[11px] shadow-sm text-sm"></textarea>
        <p x-show="error" x-text="error" class="text-xs text-red-600"></p>
        <button type="submit" :disabled="sending || !body.trim()"
                class="inline-flex items-center px-4 py-2.5 bg-brand-700 hover:bg-brand-600 disabled:opacity-50 text-white rounded-[11px] text-sm font-semibold">
            Send
        </button>
    </form>
</div>

<script>
function chat(pollUrl, sendUrl, other, initial) {
    return {
        messages: initial, other, body: '', sending: false, error: '',
        init() {
            this.$nextTick(() => this.scrollDown());
            setInterval(() => this.poll(), 4000);
        },
        nearBottom() {
            const b = this.$refs.box;
            return b.scrollHeight - b.scrollTop - b.clientHeight < 80;
        },
        scrollDown() { const b = this.$refs.box; b.scrollTop = b.scrollHeight; },
        async poll() {
            if (document.hidden || this.sending) return;
            try {
                const r = await fetch(pollUrl, { headers: { 'Accept': 'application/json' } });
                const d = await r.json();
                const lastNew = d.length ? d[d.length - 1].id : 0;
                const lastNow = this.messages.length ? this.messages[this.messages.length - 1].id : 0;
                if (d.length >= this.messages.length && lastNew !== lastNow) {
                    const stick = this.nearBottom();
                    this.messages = d;
                    if (stick) this.$nextTick(() => this.scrollDown());
                }
            } catch (e) {}
        },
        async send() {
            const text = this.body.trim();
            if (!text || this.sending) return;
            this.sending = true; this.error = '';
            try {
                const r = await fetch(sendUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                    },
                    body: JSON.stringify({ body: text })
                });
                if (!r.ok) throw new Error();
                this.messages.push(await r.json());
                this.body = '';
                this.$nextTick(() => this.scrollDown());
            } catch (e) {
                this.error = 'Could not send. Please try again.';
            }
            this.sending = false;
        }
    }
}
</script>